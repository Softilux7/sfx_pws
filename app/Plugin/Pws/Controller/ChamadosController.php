<?php
App::uses('PwsAppController', 'Pws.Controller');
App::uses('JsonResult', 'Pws.Model');
App::uses('ChamadoAvaliacao', 'Pws.Model');
App::uses('Cliente', 'Pws.Model');
App::uses('Atendimento', 'Pws.Model');

// OS 169295 - ilux
// web 1911569 - web
// andreia.furquim@teletoner.com.br
// 123456


/**
 * Chamados Controller
 *
 * @property Chamado $Chamado
 *
 */
class ChamadosController extends PwsAppController
{
    public $components = array(
        'HorasDiasUteis',
        'EmpresaPermission',
        'Tempo',
        'DateHourTimezone',
    );

    /**
     * Solicita que não seja pedido autenticação para o método avaliação
     *
     * @autor Gustavo Silva
     * @since 25/10/2017
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('avaliacao');
        $this->Auth->allow('updateChamadoStatus');
        $this->Auth->allow('sendEmailApp');
        $this->Auth->allow('downloadFile');
        $this->Auth->allow('renderFile');
    }

    public function index($status = null)
    {
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        //$this->setarDB($this->conect);
        //$this->Chamado->setDataSource('teste_cli');

        $this->Filter->addFilters('filter1');

        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->Chamado->recursive = 0;

        // para status P, adicionar os status L e S
        // $status = $status == 'P' ? array('P', 'L', 'S', 'R') : $status;
        $status = $status == 'P' ? array('P', 'L', 'S') : $status;
        
        $this->set('preAtendimento', $this->setPreAtendimento());

        $isFilter = count($this->Filter->getConditions()) > 0 ? true : false; 

        // Lista de acordo com o o grupo do usuário
        switch ($auth_user_group['id']) {
            case '1': // Admin
            case '6':
            case '4':
            case '7':
            case '9':
                
                if (($status == 'O' || $status == 'P' || $status == 'M' || $status == 'C' || $status == 'A' || $status == 'E' || $status == 'T' || $status == 'R') OR (is_array($status))) {
                    $paginate['conditions'] = array(
                        $this->Filter->getConditions(),
                        'Chamado.STATUS' => $status,
                        'Chamado.empresa_id' => $this->empresa,
                        'Chamado.ID_BASE' => $this->matriz,
                    );
                } else if ($auth_user['User']['empresa_id'] == 14) { //Solicitacao especifica para a empresa  NEOPRINT
                    $paginate['conditions'] = array(
                        $this->Filter->getConditions(),
                        'Chamado.STATUS NOT' => array('P', 'O', 'C'),
                        'Chamado.empresa_id' => $this->empresa,
                        'Chamado.CDOSTP' => 'WEB',
                        'Chamado.ID_BASE' => $this->matriz,

                    );
                } else {

                    $paginate['conditions'] = array(
                        $this->Filter->getConditions(),
                        'Chamado.empresa_id' => $this->empresa,
                        'Chamado.ID_BASE' => $this->matriz,
                    );

                    if($isFilter == false){
                        $paginate['conditions']['Chamado.STATUS NOT'] = array('O', 'C');
                    }

                }

                if(count($this->cdCliente) > 0){
                    $paginate['conditions'][] = array('Chamado.CDCLIENTE' =>  $this->cdCliente);
                }

                break;
            case '3': // Cliente
            case '12':

                // AJUSTADO PARA E EMPRESA DATA VOICE - 15
                if($auth_user['User']['empresa_id'] != 15){

                    if (($status == 'O' || $status == 'P' || $status == 'M' || $status == 'C' || $status == 'A' || $status == 'E' || $status == 'T') OR (is_array($status))) {
                        $paginate['conditions'] = array(
                            $this->Filter->getConditions(),
                            'Chamado.CDCLIENTE' =>  $this->cdCliente,
                            'Chamado.STATUS' => $status,
                            //'Chamado.TFLIBERADO' => 'S',
                            'Chamado.empresa_id' => $this->empresa,
                            // 'Defeito.listar' => '1',
                            'Chamado.ID_BASE' => $this->matriz
                        );
                        
                    } else if ($auth_user['User']['empresa_id'] == 14) { //Solicitacao especifica para a empresa  NEOPRINT
                        $paginate['conditions'] = array(
                            $this->Filter->getConditions(),
                            'Chamado.STATUS NOT' => array('P', 'O', 'C'),
                            'Chamado.CDCLIENTE' =>  $this->cdCliente,
                            'Chamado.empresa_id' => $this->empresa,
                            'Chamado.TFLIBERADO' => 'S',
                            'Chamado.CDOSTP' => 'WEB',
                            // 'Defeito.listar' => '1',
                            'Chamado.ID_BASE' => $this->matriz
                        );
                    } else {

                        $paginate['conditions'] = array(
                            $this->Filter->getConditions(),
                            // 'Chamado.STATUS NOT' => array('O', 'C'),
                            'Chamado.CDCLIENTE' =>  $this->cdCliente,
                            'Chamado.empresa_id' => $this->empresa,
                            'Chamado.TFLIBERADO' => 'S',
                            // 'Defeito.listar' => '1',
                            'Chamado.ID_BASE' => $this->matriz
                        );

                        if($isFilter == false){
                            $paginate['conditions']['Chamado.STATUS NOT'] = array('O', 'C');
                        }
                        
                    }
                }else{

                    // ===========
                    // para o cliente 15 - DATA VOICE
                    // os clientes não podem visualizar chamados concluídos
                    // ===========

                    $paginate['conditions'] = array(
                        $this->Filter->getConditions(),
                        'Chamado.CDCLIENTE' =>  $this->cdCliente,
                        'Chamado.STATUS' => $status,
                        'Chamado.empresa_id' => $this->empresa,
                        // 'Defeito.listar' => '1',
                        'Chamado.ID_BASE' => $this->matriz,
                        'Chamado.STATUS NOT' => array('O')
                    );

                }
                
                break;
            case '2': // Técnico
                if (($status == 'O' || $status == 'P' || $status == 'M' || $status == 'C' || $status == 'A' || $status == 'E' || $status == 'T' || $status == 'R') OR (is_array($status))) {
                    $paginate['conditions'] = array(
                        $this->Filter->getConditions(),
                        'Chamado.NMSUPORTET' => $auth_user['User']['tecnico_id'],
                        'Chamado.STATUS' => $status,
                        'Chamado.TFLIBERADO' => 'S',
                        'Chamado.empresa_id' => $this->empresa,
                        'Chamado.ID_BASE' => $this->matriz
                    );
                } else if ($auth_user['User']['empresa_id'] == 14) { //Solicitacao especifica para a empresa  NEOPRINT
                    $paginate['conditions'] = array(
                        $this->Filter->getConditions(),
                        'Chamado.STATUS NOT' => array('P', 'O', 'C'),
                        'Chamado.NMSUPORTET' => $auth_user['User']['tecnico_id'],
                        'Chamado.empresa_id' => $this->empresa,
                        'Chamado.TFLIBERADO' => 'S',
                        'Chamado.CDOSTP' => 'WEB',
                        'Chamado.ID_BASE' => $this->matriz
                    );
                } else {
                    $paginate['conditions'] = array(
                        $this->Filter->getConditions(),
                        // 'Chamado.STATUS NOT' => array('O', 'C'),
                        'Chamado.NMSUPORTET' => $auth_user['User']['tecnico_id'],
                        'Chamado.empresa_id' => $this->empresa,
                        'Chamado.TFLIBERADO' => 'S',
                        'Chamado.ID_BASE' => $this->matriz
                    );

                    if($isFilter == false){
                        $paginate['conditions']['Chamado.STATUS NOT'] = array('O', 'C');
                    }
                }
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
            default:
                $this->redirect(array(
                    'controller' => 'ContratoItens',
                    'action' => 'index',
                ));
        }

        $this->set('STATUS_SEVERIDADE', $this->statusSeveridade(null));

        $paginate['order'] = 'Chamado.id DESC';
        $paginate['limit'] = 15;
        $paginate['group'] = 'Chamado.id';
        $paginate['recursive'] = '0';
        $this->paginate = $paginate;

        $this->set('Chamados', $this->paginate());
        $this->set('checkStatusAtendido', $this->checkStatusAtendido());
    }

    private function setPreAtendimento(){

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

        return $setPreAtendimento;
    }

    /**
     * add method
     *
     * @param null $id
     * @return void
     * @throws Exception
     */
    public function add($id = null)
    {
        $errors = array();
        //$this->setarDB($this->conect);
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        $this->loadModel('Pws.Equipamento');
        $this->loadModel('Pws.TecnicoTerritorio');
        $this->loadModel('Pws.Cliente');
        $this->loadModel('Pws.Defeito');
        $this->loadModel('Pws.Medidores');
        $this->loadModel('Pws.ConfiguracoesChamado');
        //$this->setarDB($this->conect);

        $this->loadModel('AuthAcl.User');
        $this->Session->write('salvo', 0);

        // verifica se é um tecnico do tipo terceirizado
        if($auth_user['User']['tecnico_terceirizado'] == true){
            $this->Session->setFlash('Acesso negado: Você não tem permissão');
            $this->redirect(array(
                'controller' => 'Chamados',
                'action' => 'index',
            ));
        }


        $equip = $this->Equipamento->find('first', array('conditions' => array(
            'Equipamento.ID_BASE' => $this->matriz,
            'Equipamento.id' => $id
        )));
        if (empty($equip)) {
            $this->Session->setFlash('Erro: Equipamento não encontrado.');
            $this->redirect(array(
                'controller' => 'ContratoItens',
                'action' => 'index',
            ));
        }
        $this->set('equip', $equip);

        $chamados = $this->Chamado->find('all', array(
            'conditions' => array(
                'Chamado.ID_BASE' => $this->matriz,
                'Chamado.CDEQUIPAMENTO' => $equip['Equipamento']['CDEQUIPAMENTO']
            ),
            'order' => array(
                'Chamado.id' => 'DESC'
            )
        ));
        $this->set('chamados', $chamados);

        switch ($auth_user_group['id']) {
            case '3': //Cliente
                $this->set('defeitos', $this->Defeito->find('list', array(
                    'fields' => array(
                        'Defeito.CDDEFEITO',
                        'Defeito.NMDEFEITO'
                    ), 'conditions' => array(
                        'Defeito.TFINATIVO' => 'N',
                        'Defeito.listar' => '1',
                        'Defeito.ID_BASE' => $this->matriz
                    ),
                    'order' => array(
                        'Defeito.NMDEFEITO' => 'ASC'
                    )
                )));
                break;
            default:
                $this->set('defeitos', $this->Defeito->find('list', array(
                    'fields' => array(
                        'Defeito.CDDEFEITO',
                        'Defeito.NMDEFEITO'
                    ), 'conditions' => array(
                        'Defeito.TFINATIVO' => 'N',
                        // 'Defeito.listar' => '1',
                        'Defeito.ID_BASE' => $this->matriz
                    ),
                    'order' => array(
                        'Defeito.NMDEFEITO' => 'ASC'
                    )
                )));
                break;
        }

        //Novo campo no chamado para informar o tipo de ordem de serviço.
        $this->set('modalidadesOrdemDeServico', array(
            '1' => 'Assistência/Chamado Técnico',
            '0' => 'Suprimento',
            '2' => 'Solicitação (Retirada/Instalação/Outros)'
        ));

        // Dados Equipamento
        // TODO:: AVALIAR
        // if ($auth_user['User']['filial_id'] == 0) {
        //     $this->request->data('Chamado.empresa_id', $auth_user['User']['empresa_id']);
        // } else {
        //     $this->request->data('Chamado.empresa_id', $auth_user['User']['filial_id']);
        // }

        $this->request->data('Chamado.empresa_id', $equip['Equipamento']['empresa_id']);

        $this->request->data('Chamado.ID_BASE', $this->matriz);
        $this->request->data('Chamado.CDEQUIPAMENTO', $equip['Equipamento']['CDEQUIPAMENTO']);
        $this->request->data('Chamado.CIDADE', $equip['Equipamento']['CIDADE']);
        $this->request->data('Chamado.ENDERECO', $equip['Equipamento']['ENDERECO']);
        $this->request->data('Chamado.CDEMPRESA', $equip['Equipamento']['CDEMPRESA']);
        $this->request->data('Chamado.COMPLEMENTO', $equip['Equipamento']['COMPLEMENTO']);
        $this->request->data('Chamado.NUM', $equip['Equipamento']['NUM']);
        $this->request->data('Chamado.BAIRRO', $equip['Equipamento']['BAIRRO']);
        $this->request->data('Chamado.UF', $equip['Equipamento']['UF']);
        $this->request->data('Chamado.CEP', $equip['Equipamento']['CEP']);
        $this->request->data('Chamado.DEPARTAMENTO', $equip['Equipamento']['DEPARTAMENTO']);
        $this->request->data('Chamado.CDTERRITORIO', $equip['Equipamento']['CDTERRITORIO']);
        $this->request->data('Chamado.SEQCONTRATO', $equip['Equipamento']['SEQCONTRATO']);
        $this->request->data('Chamado.PRIORIDADE', $equip['Equipamento']['TEMPOATENDIMENTO']);
        $this->request->data('Chamado.EQUIPCLI', 'C');
        $this->request->data('Chamado.NMSUPORTEA', 'WEB');
        $this->request->data('Chamado.ATUALIZADO', 1);

        // Seleciona um tecnico, padrão do território ou cadastro do usuário.
        if (empty($auth_user['User']['tecnico_id'])) {
            $tecnico = $this->TecnicoTerritorio->find('first', array('conditions' => array(
                'TecnicoTerritorio.CDTERRITORIO = ' => $equip['Equipamento']['CDTERRITORIO'],
                'TecnicoTerritorio.TFPADRAO = ' => 'S',
                'TecnicoTerritorio.empresa_id = ' => $this->matriz
            )));
        } else {
            $tecnico = $this->TecnicoTerritorio->find('first', array('conditions' => array(
                'TecnicoTerritorio.CDTERRITORIO = ' => $equip['Equipamento']['CDTERRITORIO'],
                'TecnicoTerritorio.NMSUPORTE = ' => $auth_user['User']['tecnico_id'],
                'TecnicoTerritorio.empresa_id = ' => $this->matriz
            )));
        }
        $this->set('tecnico', $tecnico);

        if ($tecnico['TecnicoTerritorio']['NMSUPORTE'] == '') {
            $this->Session->setFlash('ERRO: Não existe um técnico padrão para este equipamento! Favor Entrar em contato Conosoco!');
            $this->redirect(array(
                'controller' => 'Chamados',
                'action' => 'index',
            ));
        }

        $this->request->data('Chamado.NMSUPORTET', $tecnico['TecnicoTerritorio']['NMSUPORTE']);

        // Dados Clientes
        if ($equip['Equipamento']['CDCLIENTEENT'] > 0) {
            $cliente = $this->Cliente->find('all', array('conditions' => array(
                'Cliente.CDCLIENTE' => $equip['Equipamento']['CDCLIENTEENT'],
                'Cliente.empresa_id' => $this->matriz
            )));
        } else {
            $cliente = $this->Cliente->find('all', array('conditions' => array(
                'Cliente.CDCLIENTE' => $equip['Equipamento']['CDCLIENTE'],
                'Cliente.empresa_id' => $this->matriz
            )));
        }

        $this->set('cliente', $cliente);
        $this->request->data('Chamado.NMCLIENTE', $cliente[0]['Cliente']['NMCLIENTE']);
        $this->request->data('Chamado.CDCLIENTE', $cliente[0]['Cliente']['CDCLIENTE']);

        // Dados da O.S
        $this->request->data('Chamado.CDOSTP', 'WEB'); // Tipo de O.S Web deve estar cadastrado no sistema

        //        if ($auth_user['User']['empresa_id'] == 9) { // tecnocopy
        //            $this->request->data('Chamado.TFLIBERADO', 'N');
        //            $this->request->data('Chamado.STATUS', 'M');
        //        } else {
        //            $this->request->data('Chamado.TFLIBERADO', 'S');
        //            $this->request->data('Chamado.STATUS', 'P');
        //        }

        // TFLIBERADO representa a liberação do chamado 'S' está liberado
        $this->request->data('Chamado.TFLIBERADO', 'S');

        // Agora o usuario pode definir o status padrão da abertura

        $_configuracao_chamado = $this->ConfiguracoesChamado->find('first', array(
            'conditions' => array(
                'ConfiguracoesChamado.ID_BASE' => $this->matriz,
            ),
            'order' => array(
                'ConfiguracoesChamado.id' => 'DESC'
            )
        ));

        if (!empty($_configuracao_chamado)) {
            $this->request->data('Chamado.STATUS', $_configuracao_chamado['ConfiguracoesChamado']['status_padrao_abertura_chamado']);
            $this->request->data('Chamado.CDSTATUS', $_configuracao_chamado['ConfiguracoesChamado']['cd_status_abertura_chamado']);
        } else {
            // Novo status no sistema A = Abertura
            $this->request->data('Chamado.STATUS', 'A');
            $this->request->data('Chamado.CDSTATUS', '0');
        }

        $this->request->data('Chamado.TPCHAMADO', 'A');
        $this->request->data('Chamado.CDCLIENTEENT', $equip['Equipamento']['CDCLIENTEENT']);

        if ($equip['Equipamento']['SEQCONTRATO'] > 0) {
            $this->request->data('Chamado.TPORCATEND', 'A');
        } else {
            $this->request->data('Chamado.TPORCATEND', 'O');
        }

        // local de instalação
        $this->request->data('Chamado.LOCALINSTAL', $equip['Equipamento']['LOCALINSTAL']);

        $dtinclusao = date('Y-m-d');
        $this->request->data('Chamado.DTINCLUSAO', $dtinclusao);
        $hrinclusao = date('H:i');
        $this->request->data('Chamado.HRINCLUSAO', $hrinclusao);

        // -------------------------- Previsão de Atendimento -------------------- //
        $tpatendimento = $equip['Equipamento']['TEMPOATENDIMENTO'];
        $tfdiasuteis = $equip['Equipamento']['TFDIASUTEIS'];
        $tfhorasuteis = $equip['Equipamento']['TFHORASUTEIS'];

        if ($tfhorasuteis != 'S') {
            HorasDiasUteisComponent::$HORAFIN2 = '24:00';
            HorasDiasUteisComponent::$HORAFIN1 = '12:00';
            HorasDiasUteisComponent::$HORAINI1 = '00:00';
            HorasDiasUteisComponent::$HORAINI2 = '12:00';
        } else {
            HorasDiasUteisComponent::$HORAFIN2 = $equip['Equipamento']['HORAFIN2'];
            HorasDiasUteisComponent::$HORAFIN1 = $equip['Equipamento']['HORAFIN1'];
            HorasDiasUteisComponent::$HORAINI1 = $equip['Equipamento']['HORAINI1'];
            HorasDiasUteisComponent::$HORAINI2 = $equip['Equipamento']['HORAINI2'];
        }

        if ($tfdiasuteis == 'S' or $tfhorasuteis == 'S') {

            $srt = strlen($tpatendimento);
            if ($srt == '1') {
                $prazo = '0' . $tpatendimento . ":00";
            } else {
                $prazo = $tpatendimento . ":00";
            }

            $dataAtual = date('Y-m-d H:i');
            $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal($dataAtual, $prazo);
            // $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal ( '02/04/2015 15:00', $prazo );

            $dataPrevista = date('Y-m-d', $dtPrevisao);
            $horaPrevista = date('H:i', $dtPrevisao);

            $diaSemana = date('w', $dtPrevisao);
            $a1 = '';
            if ($diaSemana == 0 || $diaSemana == 6) {
                // se SABADO OU DOMINGO, SOMA 01
                $a1 = '0';
            } else {
                for ($i = 0; $i <= 12; $i++) {
                    if ($dataPrevista == HorasDiasUteisComponent::Feriados(date('Y'), $i)) {
                        $a1 = '1';
                    }
                }
            }
            switch ($a1) {
                case '0':
                    $diaSemana = date('w', $dtPrevisao);
                    if ($diaSemana == 6) {
                        $dtPrevisao = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dtPrevisao);
                    } else {
                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                    }
                    break;
                case '1':
                    $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);

                    $diaSemanaF = date('w', strtotime($dataPrevista));
                    if ($diaSemanaF == 6) {
                        $dtPrevisao = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dtPrevisao);
                    } else {
                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                    }
                    break;
                default:
                    $dataPrevista;
                    break;
            }

            //$this->request->data('Chamado.DTPREVENTREGA', $dataPrevista);
            //$this->request->data('Chamado.HRPREVENTREGA', $horaPrevista);
        } else {
            $srt = strlen($tpatendimento);
            if ($srt == '1') {
                $prazo = '0' . $tpatendimento . ":00";
            } else {
                $prazo = $tpatendimento . ":00";
            }

            $dataAtual = date('Y-m-d H:i');
            $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal($dataAtual, $prazo);

            // $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal ( '02/04/2015 15:00', $prazo );

            $dataPrevista = date('Y-m-d', $dtPrevisao);
            $horaPrevista = date('H:i', $dtPrevisao);
        }
        $this->request->data('Chamado.DTPREVENTREGA', $dataPrevista);
        $this->request->data('Chamado.HRPREVENTREGA', $horaPrevista);
        // ------------------------- Fim calcula data Prevista Atendimento //

        

        if ($this->request->is('post')) {
            //Remove espaços informados no email
            $this->request->data['Chamado']['EMAIL'] = str_replace(' ', '', $this->request->data['Chamado']['EMAIL']);

            // ajusta os dados do telefone
            $fone = explode(' ', $this->request->data['Chamado']['FONE']);

            $this->request->data['Chamado']['DDD'] = isset($fone[0]) ? str_replace(array('(', ')'), '', $fone[0]) : '';
            $this->request->data['Chamado']['FONE'] = isset($fone[1]) ? $fone[1] : '';

            $validateFiles = true;
            $files = array('file1', 'file2', 'file3');
            $json = array();

            foreach($files as $data){
                if($_FILES[$data]['error'] == 0){
                    // valida exteção do arquivo
                    if($this->validationFile($_FILES[$data]) === false){
                        // remove o arquivo que não foi validado
                        unset($_FILES[$data]);
                        $validateFiles = false;
                        $this->Session->setFlash('ERRO: Anexos inválidos!');
                    }else{
                        $json[] = $_FILES[$data]['name'];
                    }
                }else{
                    unset($_FILES[$data]);
                }
            }

            if(count($json) > 0){
                // salva na base os arquivos anexados
                $this->request->data('Chamado.attachments', json_encode($json));
            }

            $this->Chamado->create();
            $this->Chamado->set($this->request->data);

            if ($this->Chamado->validates() && $validateFiles == true) {
                $chamadoIsSaved = $this->Chamado->save();
                $numeroOS = $this->Chamado->id;

                if ($chamadoIsSaved) {
                    $this->Session->setFlash('Ordem de Serviço foi salva com sucesso!');

                    $defeito = $this->Defeito->find('first', array(
                        'fields' => array(
                            'Defeito.NMDEFEITO'
                        ),
                        'conditions' => array(
                            'Defeito.CDDEFEITO =' => $this->request->data['Chamado']['CDDEFEITO'],
                            'Defeito.empresa_id =' => $this->matriz
                        ),
                        'order' => array(
                            'Defeito.NMDEFEITO' => 'ASC'
                        )
                    ));

                    // faz upload de arquivos anexados
                    foreach($_FILES as $file){
                        // faz o upload dos arquivos
                        $this->uploadFile($file, $this->matriz, $numeroOS);
                    }

                    self::enviaEmail('', '', '', $numeroOS, 0, 0, 10, $this->request->data['Chamado']['TIPO_OS']);

                    //------------------------------- Inicio envio de email
                    // Listar usuários tipo email Abertura de Chamado
                    // $tpemails = $this->User->query("SELECT c.user_name, c.user_email FROM tpemails a
                    //                     INNER JOIN users_tpemails b ON (b.tpemail_id = a.id)
                    //                     INNER JOIN users c ON (c.id= b.user_id)
                    //                     INNER JOIN users_empresas emps ON (emps.user_id = c.id)
                    //                     WHERE a.id = 1 and emps.empresa_id in ({$this->matriz})");

                    // $enviado = 0;
                    // foreach ($tpemails as $tpemail) {
                    //     if (self::enviaEmail($tpemail['c']['user_email'], 'Nova Abertura de Chamado Nº ' . $numeroOS, $this->request->data, $numeroOS, $defeito, $equip)) {
                    //         $enviado++;
                    //     }
                    // }

                    // // Envio de email copia do cliente
                    // if ($enviado > 0) {
                    //     if (self::enviaEmail($this->request->data['Chamado']['EMAIL'], 'Cópia Abertura de Chamado Nº ' . $numeroOS, $this->request->data, $numeroOS, $defeito, $equip)) {
                    //         $this->Session->setFlash('Email Enviado com Sucesso!');
                    //     } else {
                    //         $errors[] = $this->Session->setFlash('ERRO: Falha ao encaminhar email para: ' . $this->request->data['Chamado']['EMAIL']);
                    //     }
                    // } else {
                    //     $errors[] = $this->Session->setFlash('ERRO: Não foi possível encaminhar email.');
                    // }

                    $this->Session->write('salvo', 1);
                    $salvo = 1;

                    $this->redirect(array(
                        'controller' => 'Chamados',
                        'action' => 'view', $numeroOS, $salvo
                    ));
                } else {
                    $errors = $this->Chamado->validationErrors;
                }
            } else {
                $errors = $this->Chamado->validationErrors;
            }
        }

        $this->set('errors', $errors);
    }

    private function validationFile($file){

        // Array com as extensões permitidas
        $extensoes_permitidas = array('.jpg', '.JPEG', '.txt', '.png', '.pdf', '.doc', '.docx');

        // Faz a verificação da extensão do arquivo enviado
        $extensao = strrchr($file['name'], '.');

        // Faz a validação do arquivo enviado
        return in_array($extensao, $extensoes_permitidas) === true ? true : false;
        
    }

    private function uploadFile($file, $idBase, $idChamado){
        
        $path = "/var/www/html/files//os_{$idBase}/";
        // $path = $_SERVER['DOCUMENT_ROOT'] . "/" . $idBase . "/";

        // verifica se é para criar a pasta de idbase
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        // veririca se é para criar a pasta do chamado
        if (!is_dir($path . $idChamado)) {
            mkdir($path . $idChamado, 0775, true);
        }

        // monta o caminho e nome do arquivo
        $uploadfile = $path . $idChamado . "/" . basename($file['name']);
        
        // meve o arquivo para a pasta de destino
        if(move_uploaded_file($file['tmp_name'], $uploadfile) === true){
            echo 'deu certo';
        }else{            
            echo 'não deu';
        }
    }

    public function downloadFile($name, $id, $idBase){

        $this->autoRender   = false;
        $this->layout       = false;

        $path = "/var/www/html/files//os_{$idBase}/{$id}/${name}";
        // $path = $_SERVER['DOCUMENT_ROOT'] . "/" . $idBase . "/". $id . "/" . $name;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Content-Type: application/force-download");
        header('Content-Disposition: attachment; filename=' . urlencode(basename($name)));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        ob_clean();
        flush();

        readfile($path);
        exit;


    }

    public function renderFile($name, $id, $idBase){

        $this->autoRender   = false;
        $this->layout       = false;

        $path = "/var/www/html/files//os_{$idBase}/{$id}/${name}";

        // Get the mimetype for the file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);  // return mime type ala mimetype extension
        $mime_type = finfo_file($finfo, $path);
        finfo_close($finfo);
        
        switch ($mime_type){
            case "image/jpeg":
                // Set the content type header - in this case image/jpg
                header('Content-Type: image/jpeg');
                
                // Get image from file
                $img = imagecreatefromjpeg($path);
                
                // Output the image
                imagejpeg($img);
                
                break;
            case "image/png":
                // Set the content type header - in this case image/png
                header('Content-Type: image/png');
                
                // Get image from file
                $img = imagecreatefrompng($path);
                
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($img, 0, 0, 0);
                
                // removing the black from the placeholder
                imagecolortransparent($img, $background);
                
                // turning off alpha blending (to ensure alpha channel information 
                // is preserved, rather than removed (blending with the rest of the 
                // image in the form of black))
                imagealphablending($img, false);
                
                // turning on alpha channel information saving (to ensure the full range 
                // of transparency is preserved)
                imagesavealpha($img, true);
                
                // Output the image
                imagepng($img);
                
                break;
            case "image/gif":
                // Set the content type header - in this case image/gif
                header('Content-Type: image/gif');
                
                // Get image from file
                $img = imagecreatefromgif($imgpath);
                
                // integer representation of the color black (rgb: 0,0,0)
                $background = imagecolorallocate($img, 0, 0, 0);
                
                // removing the black from the placeholder
                imagecolortransparent($img, $background);
                
                // Output the image
                imagegif($img);
                
                break;
        }
        
        // Free up memory
        imagedestroy($img);

    }

    /**
     * Enviar email
     */

    private function enviaEmail($to = null, $subject = null, $chamado, $numeroOS, $defeito, $equip, $edit = null, $cdTipoOs = null)
    {
        App::uses('CakeEmail', 'Network/Email');
        App::uses('Setting', 'AuthAcl.Model');
        //        //$this->setarDB($this->conect);
        $Setting = new Setting();
        $auth_user = $this->Session->read('auth_user');
        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));

        if (!empty($general)) {
            $general = unserialize($general['Setting']['setting_value']);
        }

        try {
            // $email->addTo($to);
            // $email->config('default');
            // $email->emailFormat('html');
            // $email->from(array(
            //     $general['Setting']['email_address'] => __('Pws - Portal Web')
            // ));
            // $email->subject($subject);

            // switch ($edit) {
            //     case 1:
            //         $email->template('chamado_edit', 'chamado_edit');
            //         $email->viewVars(array('chamado' => $chamado, 'numero' => $numeroOS, 'defeito' => $defeito, 'equipamento' => $equip, 'auth_user' => $auth_user));
            //         break;
            //     case 2:
            //         $email->template('chamado_peca', 'chamado_peca');
            //         $email->viewVars(array('chamado' => $chamado, 'numero' => $numeroOS, 'defeito' => $defeito, 'equipamento' => $equip, 'auth_user' => $auth_user));
            //         break;
            //     case 3:
            //         $email->template('chamado_avaliacao', 'chamado_avaliacao');
            //         $email->viewVars(array('chamado' => $chamado, 'numero' => $numeroOS, 'defeito' => $defeito, 'equipamento' => $equip, 'auth_user' => $auth_user));
            //         break;
            //     default:
            //         $email->template('chamado', 'chamado');
            //         $email->viewVars(array('chamado' => $chamado, 'numero' => $numeroOS, 'defeito' => $defeito, 'equipamento' => $equip, 'auth_user' => $auth_user));
            //         break;
            // }


            switch ($edit) {
                // TODO::
                case 1:
                    $email = new CakeEmail();
                    $email->addTo($to);
                    $email->config('default');
                    $email->emailFormat('html');
                    $email->from(array(
                        $general['Setting']['email_address'] => __('Pws - Portal Web')
                    ));
                    $email->subject($subject);
                    $email->template('chamado_edit', 'chamado_edit');
                    $email->viewVars(array('chamado' => $chamado, 'numero' => $numeroOS, 'defeito' => $defeito, 'equipamento' => $equip, 'auth_user' => $auth_user));
                    $email->send();
                    break;
                case 2:
                    $email = new CakeEmail();
                    $email->addTo($to);
                    $email->config('default');
                    $email->emailFormat('html');
                    $email->from(array(
                        $general['Setting']['email_address'] => __('Pws - Portal Web')
                    ));
                    $email->subject($subject);
                    $email->template('chamado_peca', 'chamado_peca');
                    $email->viewVars(array('chamado' => $chamado, 'numero' => $numeroOS, 'defeito' => $defeito, 'equipamento' => $equip, 'auth_user' => $auth_user));
                    $email->send();
                    break;
                case 3:
                    $email = new CakeEmail();
                    $email->addTo($to);
                    $email->config('default');
                    $email->emailFormat('html');
                    $email->from(array(
                        $general['Setting']['email_address'] => __('Pws - Portal Web')
                    ));
                    $email->subject($subject);
                    $email->template('chamado_avaliacao', 'chamado_avaliacao');
                    $email->viewVars(array('chamado' => $chamado, 'numero' => $numeroOS, 'defeito' => $defeito, 'equipamento' => $equip, 'auth_user' => $auth_user));
                    $email->send();
                    break;  
                case 10:
                case 11: 
                    
                    $ch = curl_init('https://api.psfx.com.br/send-email/os');
                    // $ch = curl_init('http://pre.api.psfx.cloud.prodb.com.br:3302/send-email/os');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('seqos' => $numeroOS, 'abertura' => $edit == 11 ? "N" : "S", 'cdTipo' => $cdTipoOs)));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'apiVersion: v3'));
                    $result = curl_exec($ch);
                    
                    curl_close($ch);

                    break;
                    
            }

            return true;
        } catch (SocketException $e) {
            $this->log($e->getMessage());
            return false;
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */

    public function view($id = null, $salvo = null)
    {
        $errors = array();
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        $this->Chamado->id = $id;
        if (!$this->Chamado->exists()) {
            $errors[] = $this->Session->setFlash('Erro: Chamado não encontrado.');
        }

        // AJUSTADO PARA EMPRESA DATA VOICE
        // Clientes não podem visualizar chamados concluídos
        if($auth_user['User']['empresa_id'] == 15 and $auth_user_group['id'] == 3){
            echo '<h3 style="margin-top:50px;margin-left:40px;color:#cc0000">Atenção, você não tem permissão para acessar essa informação</h3>';
        }

        $this->set('errors', $errors);

        $this->set('salvo', $salvo);

        $chamado = $this->Chamado->find('first', array('conditions' => array(
            'Chamado.ID_BASE' => $this->matriz,
            'Chamado.id' => $id
        )));

        

        $this->loadModel('Pws.Atendimento');
        $atendimento = $this->Atendimento->find(
            'all',
            array(
                'conditions' => array(
                    'Atendimento.SEQOS' => $chamado['Chamado']['SEQOS'],
                    'Atendimento.ID_BASE' => $this->matriz,
                ),
                'order' => array('Atendimento.DTATENDIMENTO' => 'DESC')
            )
        );
        $this->set('atendimentos', $atendimento);

        // Lista de acordo com o o grupo do usuário
        switch ($auth_user_group['id']) {
            case '1': // Admin
            case '6':
            case '4':
            case '7':
            case '9':
                $this->set('chamado', $chamado);
                break;

            case '3': // Cliente
            case '12':
                // Multi cliente - Acessar
                if ($auth_user['User']['cliente_id'] == -1) {
                    $i = 0;
                    foreach ($auth_user['Cliente'] as $cliente) {
                        if ($chamado['Chamado']['CDCLIENTE'] == $cliente['CDCLIENTE']) {
                            $i++;
                        }
                    }
                    if ($i > 0) {
                        $this->set('chamado', $chamado);
                    } else {
                        $errors[] = $this->Session->setFlash('Erro: Chamado não encontrado.');
                    }
                } else {
                    //todo: verificando o motivo do erro
                    if ($chamado ['Chamado'] ['CDCLIENTE'] == $auth_user['User']['cliente_id']) {
                        $this->set('chamado', $chamado);
                    } else {
                        $errors[] = $this->Session->setFlash('Erro: Chamado não encontrado.');
                    }
                }

                break;

            case '2': // Técnico
                if ($chamado['Chamado']['NMSUPORTET'] == $auth_user['User']['tecnico_id']) {
                    $this->set('chamado', $chamado);
                } else {
                    $errors[] = $this->Session->setFlash('Erro: Chamado não encontrado.');
                }
                break;

            default:
                $this->redirect(array(
                    'controller' => 'Chamados',
                    'action' => 'index',
                ));
        }

        // define o status de severidade
        $this->set('STATUS_SEVERIDADE', $this->statusSeveridade($chamado['Defeito']['CD_SEVERIDADE']));

        if (count($errors) > 0) {
            $this->redirect(array(
                'controller' => 'Chamados',
                'action' => 'index',
            ));
        }

    }

    // public function calcSlaChamado($chamado){


    //     $id = $chamado['Chamado']['id'];

    //     // define a data de abertura do chamado
    //     $openingDate = strtotime("{$chamado['Chamado']['DTPREVENTREGA']} {$chamado['Chamado']['HRPREVENTREGA']}");
        
    //     $result = $this->Chamado->query("SELECT m.userId, u.group_id, m.created_at
    //                                             FROM mensagens_pre_atendimento m
    //                                             INNER JOIN users_groups u ON u.user_id = m.userId 
    //                                             WHERE m.chamadoId = {$id}
    //                                             AND m.idBase = {$this->matriz}
    //                                             ORDER BY created_at");
        
    //     // define o tamanho do array
    //     $size = count($result) - 1;
    //     $sumTime = 0;
        
    //     // a primeira pergunta sempre será da revenda, então só começará a contabilizar quando o cliente responder
    //     if($size >= 1){

    //         $count = 0;

    //         foreach($result as $data){

    //             // verifica se é do tipo usuário
    //             if($data['u']['group_id'] == '3'){
                    
    //                 // pega a data e hora de interação do cliente
    //                 $dateClient = strtotime($data['m']['created_at']);

    //                 // verifica se possui a próxima interação que será da revenda
    //                 if($count + 1 <= $size){
    //                     // define a data da revenda
    //                     $dateResale = strtotime($result[$count + 1]['m']['created_at']);
    //                 }else{
    //                     // pega a data e hora atual
    //                     $dateResale = strtotime(date("Y-m-d H:i:s"));
    //                 }

    //                 // calcula diferença em timestamp
    //                 $dateDiff = $dateResale - $dateClient;

    //                 // adiciona a soma total
    //                 $sumTime += $dateDiff;

    //             }

    //             $count++;
    //         }
            
    //     }

    //     return date("d/m/Y H:i",($openingDate + $sumTime));
    // }

    /**
     * @autor Gustavo Silva
     * @since 13/04/2020
     */
    private function statusSeveridade($id)
    {
        $status = array();

        $status[0] = '0 - Não controla';
        $status[1] = '1 - Crítico -Interrupção total dos serviços/falha grave';
        $status[2] = '2 - Urgente - Serviçõs interrompidos não crítico';
        $status[3] = '3 - Médio - Problemas que podem ocasionar a interrupção dos serviços';
        $status[4] = '4 - Baixo dúvidas';

        return $id != null ? $status[$id] : $status;
    }

    /**
     * Editar Chamado
     *
     * @autor Wagner Martins
     * @param string $id
     * @return void
     * @throws Exception
     */
    public function edit($id = null)
    {
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        $this->set('auth_user', $auth_user);

        $this->loadModel('Pws.Atendimento');
        $this->loadModel('Pws.Equipamento');
        $this->loadModel('Pws.Medidores');
        $this->loadModel('Pws.Status');
        $this->loadModel('Pws.EquipMedItG');
        $this->loadModel('Pws.User');
        $this->loadModel('Pws.Tecnico');
        App::import('Vendor', 'AuthAcl.functions');

        $errors = array();

        // Listar usuários tipo email Abertura de Chamado
        // $tpemails = $this->User->query("SELECT c.user_name, c.user_email FROM tpemails a
        //                                 INNER JOIN users_tpemails b ON (b.tpemail_id = a.id)
        //                                 INNER JOIN users c ON (c.id = b.user_id)
        //                                 INNER JOIN users_empresas emps ON (emps.user_id = c.id)
        //                                 WHERE a.id = 3 and emps.empresa_id in ({$this->matriz})");

        //$this->setarDB($this->conect);

        $this->Chamado->id = $id;
        $chamado = $this->Chamado->read(null, $id);
        
        $equip = $this->Equipamento->find('all', array('conditions' =>
        array(
            'Equipamento.CDEQUIPAMENTO' => $chamado['Chamado']['CDEQUIPAMENTO'],
            'Equipamento.empresa_id' => $this->matriz
        )));


        $produto_ftecIt = $this->Equipamento->query("
        SELECT  f.CDPRODUTO,(SELECT n.NMPRODUTO from produtos n 
            where n.CDPRODUTO = f.CDPRODUTO and n.ID_BASE =  e.ID_BASE) as NMPRODUTO
            FROM    equipamentos e
            INNER JOIN produtos p ON p.CDPRODUTO = e.CDPRODUTO and p.ID_BASE = e.ID_BASE
            INNER JOIN ficha_tecnica_it f ON f.CDFICHATECPROD = p.CDFICHATECPROD and f.ID_BASE = e.ID_BASE
            WHERE   e.CDEQUIPAMENTO = {$chamado['Chamado']['CDEQUIPAMENTO']} and e.ID_BASE = {$this->matriz}
        ");

        $this->set('produto_ftecIt', $produto_ftecIt);

        if (!$this->Chamado->exists()) {
            $errors[] = $this->Session->setFlash('Erro: Chamado não encontrado.');
        }

        if ($chamado['Chamado']['ATUALIZADO'] != 0) {
            $errors[] = $this->Session->setFlash('ATENÇÂO: Chamado ainda não foi sincronizado.');
        }

        if ($chamado['Chamado']['TFLIBERADO'] != 'S') {
            $errors[] = $this->Session->setFlash('ATENÇÂO: Chamado precisa de liberação!');
        }


        self::editStatus($chamado);

        // email cadastrado na O.S
        $emailCliente = $chamado['Chamado']['EMAIL'];


        $this->set('medidores', $this->Medidores->find('list', array(
            'fields' => array(
                'Medidores.CDMEDIDOR',
                'Medidores.CDMEDIDOR'
            ), 'conditions' => array(
                'Medidores.CDEQUIPAMENTO' => $chamado['Chamado']['CDEQUIPAMENTO'],
                'Medidores.ID_BASE' => $this->matriz
            ),
            'order' => array(
                'Medidores.CDMEDIDOR' => 'ASC'
            )
        )));

        $atendimento = $this->Atendimento->find('all', array(
            'conditions' => array(
                'Atendimento.SEQOS' => $chamado['Chamado']['SEQOS'],
                'Atendimento.empresa_id' => $this->empresa
            ),
            'order' => array('Atendimento.DTATENDIMENTO' => 'DESC')
        ));

        if ($chamado['ChamadoTipo']['TFUTILIZACONFIG'] == 'S') {
            $horaIni = $chamado['ChamadoTipo']['HORAINI1'];
            $horaIni2 = $chamado['ChamadoTipo']['HORAINI2'];
            $horaFim = $chamado['ChamadoTipo']['HORAFIN1'];
            $horaFim2 = $chamado['ChamadoTipo']['HORAFIN2'];
            $diasUteis = $chamado['ChamadoTipo']['TFDIASUTEIS'];
            $horasUteis = $chamado['ChamadoTipo']['TFHORASUTEIS'];
        } else {
            $horaIni = $chamado['Equipamento']['HORAINI1'];
            $horaIni2 = $chamado['Equipamento']['HORAINI2'];
            $horaFim = $chamado['Equipamento']['HORAFIN1'];
            $horaFim2 = $chamado['Equipamento']['HORAFIN2'];
            $diasUteis = $chamado['Equipamento']['TFDIASUTEIS'];
            $horasUteis = $chamado['Equipamento']['TFHORASUTEIS'];
        }

        $dtAberturaOS = $chamado['Chamado']['DTINCLUSAO'];
        $horaAberturaOS = $chamado['Chamado']['HRINCLUSAO'];
        $t24h = '24:00';
        $t00h = '00:00';

        $this->set('atendimentos', $atendimento);

        // INICIO -- Preenche a data do primeiro atendimento
        if ($chamado['Chamado']['DTATENDIMENTO1'] == '0000-00-00 00:00:00' || $chamado['Chamado']['DTATENDIMENTO1'] == '') {
            $atendimento1 = $this->Atendimento->find('first', array(
                'conditions' => array(
                    'Atendimento.SEQOS' => $chamado['Chamado']['SEQOS'],
                    'Atendimento.empresa_id' => $this->empresa,
                    'Atendimento.OBSERVACAO != ' => 'Abertura da O.S.'
                ),
                'order' => array('Atendimento.DTATENDIMENTO' => 'ASC')
            ));

            if (!empty($atendimento1['Atendimento']['DTATENDIMENTO'])) {

                $this->request->data('Chamado.DTATENDIMENTO1', $atendimento1['Atendimento']['DTATENDIMENTO']);
                $this->request->data('Chamado.HRATENDIMENTO1', $atendimento1['Atendimento']['HRATENDIMENTO']);

                $dtAtendimento1 = $atendimento1['Atendimento']['DTATENDIMENTO'];
                $hrAtendimento1 = $atendimento1['Atendimento']['HRATENDIMENTO'];

                // Tempo Resposta do primeiro atendimento
                $qtdDias1Atend = TempoComponent::qtDias(mktime(0, 0, 0, date("m", strtotime($dtAberturaOS)), date("d", strtotime($dtAberturaOS)), date("Y", strtotime($dtAberturaOS))), mktime(0, 0, 0, date("m", strtotime($dtAtendimento1)), date("d", strtotime($dtAtendimento1)), date("Y", strtotime($dtAtendimento1))), $diasUteis) - 1;
                //echo "<br />Dias 1 atendimento: $qtdDias1Atend- $dtAberturaOS -  $data1Atendi ";
                $tempoResposta = TempoComponent::difHoras($horaAberturaOS, $hrAtendimento1, $qtdDias1Atend, $horasUteis, $horaIni, $horaIni2, $horaFim, $horaFim2, $t24h, $t00h);
                //echo "<br /> Horas 1 atendimento $tempoResposta";
                $this->request->data('Chamado.TEMPORESPOSTA', $tempoResposta);
                // Fim Tempo Resposta do primeiro atendimento


            } else {
                $this->request->data('Chamado.DTATENDIMENTO1', date('Y-m-d'));
                $this->request->data('Chamado.HRATENDIMENTO1', date('H:i'));

                $dtAtendimento1 = date('Y-m-d');
                $hrAtendimento1 = date('H:i');

                // Tempo Resposta do primeiro atendimento
                $qtdDias1Atend = TempoComponent::qtDias(mktime(0, 0, 0, date("m", strtotime($dtAberturaOS)), date("d", strtotime($dtAberturaOS)), date("Y", strtotime($dtAberturaOS))), mktime(0, 0, 0, date("m", strtotime($dtAtendimento1)), date("d", strtotime($dtAtendimento1)), date("Y", strtotime($dtAtendimento1))), $diasUteis) - 1;
                //echo "<br />Dias 1 atendimento: $qtdDias1Atend- $dtAberturaOS -  $data1Atendi ";
                $tempoResposta = TempoComponent::difHoras($horaAberturaOS, $hrAtendimento1, $qtdDias1Atend, $horasUteis, $horaIni, $horaIni2, $horaFim, $horaFim2, $t24h, $t00h);
                //echo "<br /> Horas 1 atendimento $tempoResposta";
                $this->request->data('Chamado.TEMPORESPOSTA', $tempoResposta);

                // Fim Tempo Resposta do primeiro atendimento
            }
        } else {
            $dtAtendimento1 = $chamado['Chamado']['DTATENDIMENTO1'];
            $hrAtendimento1 = $chamado['Chamado']['HRATENDIMENTO1'];

            // Tempo Resposta do primeiro atendimento

            $qtdDias1Atend = TempoComponent::qtDias(mktime(0, 0, 0, date("m", strtotime($dtAberturaOS)), date("d", strtotime($dtAberturaOS)), date("Y", strtotime($dtAberturaOS))), mktime(0, 0, 0, date("m", strtotime($dtAtendimento1)), date("d", strtotime($dtAtendimento1)), date("Y", strtotime($dtAtendimento1))), $diasUteis) - 1;
            //echo "<br />Dias 1 atendimento: $qtdDias1Atend- $dtAberturaOS -  $data1Atendi ";
            $tempoResposta = TempoComponent::difHoras($horaAberturaOS, $hrAtendimento1, $qtdDias1Atend, $horasUteis, $horaIni, $horaIni2, $horaFim, $horaFim2, $t24h, $t00h);
            //echo "<br /> Horas 1 atendimento $tempoResposta";
            $this->request->data('Chamado.TEMPORESPOSTA', $tempoResposta);

            // Fim Tempo Resposta do primeiro atendimento
        }

        // FIM -- Preenche a data do primeiro atendimento
        self::getStatus();

        self::getStatusCancelamento();

        $dadosEmail = array();
        //dados do chamado atendimento
        $dadosEmail['NMCLIENTE'] = $chamado['Chamado']['NMCLIENTE'];
        $dadosEmail['SEQOS'] = $chamado['Chamado']['SEQOS'];
        $dadosEmail['DTINCLUSAO'] = date('d/m/Y', strtotime($chamado['Chamado']['DTINCLUSAO']));
        $dadosEmail['HRINCLUSAO'] = date('H:i', strtotime($chamado['Chamado']['HRINCLUSAO']));
        $dadosEmail['DTALTERACAO'] = date('d/m/Y H:i');
        $dadosEmail['LOCALINSTAL'] = $equip[0]['Equipamento']['LOCALINSTAL'];
        $dadosEmail['DEPARTAMENTO'] = $equip[0]['Equipamento']['DEPARTAMENTO'];
        $dadosEmail['CDEQUIPAMENTO'] = $chamado['Chamado']['CDEQUIPAMENTO'];
        $dadosEmail['SERIE'] = $equip[0]['Equipamento']['SERIE'];
        $dadosEmail['PATRIMONIO'] = $equip[0]['Equipamento']['PATRIMONIO'];
        $dadosEmail['MODELO'] = $equip[0]['Equipamento']['MODELO'];
        $dadosEmail['TECNICO'] = $chamado['Chamado']['NMSUPORTET'];
        $dadosEmail['STATUS'] = $chamado['Chamado']['STATUS'];

        $dadosEmail['url'] = siteURL() . "pws/chamados/view/" . $this->Chamado->id;

        // técino terceirizado
        if($auth_user['User']['tecnico_terceirizado'] == true){

            $nmAtendente = $chamado['Chamado']['NMSUPORTET'];
            
            // verifica se já possui algum atendimento deste técnico neste chamado e retorna os valores
            $query = $this->User->query("SELECT VALATENDIMENTO, VALKM FROM atendimentos WHERE chamado_id = '{$this->Chamado->id}' AND NMATENDENTE = '{$nmAtendente}' AND ID_BASE = '{$this->matriz}' ORDER BY id DESC LIMIT 1");
            
            $this->set('detailLastService', count($query) > 0 ? $query[0]['atendimentos'] : array());
        }

        //$this->request->data('Atendimento.MEDIDOR', 0);
        //$this->request->data('Atendimento.MEDIDORDESC', 0);

        if ($this->request->is('post') || $this->request->is('put')) {

            // verifica se é um post de cancelamento de chamado
            if ($this->request->data['idCancelamento']) {

                $this->request->data['Chamado']['STATUS']   = 'C';
                $this->request->data['Chamado']['CDSTATUS'] = $this->request->data['idCancelamento'];

                // salva os dados do chamado cancelado
                if ($this->Chamado->save($this->request->data)) {

                    echo 'ok';
                }

                exit();
            }

            $this->request->data['Chamado']['TFVISITA'] = 'S';

            // Validações de gravação do atendimento do chamado
            // Dados da Viagem
            if (empty($this->request->data['Atendimento']['PLACAVEICULO'])) {
                unset($this->request->data['Atendimento']['PLACAVEICULO']);
            }
            if (empty($this->request->data['Atendimento']['VALESTACIONAMENTO'])) {
                unset($this->request->data['Atendimento']['VALESTACIONAMENTO']);
            }else{
                $this->request->data['Atendimento']['VALESTACIONAMENTO'] = str_replace(',', '.', $this->request->data['Atendimento']['VALESTACIONAMENTO']);
            }

            if (empty($this->request->data['Atendimento']['KMINICIAL'])) {
                unset($this->request->data['Atendimento']['KMINICIAL']);
            }
            if (empty($this->request->data['Atendimento']['KMFINAL'])) {
                unset($this->request->data['Atendimento']['KMFINAL']);
            }
            if (empty($this->request->data['Atendimento']['VALPEDAGIO'])) {
                unset($this->request->data['Atendimento']['VALPEDAGIO']);
            }else{
                $this->request->data['Atendimento']['VALPEDAGIO'] = str_replace(',', '.', $this->request->data['Atendimento']['VALPEDAGIO']);
            }

            if (empty($this->request->data['Atendimento']['VALOUTRASDESP'])) {
                unset($this->request->data['Atendimento']['VALOUTRASDESP']);
            }else{
                $this->request->data['Atendimento']['VALOUTRASDESP'] = str_replace(',', '.', $this->request->data['Atendimento']['VALOUTRASDESP']);
            }

            if (!empty($this->request->data['Atendimento']['DTVIAGEMINI'])) {
                if (
                    strpos($this->request->data['Atendimento']['DTVIAGEMINI'], "y") !== false
                    || strpos($this->request->data['Atendimento']['DTVIAGEMINI'], "m") !== false
                    || strpos($this->request->data['Atendimento']['DTVIAGEMINI'], "d") !== false
                ) {
                    $errors[] = $this->Session->setFlash('Data/Hora inicial viagem inválida!');
                }

                //
                // $dtviagemini = substr($this->request->data['Atendimento']['DTVIAGEMINI'], 0, 10); // 2016-02-15
                // $horaviagemini = substr($this->request->data['Atendimento']['DTVIAGEMINI'], 11, 16); // 2016-02-15

                // monta a data inicial
                $dtviagemini = substr($this->request->data['Atendimento']['DTVIAGEMINI'], 0, 10); // 2016-02-15
                $dtviagemini = explode("/", $dtviagemini);
                $dtviagemini = $dtviagemini[2] . "-".$dtviagemini[1]."-".$dtviagemini[0];
                
                $horaviagemini = substr($this->request->data['Atendimento']['DTVIAGEMINI'], 11, 16); // 2016-02-15

                $this->request->data['Atendimento']['DTVIAGEMINI'] = $dtviagemini;
                $this->request->data['Atendimento']['HRVIAGEMINI'] = $horaviagemini;
            }

            if (!empty($this->request->data['Atendimento']['DTVIAGEMFIN'])) {
                if (
                    strpos($this->request->data['Atendimento']['DTVIAGEMFIN'], "y") !== false
                    || strpos($this->request->data['Atendimento']['DTVIAGEMFIN'], "m") !== false
                    || strpos($this->request->data['Atendimento']['DTVIAGEMFIN'], "d") !== false
                ) {
                    $errors[] = $this->Session->setFlash('Data/Hora final viagem inválida!');
                }

                // monta a data final
                $dtviagemfim = substr($this->request->data['Atendimento']['DTVIAGEMFIN'], 0, 10); // 2016-02-15
                $dtviagemfim = explode("/", $dtviagemfim);
                $dtviagemfim = $dtviagemfim[2] . "-".$dtviagemfim[1]."-".$dtviagemfim[0];

                $horaviagemfim = substr($this->request->data['Atendimento']['DTVIAGEMFIN'], 11, 16); // 2016-02-15
                
                $this->request->data['Atendimento']['DTVIAGEMFIN'] = $dtviagemfim;
                $this->request->data['Atendimento']['HRVIAGEMFIN'] = $horaviagemfim;
            }

            if (count($errors) > 0) {
                $this->redirect(array(
                    'controller' => 'Chamados',
                    'action' => 'edit',
                    $id
                ));
            }

            //Tempo de viagem
            if (!empty($horaviagemini)) {

                $horainiv = substr("$horaviagemini", 0, 2);
                $horafinv = substr("$horaviagemfim", 0, 2);
                $mininiv = substr("$horaviagemini", 3, 2);
                $minfimv = substr("$horaviagemfim", 3, 2);
                $hora_em_minv = ($horafinv - $horainiv) * 60;

                $tempov = $hora_em_minv - $mininiv + $minfimv;

                // converte para gravar a nova forma no banco
                $hora = sprintf("%02d", floor($tempov/60));
                $minuto = sprintf("%02d", $tempov%60);

                $this->request->data['Atendimento']['TEMPOVIAGEM'] = "{$hora}:{$minuto}";
            }
            $this->request->data['Atendimento']['ATUALIZADO'] = '1';

            //$this->request->data['Atendimento']['empresa_id'] = $this->empresa;

            if ($auth_user['User']['filial_id'] == 0) {
                //$this->request->data('Chamado.empresa_id', $auth_user['User']['empresa_id']);
                $this->request->data['Atendimento']['empresa_id'] = $auth_user['User']['empresa_id'];
            } else {
                $this->request->data['Atendimento']['empresa_id'] = $auth_user['User']['filial_id'];
            }

            $this->request->data['Atendimento']['ID_BASE'] = $this->matriz;

            //Tempo de atendimento
            $horainicial = $this->request->data['Atendimento']['HRATENDIMENTO'];
            $horafinal = $this->request->data['Atendimento']['HRATENDIMENTOFIN'];
            $horaini = substr("$horainicial", 0, 2);
            $horafin = substr("$horafinal", 0, 2);
            $minini = substr("$horainicial", 3, 2);
            $minfim = substr("$horafinal", 3, 2);
            $hora_em_min = ($horafin - $horaini) * 60;

            $tempoatend = $hora_em_min - $minini + $minfim;
            $this->request->data['Atendimento']['TEMPOATENDIMENTO'] = $tempoatend;
            $this->request->data['Atendimento']['chamado_id'] = $this->Chamado->id;
            $this->request->data['Atendimento']['NMATENDENTE'] = $chamado['Chamado']['NMSUPORTET'];
            $this->request->data['Atendimento']['DATAHORA'] = date('m/d/Y H:i:s');
            $this->request->data['Atendimento']['DTMEDIDORDESC'] = date('Y-m-d');
            $this->request->data['Atendimento']['ERR'] = '';

            if ((int) $this->request->data['Atendimento']['MEDIDOR'] >= 0) {
                $this->request->data['EquipMedItG']['ERR'] = '';
                $this->request->data['EquipMedItG']['CDEQUIPAMENTO'] = $chamado['Chamado']['CDEQUIPAMENTO'];
                $this->request->data['EquipMedItG']['CDMEDIDOR'] = $this->request->data['Atendimento']['CDMEDIDOR'];;
                $this->request->data['EquipMedItG']['MEDIDOR'] = $this->request->data['Atendimento']['MEDIDOR'];
                $this->request->data['EquipMedItG']['MEDIDORDESC'] = $this->request->data['Atendimento']['MEDIDORDESC'];
                $this->request->data['EquipMedItG']['TPLEITURADESC'] = 'L';
                $this->request->data['EquipMedItG']['TFANALISE'] = 'N';
                $this->request->data['EquipMedItG']['TPLEITURA'] = 'Sistema';
                $this->request->data['EquipMedItG']['INFORMANTE'] = 'WEB';
                $this->request->data['EquipMedItG']['ID_BASE'] = $this->matriz;
                $this->request->data['EquipMedItG']['ATUALIZADO'] = '1';


                if ($auth_user['User']['filial_id'] == 0) {
                    //$this->request->data('Chamado.empresa_id', $auth_user['User']['empresa_id']);
                    $this->request->data['EquipMedItG']['empresa_id'] = $auth_user['User']['empresa_id'];
                } else {
                    $this->request->data['EquipMedItG']['empresa_id'] = $auth_user['User']['filial_id'];
                }

                $this->request->data['EquipMedItG']['DTLEITURA'] = date('Y-m-d');
                $this->request->data['EquipMedItG']['DATAHORA'] = date('d/m/Y H:i:s');
            }else{
                $errors[] = 'Valor medidor inválido';
            }

            if($this->request->data['Atendimento']['CDMEDIDOR'] == ''){
                $errors[] = 'Medidor inválido';
            }

            if ($this->request->data['Chamado']['STATUS'] == 'O') {

                $datep1 = date('Y-m-d');
                $qtdDias2Atend = TempoComponent::qtDias(mktime(0, 0, 0, date("m", strtotime($dtAberturaOS)), date("d", strtotime($dtAberturaOS)), date("Y", strtotime($dtAberturaOS))), mktime(0, 0, 0, date("m", strtotime($datep1)), date("d", strtotime($datep1)), date("Y", strtotime($datep1))), $diasUteis) - 1;
                //echo "<br /> Dias 2 atendimento $qtdDias2Atend ";
                $tempoSolucao = TempoComponent::difHoras($horaAberturaOS, $horafinal, $qtdDias2Atend, $horasUteis, $horaIni, $horaIni2, $horaFim, $horaFim2, $t24h, $t00h);
                //echo "<br /> Horas 2 atendimento $tempoSolucao";
                $this->request->data['Chamado']['TEMPOSOLUCAO'] = $tempoSolucao;

                $this->request->data['Chamado']['DTATENDIMENTO'] = $datep1;
                $this->request->data['Chamado']['HRATENDIMENTO'] = date('H:i');

                // Encaminha email para a avaliação do chamado
                // $this->sendEmail($this->request->data['Chamado']['id'], $chamado['Chamado']['CDCLIENTE'], $chamado['Chamado']['EMAIL']);
            }

            // verifica se é tecnico terceirizado
            if($auth_user['User']['tecnico_terceirizado'] == true){

                // valida o valor atendimento
                if (empty($this->request->data['Atendimento']['VALATENDIMENTO'])) {
                    $errors[] = 'Valor de atendimento inválido';
                }else{
                    $this->request->data['Atendimento']['VALATENDIMENTO'] = str_replace(',', '.', $this->request->data['Atendimento']['VALATENDIMENTO']);
                }

                // valida o deslocamento
                if (empty($this->request->data['Atendimento']['VALKM'])) {
                    $errors[] = 'Valor de desclocamento inválido';
                }else{
                    $this->request->data['Atendimento']['VALKM'] = str_replace(',', '.', $this->request->data['Atendimento']['VALKM']);
                }

            }else{

                $tecnicoModel = new Tecnico();

                // consulta o id do técnico
                $nmsuporte = $auth_user['User']['tecnico_id'];
                
                // consulta os dados que serão utilizados no calculo
                $query = $tecnicoModel->query("SELECT * FROM tecnicos WHERE NMSUPORTE = '{$nmsuporte}' AND ID_BASE = '$this->matriz'");

                if(count($query)){

                    // dados do calculo
                    $dataTecnico = $query[0]['tecnicos'];

                    // calculo para tempo de atendimento                    
                    $this->request->data['Atendimento']['VALATENDIMENTO'] = round($tempoatend * ($dataTecnico['VALHRATENDIMENTO']/60), 2);

                    // km percorrido
                    $kmPercorrido = ($this->request->data['Atendimento']['KMFINAL'] - $this->request->data['Atendimento']['KMINICIAL']);

                    // calculo para km deslocado
                    $this->request->data['Atendimento']['VALKM'] = round($kmPercorrido * ($dataTecnico['VALKMATENDIMENTO']/60), 2);

                }

            }

            //Remover validações antes de salvar o chamado
            unset($this->Chamado->validate['EMAIL']);
            unset($this->Chamado->validate['FONE']);
            unset($this->Chamado->validate['DDD']);
            unset($this->Chamado->validate['CONTATO']);
            unset($this->Chamado->validate['OBSDEFEITOCLI']);
            // Salva dados do chamado
            
            if(count($errors) <= 0){

                // ajusta para o follow-up do técnico
                $this->request->data['Chamado']['OBSDEFEITOATS'] = $this->request->data['Chamado']['OBSDEFEITOATS'] . ' // ' . $this->request->data['Chamado']['OBSDEFEITOATS_NEW'];
                unset($this->request->data['Chamado']['OBSDEFEITOATS_NEW']);

                if ($this->Chamado->save($this->request->data)) {

                    //App::import('Vendor', 'AuthAcl.functions');
                    $this->Atendimento->save($this->request->data['Atendimento']);

                    if ($this->request->data['Atendimento']['MEDIDOR'] >= 0) {
                        $this->EquipMedItG->save($this->request->data['EquipMedItG']);
                    }

                    // Dados para enviar email para o cliente.

                    $dadosEmail['OBSERVACAO'] = $this->request->data['Atendimento']['OBSERVACAO'];
                    $dadosEmail['DTATENDIMENTO'] = date('d/m/Y', strtotime($this->request->data['Atendimento']['DTATENDIMENTO']));
                    $dadosEmail['TEMPOATENDIMENTO'] = $tempoatend;
                    
                    // TODO:: 
                    if (isset($this->request->data['Peca']) && count($this->request->data['Peca']) > 0) {
                        $dadosEmail['Peca'] = $this->request->data['Peca'];
                        
                        // Listar usuários tipo email Abertura de Chamado
                        $tpemails = $this->User->query("SELECT c.user_name, c.user_email FROM tpemails a
                                                        INNER JOIN users_tpemails b ON (b.tpemail_id = a.id)
                                                        INNER JOIN users c ON (c.id = b.user_id)
                                                        INNER JOIN users_empresas emps ON (emps.user_id = c.id)
                                                        WHERE a.id = 3 and emps.empresa_id in ({$this->matriz})");
                    
                        // Inicio envio de email
                        $enviado = 0;
                        // forech usuários
                        foreach ($tpemails as $tpemail) {
                            if (self::enviaEmail($tpemail['c']['user_email'], 'Alteração no Chamado Nº ' . $this->Chamado->id, $dadosEmail, $this->Chamado->id, 0, 0, 1)) {
                                $enviado++;
                            }
                        }

                        // envio de email copia do cliente
                        if ($enviado > 0) {
                            $emailCliente = explode(';', $emailCliente);
                            if ($emailCliente[0] != '') {
                                self::enviaEmail($emailCliente[0], 'Atendimento de Chamado Nº ' . $this->Chamado->id, $dadosEmail, $this->Chamado->id, 0, 0, 1);
                                $this->Session->setFlash('Email Enviado com Sucesso!');
                            }
                        } else {
                            $errors[] = 'Erro ao enviar email para o cliente';
                        }
                    }else{
                        
                        // NOVO ENVIO
                        self::enviaEmail('', '', '', $this->Chamado->id, 0, 0, 11);
                    }

                    $this->Session->setFlash('SUCESSO: Chamado Alterado com Sucesso!!');

                    $this->Session->write('salvo', 1);
                    $salvo = 1;

                    $this->redirect(array(
                        'action' => 'view', $id, $salvo
                    ));
                } else {
                    $errors = $this->Chamado->validationErrors;
                    $this->set('chamado', $chamado);
                    $this->set('errors', $errors);
                }
            }else{
                $this->set('chamado', $chamado);
            }
        } else {

            // Lista de acordo com o o grupo do usuário
            switch ($auth_user_group['id']) {
                case '1': // Admin
                case '6': // Admin revenda
                case '7':
                case '2': // tecnico
                    $this->set('chamado', $chamado);
                    $this->request->data = am($this->request->data, $chamado);
                    break;
                default:
                    $errors[] = $this->Session->setFlash('Atenção: Você não tem permissão de alterar este chamado.');
                    $this->redirect(array(
                        'controller' => 'Chamados',
                        'action' => 'index',
                    ));
            }

            if (count($errors) > 0) {
                $this->redirect(array(
                    'controller' => 'Chamados',
                    'action' => 'index',
                ));
            }
        }
        $this->set('errors', $errors);
        $this->set('checkStatusAtendito', $this->checkStatusAtendido());
    }

    /**
     *
     */

    private function getStatus()
    {
        //$this->setarDB($this->conect);
        $this->loadModel('Pws.Status');
        $this->set('status', $this->Status->find('list', array(
            'fields' => array(
                'Status.CDSTATUS',
                'Status.NMSTATUS'
            ),
            'conditions' => array(
                'Status.empresa_id' => $this->matriz
            )
        )));
        $this->set(compact("status"));
    }

    private function getStatusCancelamento()
    {
        //$this->setarDB($this->conect);
        $this->loadModel('Pws.Status');
        $this->set('statusCancelamento', $this->Status->find('list', array(
            'fields' => array(
                'Status.CDSTATUS',
                'Status.NMSTATUS'
            ),
            'conditions' => array(
                'Status.empresa_id' => $this->matriz,
                'Status.TIPO' => 'C'
            )
        )));

        $this->set(compact("statusCancelamento"));
    }


    private function editStatus($chamado = null)
    {
        if ($chamado != null) {
            $options = [];

            switch ($chamado['Chamado']['STATUS']) {
                case 'A':
                    $options = array(
                        'A' => 'Abertura',
                        'E' => 'Despachado',
                        'M' => 'Em Manutenção',
                        'C' => 'Cancelado',
                        'O' => 'Concluído'
                    );
                    break;
                case 'E':
                    $options = array(
                        'E' => 'Despachado',
                        'M' => 'Em Manutenção'
                    );
                    break;
                case 'M':
                    $options = array(
                        'M' => 'Em Manutencao',
                        'P' => 'Pendente',
                        'O' => 'Concluido',
                    );
                    break;
                case 'P':
                    $options = array(
                        'P' => 'Pendente',
                        'E' => 'Despachado',
                        'M' => 'Em Manutenção',
                        'O' => 'Concluído',
                    );
                    break;
                case 'C':
                    $options = array(
                        'C' => 'Cancelado'
                    );
                    break;
                case 'O':
                    $options = array(
                        'O' => 'Concluído',
                    );
                    break;
            }

            if (!empty($options)) {
                $this->set('chamado_status', $options);
            }
        }
    }

    private function checkStatusAtendido(){

        $auth_user = $this->Session->read('auth_user');

        return $auth_user['EmpresaSelected']['Empresa']['versao'] == 1 ? true : false;

    }

    /**
     *
     */

    public function listar_status_json()
    {
        $this->layout = null;
        //$this->setarDB($this->conect);
        $this->loadModel('Pws.Status');
        // if ($this->request->is('ajax')) {
            $this->set('status', $this->Status->find('list', array(
                'fields' => array('Status.CDSTATUS', 'Status.NMSTATUS'), 'conditions' =>
                array(
                    'Status.TIPO' => $this->request['url']['estadoId'],
                    'Status.empresa_id' => $this->matriz,
                    'Status.TFINATIVO' => 'N' //Define se o campo está inativo
                ),
                'recursive' => -1
            )));
        // }
    }

    public function listar_status_json_cancelamento()
    {
        $this->layout       = null;
        $this->loadModel('Pws.Status');

        $this->set('status', $this->Status->find('list', array(
            'fields' => array('Status.CDSTATUS', 'Status.NMSTATUS'), 'conditions' =>
            array(
                'Status.TIPO' => 'C',
                'Status.empresa_id' => $this->request['url']['idBase'],
                'Status.TFINATIVO' => 'N' //Define se o campo está inativo
            ),
            'recursive' => -1
        )));
    }


    /**
     * Avaliação do chamado concludído
     *
     * @autor Gustavo Silva
     * @since 23/10/2017
     */
    public function avaliacao()
    {

        // método responsável por POST dos dados
        if ($this->request->isAjax()) {

            // TODO:: verifica se possui o hidden de autorização

            // classe de retorno para ajax
            $jsonResult = new JsonResult();

            // seta para não renderizar o layout
            $this->autoRender = false;

            // pega os dados do POST
            $post = $this->request->data['avaliacao'];

            if ($post['idResolvido'] != 0) {

                // o problema não foi resolvido, deve ser informado o motivo
                if (($post['idResolvido'] != 1) and (trim($post['motivoResolvido']) == '')) {

                    $jsonResult->setError("Informe porque o seu problema <strong>NÃO</strong> foi resolvido");
                } elseif ($post['score'] == '') {

                    $jsonResult->setError("Você deve avaliar o atendimento");
                } elseif (trim($post['motivoNota']) == '') {

                    $jsonResult->setError("Você deve informar o motivo da sua avaliação");
                }
            } else {

                $jsonResult->setError("Informe se o seu problema foi resolvido");
            }

            // verifica se possui algum erro
            if ($jsonResult->hasError() == false) {

                try {

                    // instancia a classe chamado avaliaçao
                    $classCAvaliacao = new ChamadoAvaliacao();

                    $save = array(
                        'id_fk_chamado'         => $post['idOS'],
                        'score'                 => $post['score'],
                        'descricao'             => $post['motivoNota'],
                        'id_resolvido'          => $post['idResolvido'],
                        'motivo_resolvido'      => $post['motivoResolvido'],
                        'data_avaliacao'        => date('Y-m-d H:i:s')
                    );

                    // salva os dados
                    $classCAvaliacao->save($save);

                    // redireciona quando fecha a janela
                    $jsonResult->setRedirect('/pws/index.php/auth_acl');

                    // dados salvo com sucesso
                    $jsonResult->setMensage('Obrigado', "Sua avaliação foi concluida com sucesso");
                } catch (Exception $e) {

                    $jsonResult->setError('Não foi possível salvar' . $e->getMessage(), 'Atenção: Erro');
                }
            }

            return $jsonResult->result();
        } else {

            $error              = '';

            $idOS               = (int) $_GET['o'];
            $idClient           = (int) $_GET['c'];
            $dateExp            = $_GET['d'];
            $hash               = $_GET['h'];

            $isAuthorized       = false;

            $this->set('idOS', $idOS);
            $this->set('idClient', $idClient);

            // remonta o hash para a comparação
            $security = Security::hash($idOS . $idClient . $dateExp);

            // consulta os dados do chamado
            $objChamado = $this->Chamado->find('first', array('conditions' => array('Chamado.id' => $idOS)));

            // verifica se a avaliação já foi feita
            if ($objChamado['ChamadoAvaliacao']['id_fk_chamado'] == '') {

                // verificação de hash
                if ($hash == $security) {

                    // instancia a classe Datetime
                    $objDateNow = new DateTime('now');

                    //verifica se ainda está dentro do prazo de avaliação
                    if (strtotime($dateExp) < strtotime($objDateNow->format('Ymd'))) {

                        $error = "Prazo expirado para essa avaliação";
                    }
                } else {

                    $error = "Avaliação inválida";
                }
            } else {

                $error = "Avaliação já realizada";
            }

            // seta as informações de caso existe
            $this->set('error', $error);

            $this->set('chamado', $objChamado);
        }
    }

    /**
     * Cria o hash de validação do link de avaliação
     *
     * @autor Gustavo Silva
     * @since 26/10/2017
     *
     * @param $idOS id da OS WEB
     * @param $idClient id do cliente
     * @param $date data de finalização da OS
     * @return string
     */
    private function createHashRating($idOS, $idClient, $date)
    {

        // cria o hash
        return Security::hash($idOS . $idClient . $date);
    }

    /**
     * Enviar email de avaliação
     *
     * @autor Gustavo Silva
     * @since 26/10/2017
     *
     * @param $idOS
     * @param $idClient
     * @param $email
     *
     */
    private function sendEmail($idOS, $idClient, $email)
    {
        if (trim($email) != '') {

            // define 7 dias para a data de expiração
            $date = new DateTime('+7 day');

            // cria o hash para enviar o email
            $hash = $this->createHashRating($idOS, $idClient, $date->format('Ymd'));

            // define os parametros da URL
            $params = "o={$idOS}&c={$idClient}&d={$date->format('Ymd')}&h={$hash}";

            // define o método da URL
            $methodURL = "/pws/app/webroot/index.php/pws/Chamados/avaliacao";

            // define o endereço
            $url = $_SERVER['HTTP_HOST'] . "{$methodURL}?" . $params;

            $objChamado = $this->Chamado->find('first', array('conditions' => array('Chamado.id' => $idOS)));

            $objChamado['Chamado']['url'] = $url;

            // envia o email
            self::enviaEmail($email, 'Avaliação chamado Nº ' . $idOS, $objChamado['Chamado'], $idOS, 0, 0, 3);
        }
    }

    /**
     * Método responsável por reenviar email para avaliação da OS
     *
     * @autor Gustavo Silva
     * @since 26/10/2017
     *
     * @param $idOS
     */
    public function emailavaliacao($idOS = null)
    {
        $msg = '';

        // busca os dados do chamado
        $objChamado = $this->Chamado->find('first', array('conditions' => array('Chamado.id' => $idOS, 'Chamado.STATUS' => 'O')));

        // verifica se possui a OS e se ainda não foi realizada a avaliação
        if (count($objChamado) and $objChamado['ChamadoAvaliacao']['id_fk_chamado'] == '') {

            $email = $objChamado['Chamado']['EMAIL'];

            // verifica se no chamado possui o email para enviar a avaliação
            if ($objChamado['Chamado']['EMAIL'] == '') {

                // pega o email da tabela cliente
                $objCliente = $this->Cliente->find('first', array('conditions' => array('Cliente.CDCLIENTE' => $objChamado['Chamado']['CDCLIENTE'])));

                $email = $objCliente['Cliente']['EMAIL'];
            }

            // envia o email
            $this->sendEmail($idOS, $objChamado['Chamado']['CDCLIENTE'], $email);

            $msg = "Email enviado com sucesso!";
        } else {

            $msg = "Chamado não identificado ou avaliação já realizada";
        }

        $this->set('msg', $msg);
    }

    /**
     * Método responsável por mostrar o grid com as avalições
     *
     * @autor Gustavo Silva
     * @since 27/11/2017
     *
     */
    public function listarAvaliacao($status = null)
    {
        $this->Filter->addFilters('filter1');

        $arrConditions = array(
            $this->Filter->getConditions(),
            'Chamado.empresa_id' => $this->empresa,
            'Chamado.ID_BASE'    => $this->matriz
        );

        // adicionar condição de pesquisa
        if ($status != null) {
            $arrConditions['ChamadoAvaliacao.id_resolvido']  = $status;
        }

        $paginate['conditions']    = $arrConditions;
        $paginate['order']         = 'ChamadoAvaliacao.id_fk_chamado DESC';
        $paginate['limit']         = 100;
        $paginate['recursive']     = '0';
        $this->paginate = $paginate;

        $this->set('data', $this->paginate('ChamadoAvaliacao'));
    }

    /**
     * Abre um arquivo pdf com os dados da OS.
     *
     * @autor Gustavo Silva
     * @since 12/03/2018
     */
    public function printPdf($id, $hash)
    {

        // if ($_SESSION['Auth']['User']['user_email'] == 'comercial2@wprinterpe.com.br') {
        //     Configure::write('debug', 2);
        // }
        // Todo: ajustar
        $idatendimentoSelected = (int) $hash;

        $this->layout = null;
        $empresaId = $_SESSION['Auth']['User']['empresa_id'];

        // verifica o hash
        // if ($hash == Security::hash($id . $empresaId)) {

            $chamado = $this->Chamado->find('first', array('conditions' => array('Chamado.ID_BASE' => $this->matriz, 'Chamado.id' => $id)));

            $cliente = $this->Cliente->find('first', array('conditions' => array('Cliente.empresa_id' => $empresaId, 'Cliente.CDCLIENTE' => $chamado['Chamado']['CDCLIENTE'])));

            // comsulta os dados do atendimento
            $atendimento = $this->Chamado->query("SELECT * FROM atendimentos WHERE ID_BASE = {$this->matriz} AND chamado_id = {$chamado['Chamado']['id']}");

            $arrAtendimento = array();

            if(count($atendimento) > 0){
                foreach($atendimento as $key => $data){
                    // consulta as fotos do atendimento caso tenha
                    $atendimentoPhotos = $this->Chamado->query("SELECT * FROM app_atendimento_photos WHERE ID_BASE = {$this->matriz} AND id_atendimento = {$data['atendimentos']['id']}");

                    $arrAtendimentoPhotos = array();

                    if(count($atendimentoPhotos) > 0){
                        foreach($atendimentoPhotos as $keyPhotos => $dataPhotos){

                            $idPhoto = $dataPhotos['app_atendimento_photos']['id'];
                            $idAtendimento = $dataPhotos['app_atendimento_photos']['id_atendimento'];

                            // monta o hash
                            $hash = Security::hash($idAtendimento . $empresaId);

                            // monta o path de renderização
                            $dataPhotos['app_atendimento_photos']['pathRender'] = "?id={$idPhoto}&idAtendimento={$idAtendimento}&hash={$hash}";

                            // adiciona o array
                            $arrAtendimentoPhotos[$dataPhotos['app_atendimento_photos']['type']][] = $dataPhotos['app_atendimento_photos'];
                        }
                    }

                    // monta o retorno do atendimento
                    $arrAtendimento[$data['atendimentos']['id']] = array('atendimento' => $data['atendimentos'], 'photos' => $arrAtendimentoPhotos);

                    if($idatendimentoSelected <= 0){
                        $idatendimentoSelected = $data['atendimentos']['id'];
                    }

                }
            }

            $this->set('atendimento', $arrAtendimento);
            $this->set('cliente', $cliente);

            if((int) $idatendimentoSelected > 0){
                $this->set('selectedAtendimento', (int) $idatendimentoSelected);
            }

            $view = new View($this);

            $view->set('data', $chamado);

            require_once(APP . 'Vendor' . DS . 'dompdf' . DS . 'dompdf_config.inc.php');

            $this->layout = $this->autoRender = false;
            $this->response->header(array('Content-type' => 'application/pdf'));
            $this->response->header(array('Content-type' => 'text/html; charset=UTF-8'));

            $this->dompdf = new DOMPDF();
            $html = preg_replace('/>\s+</', '><', $view->render('print_pdf'));
            $this->dompdf->load_html(stripslashes($html));
            $this->dompdf->set_paper("A4", "portrait");
            $this->dompdf->render();

            $this->dompdf->stream("os_{$id}.pdf");
        // }
    }

    /**
     * Atualiza o chamado de depachado para em manutenção.
     *
     * @autor Vinícius Kreusch
     * @since 17/02/2019
     *
     * @param  $chamadoId
     * @throws Exception
     */
    public function updateChamadoStatus($chamadoId = null)
    {
        $this->layout = null;
        $this->autoRender = false;
        if ($this->request->isAjax() && $chamadoId != null) {
            $this->Chamado->read(null, $chamadoId);
            $dataReturn = [];

            if (!isset($this->request->data['Status']['tipo_status']) || $this->request->data['Status']['tipo_status'] == '') {
                $dataReturn['error'] = 1;
                $dataReturn['error_message'] = 'Por favor informe um tipo status válido.';
            } else {
                if (!$this->Chamado->exists()) {
                    $this->Session->setFlash('Erro: Chamado não encontrado.');
                } else {

                    $chamado = $this->Chamado->query("SELECT SEQOS FROM chamados WHERE id = {$chamadoId}");

                    $data = array('STATUS' => 'M', 'CDSTATUS' => $this->request->data['Status']['tipo_status']);

                    if ($chamado[0]['chamados']['SEQOS'] <= 0) {

                        $data['ATUALIZADO'] = 1;
                    } else {

                        $data['ATUALIZADO'] = 2;
                    }

                    if ($this->Chamado->save($data, false)) {
                        $this->Session->setFlash('Chamado ' . $chamadoId . ' atualizado com sucesso! ' . $chamados['Chamado']['SEQOS']);
                        $dataReturn['error'] = 0;
                    } else {
                        $messageError = 'Erro: ao atualizar chamado ' . $chamadoId;
                        $this->Session->setFlash($messageError);
                        $dataReturn['error'] = 1;
                        $dataReturn['error_message'] = $messageError;
                    }
                }
            }
            echo json_encode($dataReturn);
        }
    }

    /**
     * Envia email de solicitação de peça
     *
     * @autor Gustavo Silva
     * @since 05/02/2020
     *
     */
    public function sendEmailApp()
    {
        App::import('Vendor', 'AuthAcl.functions');

        $this->layout       = null;
        $this->autoRender   = false;

        $success    = true;
        $data       = '';
        $message    = '';
        $idChamado  = (int) $_GET['idChamado'];
        $idEmpresa  = (int) $_GET['idEmpresa'];
        $json       = $_GET['json'];

        App::uses('CakeEmail', 'Network/Email');
        App::uses('Setting', 'AuthAcl.Model');

        // consulta o chamado
        $this->Chamado->id = $idChamado;
        $chamado = $this->Chamado->read(null, $idChamado);

        $peca = json_decode($json);

        $chamado['Chamado']['app']['peca'] = $peca;
        $chamado['Chamado']['url'] = siteURL() . "pws/chamados/view/" . $idChamado;

        $chamado['Chamado']['SERIE']        = $chamado['Equipamento']['SERIE'];
        $chamado['Chamado']['PATRIMONIO']   = $chamado['Equipamento']['PATRIMONIO'];
        $chamado['Chamado']['MODELO']       = $chamado['Equipamento']['MODELO'];
        $chamado['Chamado']['DEPARTAMENTO'] = $chamado['Equipamento']['DEPARTAMENTO'];

        $chamado['Chamado']['DTINCLUSAO'] = date("d/m/Y", strtotime($chamado['Chamado']['DTINCLUSAO']));
        $chamado['Chamado']['HRINCLUSAO'] = date("H:i", strtotime($chamado['Chamado']['HRINCLUSAO']));
        $chamado['Chamado']['DTATENDIMENTO'] = date("d/m/Y", strtotime($chamado['Chamado']['DTATENDIMENTO']));

        // consulta os dados da empresa
        $queryEmpresa = $this->Chamado->query("SELECT * FROM empresas WHERE id = {$idEmpresa} LIMIT 1");

        $queryEmpresa = $queryEmpresa[0]['empresas'];

        $auth_user['EmpresaSelected']['Empresa']['empresa_nome'] = $queryEmpresa['empresa_nome'];
        $auth_user['EmpresaSelected']['Empresa']['endereco'] = $queryEmpresa['endereco'];
        $auth_user['EmpresaSelected']['Empresa']['numero'] = $queryEmpresa['numero'];
        $auth_user['EmpresaSelected']['Empresa']['complemento'] = $queryEmpresa['complemento'];
        $auth_user['EmpresaSelected']['Empresa']['ddd'] = $queryEmpresa['ddd'];
        $auth_user['EmpresaSelected']['Empresa']['fone'] = $queryEmpresa['fone'];

        try {

            $sql = "SELECT c.user_name, c.user_email 
                       FROM tpemails a
                       INNER JOIN users_tpemails b ON (b.tpemail_id = a.id)
                       INNER JOIN users c ON (c.id= b.user_id)
                       INNER JOIN users_empresas emps ON (emps.user_id = c.id)
                       WHERE a.id = 1 and emps.empresa_id in ({$idEmpresa})";

            $query = $this->Chamado->query($sql);

            $Setting = new Setting();
            $auth_user = $this->Session->read('auth_user');
            $general = $Setting->find('first', array(
                'conditions' => array(
                    'setting_key' => sha1('general')
                )
            ));

            if (!empty($general)) {
                $general = unserialize($general['Setting']['setting_value']);
            }

            foreach ($query as $key => $data) {

                $email = new CakeEmail();

                $email->addTo($data['c']['user_email']);
                $email->config('default');
                $email->emailFormat('html');
                $email->from(array(
                    $general['Setting']['email_address'] => __('Pws - Portal Web')
                ));
                $email->subject('Solicitação de peça Nº' . $idChamado);
                $email->template('chamado_edit', 'chamado_edit');
                $email->viewVars(array('chamado' => $chamado['Chamado'], 'numero' => $idChamado, 'auth_user' => $auth_user));

                $email->send();

            }

        } catch (SocketException $e) {

            $success = false;
            $message = $e->getMessage();
        }

        $response = array(
            'success'  => $success,
            'data'     => $data,
            'message'  => $message
        );

        $this->response->type('application/json');
        $this->response->body(json_encode($response));
    }


    public function exportMessagePreAtedimento(){
        $this->layout= null;
        $id = $_GET['id'];

        $auth_user = $this->Session->read('auth_user');
        $this->Chamado->id = $id;
        
        $chamado = $this->Chamado->find('first', array('conditions' => array(
            'Chamado.ID_BASE' => $this->matriz,
            'Chamado.id' => $id
        )));

        $this->set('auth_user', $auth_user);
        $this->set('chamado', $chamado);

    }

    public function cancelar(){

        $this->layout       = null;
        $this->autoRender   = false;
        $this->response->type('application/json');

        $this->loadModel('Pws.Chamado');

        $params = json_decode(file_get_contents('php://input'), true);

        $this->Chamado->query("UPDATE chamados set ATUALIZADO = 2, STATUS = 'C', CDSTATUS = '{$params['cdStatus']}' WHERE id = {$params['idChamado']}");

        $this->response->body(json_encode(array('success' => true)));

    }
}
