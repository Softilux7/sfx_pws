<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');

/**
 * Groups Controller
 *
 */
class AuthAclController extends AuthAclAppController
{

    public $components = array(
        'HorasDiasUteis',
        'EmpresaPermission',
        'Tempo',
        'DateHourTimezone',
    );

    public function index()
    {
        $this->dataDashboard();
    }

    public function dashboard2($pagination = 20){

        $auth_user = $this->Session->read('auth_user');

        // verifica se possui permissão
        if($auth_user['User']['dashboard_monitoramento'] != 1){
            // redireciona para o dashboard principal
            $this->redirect(array('plugin' => 'auth_acl', 'controller' => 'authAcl', 'action' => 'index'));
        }

        // paginações permitidas
        $pagingAllowed = array(20, 30, 50);
        $pagination = in_array($pagination, $pagingAllowed) ? $pagination : $pagingAllowed[0];

        $dataChamado = $this->dataDashboard($pagination);
        $atendimento = array();

        // consulta o primeiro atendimento do chamado
        foreach($dataChamado['chamados'] as $key => $data){
            if($data['Chamado']['STATUS'] == 'O'){
                // consulta os dados do primeiro atendimento
                $dataAtendimento = $this->Chamado->query("SELECT DTATENDIMENTO, HRATENDIMENTO, NMATENDENTE FROM atendimentos WHERE chamado_id = {$data['Chamado']['id']} AND empresa_id = {$data['Chamado']['empresa_id']} AND ID_BASE = '{$this->matriz}' ORDER BY id ASC limit 1");
                
                $at = $dataAtendimento[0]['atendimentos'];
                
                $atendimento[$data['Chamado']['id']] = $at;
            }
        }
  
        // referente ao pré atendimento
        $preAtendimento = $this->Chamado->query("SELECT m.chamadoId, m.userId, u.group_id, m.created_at
                FROM mensagens_pre_atendimento m
                INNER JOIN users_groups u ON u.user_id = m.userId 
                WHERE m.idBase = {$this->matriz}
                ORDER BY created_at");

        $setPreAtendimento = array();
        
        foreach($preAtendimento as $data){
            $setPreAtendimento[$data['m']['chamadoId']][] = $data;
        }

        $this->set('preAtendimento', $setPreAtendimento);
        $this->set('primeiroAtendimento', $atendimento);
        $this->set('pagination', $pagination);

    }

    private function dataDashboard($limit = 10){

        $this->loadModel('Pws.Solicitacao');
        $this->loadModel('Pws.Chamado');
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        // específico para DATA VOICE
        if(EmpresaPermissionComponent::verifiqueClienteDataVoice($auth_user_group['id'], $auth_user['User']['empresa_id']) == true){
            $this->redirect(array(
                'plugin' => 'pws',
                'controller' => 'ContratoItens',
                'action' => 'index'));
        }
        
        // Lista de acordo com o o grupo do usuario
        switch ($auth_user_group['id']) {
            case '1': // Admin
            case '6':
            case '7':
            case '9':

                $conditions = array(
                    'Chamado.STATUS NOT' => array('C'),
                    'Chamado.empresa_id  ' => $this->empresa,
                    'Chamado.ID_BASE =' => $this->matriz,

                );

                if(count($this->cdCliente) > 0){
                    $conditions[] = array('Chamado.CDCLIENTE' =>  $this->cdCliente);
                }

                $chamados = $this->Chamado->find('all', array(
                    'contain' => array('Equipamento'),
					'conditions' => $conditions,
                    'limit' => $limit,
                    // 'group' => 'Chamado.id',
                    'order' => array(
                        'Chamado.id' => 'DESC'
                    ),
                ));

                $this->set('Chamados', $chamados);

                // solicitação de suprimentos
                $conditions = array(
                    'Solicitacao.empresa_id  ' => $this->empresa,
                    'Solicitacao.ID_BASE =' => $this->matriz,
                );

                if(count($this->cdCliente) > 0){
                    $conditions[] = array('Solicitacao.cliente_id' =>  $this->cdCliente);
                }

                $this->set('Solicitacoes', $this->Solicitacao->find('all', array(
					'conditions' => $conditions,
                    'limit' => $limit,
                    'order' => array(
                        'Solicitacao.created' => 'DESC'
                    )
                )));

                // seta o pré-atendimento
                $this->set('PreAtendimento', $this->getMensagensPreAtendimento($auth_user_group['id'], $auth_user['User']['id']));

                break;
            case '2': // Tecnico
                $this->set('Chamados', $this->Chamado->find('all', array(
                    'conditions' => array(
                        'Chamado.STATUS NOT' => array('O', 'C'),
                        'Chamado.NMSUPORTET' => $auth_user ['User'] ['tecnico_id'],
                        'Chamado.empresa_id' => $this->empresa,
                        'Chamado.ID_BASE' => $this->matriz
                    ),
                    'limit' => $limit,
                    // 'group' => 'Chamado.id',
                    'order' => array(
                        'Chamado.DTINCLUSAO' => 'DESC'
                    )
                )));

                $this->set('Solicitacoes', $this->Solicitacao->find('all', array(

                    'conditions' => array(
                        'Solicitacao.cliente_id' =>  $this->cliente,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    ),
                    'limit' => $limit,
                    'order' => array(
                        'Solicitacao.created' => 'DESC'
                    )
                )));
                break;

            case '3': // cliente
            case '12':
                if($auth_user['User']['empresa_id'] != 15 ){

                    $this->set('Chamados', $this->Chamado->find('all', array(
                        'contain' => array('Equipamento','Defeito'),
                        'conditions' => array(
                            'Chamado.STATUS NOT' => array('C'),
                            'Chamado.CDCLIENTE' => $this->cliente,
                            'Chamado.empresa_id  ' => $this->empresa,
                            // 'Defeito.listar' => '1',
                            'Chamado.ID_BASE =' => $this->matriz,
                        ),
                        'limit' => $limit,
                        // 'group' => 'Chamado.id',
                        'order' => array(
                            'Chamado.DTINCLUSAO' => 'DESC'
                        )
                    )));

                }else{

                    $this->set('Chamados', $this->Chamado->find('all', array(
                        'contain' => array('Equipamento','Defeito'),
                        'conditions' => array(
                            'Chamado.STATUS NOT' => array('C', 'O'),
                            'Chamado.CDCLIENTE' => $this->cliente,
                            'Chamado.empresa_id  ' => $this->empresa,
                            // 'Defeito.listar' => '1',
                            'Chamado.ID_BASE =' => $this->matriz,
                        ),
                        'limit' => $limit,
                        // 'group' => 'Chamado.id',
                        'order' => array(
                            'Chamado.DTINCLUSAO' => 'DESC'
                        )
                    )));

                }

                $this->set('Solicitacoes', $this->Solicitacao->find('all', array(
                    'conditions' => array(
                        'Solicitacao.cliente_id' =>  $this->cliente,
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    ),
                    'limit' => 10,
                    'order' => array(
                        'Solicitacao.created' => 'DESC'
                    )
                )));

                // seta o pré-atendimento
                $this->set('PreAtendimento', $this->getMensagensPreAtendimento($auth_user_group['id'], $auth_user['User']['id']));
                break;

            case '4': // operador de suprimentos
                $this->set('Chamados', $this->Chamado->find('all', array(
                    'contain' => array('Equipamento'),
                    'conditions' => array(
                        //'Chamado.CDCLIENTE' => $this->cliente,
                        'Chamado.STATUS NOT' => array('O', 'C'),
                        'Chamado.empresa_id  ' => $this->empresa,
                        'Chamado.ID_BASE =' => $this->matriz,
                    ),
                    'limit' => $limit,
                    // 'group' => 'Chamado.id',
                    'order' => array(
                        'Chamado.DTINCLUSAO' => 'DESC'
                    )
                )));

                $this->set('Solicitacoes', $this->Solicitacao->find('all', array(
                    'conditions' => array(
                        //'Solicitacao.cliente_id' =>  $this->cliente,
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                        'Solicitacao.status = ' => 'P'
                    ),
                    'limit' => $limit,
                    'order' => array(
                        'Solicitacao.created' => 'DESC'
                    )
                )));
                break;
            // operador de logística
            case 10:
                $paginate['conditions'] = array(
                    $this->Filter->getConditions(),
                    'Chamado.STATUS' => array('L', 'S'),
                    'Chamado.STATUS = ' => $status,
                    'Chamado.empresa_id' => $this->empresa,
                    'Chamado.ID_BASE' => $this->matriz,
                );
                break;
        }

        return array('chamados' => $chamados);
    }

    public function getMensagensPreAtendimento($typeUser, $userId){
    
        $this->loadModel('Pws.Chamado');
    
        if($typeUser != '6' and $typeUser != '1'){
            $and = " AND userId = {$userId}";
        }
    
        // referente ao pré atendimento
        $preAtendimento = $this->Chamado->query("SELECT count(m.id), MAX(m.message) as message,  m.*, c.SEQOS 
                                                        FROM mensagens_pre_atendimento m
                                                        INNER JOIN chamados c ON c.id = m.chamadoId
                                                        WHERE m.idBase = {$this->matriz}
                                                        {$and}
                                                        AND m.id = (SELECT MAX(mm.id) from mensagens_pre_atendimento mm where mm.chamadoId = m.chamadoId {$and} LIMIT 1)
                                                        GROUP BY chamadoId
                                                        ORDER BY created_at DESC
                                                        LIMIT 10");

        return $preAtendimento;
    
    }
}
