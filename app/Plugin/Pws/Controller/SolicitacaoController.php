<?php
App::uses('PwsAppController', 'Pws.Controller');

/**
 * Chamados Controller
 *
 * @property Chamado $Chamado
 *
 */
class SolicitacaoController extends PwsAppController
{
    public $components = array(
        'EmpresaPermission'
    );

    public function index($status = null)
    {
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');
        //$this->setarDB($this->conect);
        if ($this->request->isAjax()) {
            $this->layout = null;
        }
        $this->Solicitacao->recursive = 0;
        // print_r($auth_user);
        // Filtro de Chamados
        $this->Filter->addFilters('filter1');
        // CondiÃ§Ã£o de filtragem inicial
        $conditions = array();
        //$conditions = $this->Filter->setPaginate ( 'conditions', $this->Filter->getConditions () );
        $paginate = array();
        $paginate ['conditions'] = $conditions;
        $paginate ['order'] = 'Solicitacao.id DESC';
        $paginate ['limit'] = 15;
        $this->paginate = $paginate;

        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        // Lista de acordo com o o grupo do usuário
        switch ($auth_user_group['id']) {
            case '1': // Admin
            case '6':
            case '7':
                if ($status == 'O' || $status == 'P' || $status == 'T' || $status == 'C' || $status == 'E') {
                    $this->set('Solicitacoes', $this->paginate(array(
                        'Solicitacao.status = ' => $status,
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                } else {
                    $this->set('Solicitacoes', $this->paginate(array(
                        //'Solicitacao.status = ' => 'P',
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                }
                break;
            case '3': // Cliente
                if ($status == 'O' || $status == 'P' || $status == 'T' || $status == 'C' | $status == 'E') {
                    $this->set('Solicitacoes', $this->paginate(array(
                        'Solicitacao.cliente_id ' => $this->cliente,
                        'Solicitacao.status = ' => $status,
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                } else {
                    $this->set('Solicitacoes', $this->paginate(array(
                        'Solicitacao.cliente_id ' => $this->cliente,
                        'Solicitacao.status = ' => 'P',
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                }
                break;
            case '4':
                if ($status == 'O' || $status == 'P' || $status == 'T' || $status == 'C' | $status == 'E') {
                    $this->set('Solicitacoes', $this->paginate(array(
                        //'Solicitacao.cliente_id = ' => $auth_user ['User'] ['cliente_id'],
                        'Solicitacao.status = ' => $status,
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                } else {
                    $this->set('Solicitacoes', $this->paginate(array(
                        //'Solicitacao.cliente_id = ' => $auth_user ['User'] ['cliente_id'],
                        'Solicitacao.status = ' => 'P',
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                }
                break;
            case '2': // Técnico
                if ($status == 'O' || $status == 'P' || $status == 'T' || $status == 'C' | $status == 'E') {
                    $this->set('Solicitacoes', $this->paginate(array(
                        'Solicitacao.status = ' => $status,
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                } else {
                    $this->set('Solicitacoes', $this->paginate(array(
                        'Solicitacao.status = ' => 'P',
                        'Solicitacao.empresa_id  ' => $this->empresa,
                        'Solicitacao.ID_BASE =' => $this->matriz,
                    )));
                }
                break;
            default:
                $this->redirect(array(
                    'controller' => 'AuthAcl.AuthAcl',
                    'action' => 'index',
                ));
        }

    }

    /**
     * add solicitação por equipamento method
     *
     * @return void
     */

    public function add($id = null)
    {
        $errors = array();
        //$auth_user = $this->Session->read('auth_user');
        // $auth_user_group = $this->Session->read('auth_user_group');

        // Carrega models necessários
        $this->loadModel('Pws.Equipamento');
        $this->loadModel('Pws.Cliente');
        $this->loadModel('AuthAcl.User');
        $this->loadModel('Pws.SolicitacaoSuprimento');
        $this->loadModel('Pws.SuprimentoTipo');

        $auth_user = $this->Session->read('auth_user');
        $this->set('suprimentos', $this->SuprimentoTipo->find('all', array(
            'fields' => array(
                'SuprimentoTipo.id', 'SuprimentoTipo.nome_tipo', 'SuprimentoTipo.servico'
            ),
            'order' => array(
                'SuprimentoTipo.nome_tipo' => 'ASC'
            ))));
        // Listar usuários tipo email Solicitação de suprimentos
        $tpemails = $this->User->query("SELECT c.user_name, c.user_email FROM tpemails a
                                        INNER JOIN users_tpemails b on (b.tpemail_id = a.id)
                                        INNER JOIN users c on (c.id= b.user_id)
                                        where a.id = 2 and c.empresa_id={$this->matriz}");

        $this->set('empresa_id', $auth_user['User']['empresa_id']);

        //$this->setarDB($this->conect);
        //Dados do Equipamento
        $equip = $this->Equipamento->findById($id);

        if (empty($equip)) {
            $this->Session->setFlash('Erro: Equipamento não encontrado.');
            $this->redirect(array(
                'controller' => 'Chamados',
                'action' => 'index',
            ));
        }

        $this->set('equip', $equip);
        $this->request->data('Solicitacao.equipamento_id', $equip ['Equipamento'] ['CDEQUIPAMENTO']);
        // Dados do Clientes
        $cliente = $this->Cliente->find('all', array(
            'conditions' => array(
                'Cliente.CDCLIENTE' => $equip['Equipamento']['CDCLIENTE'],
                'Cliente.ID_BASE' => $this->matriz)));
        $this->set('cliente', $cliente);
        $this->request->data('Solicitacao.cliente_id', $cliente[0]['Cliente']['CDCLIENTE']);
        //status da solicitação
        $this->request->data('Solicitacao.status', 'P'); //Pendente
        $this->request->data('Solicitacao.situacao', 'R'); //Recebido


        if ($auth_user['User']['filial_id'] == 0) {

            $this->request->data('Solicitacao.empresa_id', $auth_user['User']['empresa_id']);
        } else {

            $this->request->data('Solicitacao.empresa_id', $auth_user['User']['filial_id']);
        }

        $this->request->data('Solicitacao.ID_BASE', $this->matriz);
        $this->set('id_base', $this->matriz);

        //Grava a solicitação
        if ($this->request->is('post')) {
            $this->Solicitacao->create();
            $this->SolicitacaoSuprimento->create();
            $salvar = $this->Solicitacao->saveAll($this->request->data);

            //pega o id da solicitação salva
            $numero = $this->Solicitacao->id;

            //Lista os dados da solicitação recem adicionada.
            $solicitacao = $this->Solicitacao->read(null, $numero);
            $suprimentos = $this->SolicitacaoSuprimento->find('all', array(
                'conditions' => array(
                    'SolicitacaoSuprimento.solicitacao_id' => $this->Solicitacao->id,
                    'SolicitacaoSuprimento.ID_BASE' => $this->matriz)));

            if ($salvar) {
                $this->Session->setFlash('Solicitação de suprimento realizada com sucesso!');

                // Inicio envio de email
                $enviado = 0;
                //forech usuários
                if (count($tpemails) > 0) {
                    foreach ($tpemails as $tpemail) {
                        if (self::enviaEmail($tpemail['c']['user_email'], 'Solicitação de Suprimento Nº ' . $numero, $solicitacao, $numero, $suprimentos)) {
                            $enviado++;
                        }
                    }
                    // envio de email copia do cliente
                    if ($enviado > 0) {
                        self::enviaEmail($this->request->data['Solicitacao']['email'], 'Solicitação de Suprimento Nº ' . $numero, $solicitacao, $numero, $suprimentos);
                        $this->Session->setFlash('Email Enviado com Sucesso!');
                    } else {
                        $errors[] = 'Erro ao enviar email';
                    }
                } else {
                    $errors[] = $this->Session->setFlash('Solicitação de suprimento realizada com sucesso!');
                    $errors[] = $this->Session->setFlash('Não foi possivel enviar email');
                }

                $this->redirect(array(
                    'controller' => 'Solicitacao',
                    'action' => 'view', $numero,
                ));

            } else {
                $errors = $this->Chamado->validationErrors;
            }
        }
        $this->set('errors', $errors);
    }

    /**
     * Add Solicitação por modelo / contrato
     *
     * @return void
     */
    public function modelo($id = null)
    {
        $errors = array();

        // Carrega models necessários
        $this->loadModel('Pws.Equipamento');
        $this->loadModel('Pws.Cliente');
        $this->loadModel('Pws.Contrato');
        $this->loadModel('AuthAcl.User');
        $this->loadModel('Pws.SolicitacaoSuprimento');
        $this->loadModel('Pws.SuprimentoTipo');
        $auth_user = $this->Session->read('auth_user');

        $this->set('suprimentos', $this->SuprimentoTipo->find('all', array(
            'fields' => array(
                'SuprimentoTipo.id', 'SuprimentoTipo.nome_tipo', 'SuprimentoTipo.servico'
            ),
            'order' => array(
                'SuprimentoTipo.nome_tipo' => 'ASC'
            ))));
        // Listar usuários tipo email Solicitação de suprimentos
        $tpemails = $this->User->query("SELECT c.user_name, c.user_email FROM tpemails a
                                        INNER JOIN users_tpemails b on (b.tpemail_id = a.id)
                                        INNER JOIN users c on (c.id= b.user_id)
                                        where a.id = 2 and c.empresa_id={$this->matriz}");

        //$this->setarDB($this->conect);

        //Dados do Equipamento
        $modelo = $this->Equipamento->query("SELECT MODELO FROM	equipamentos WHERE
	                                          equipamentos.SEQCONTRATO = {$id} AND 
	                                          equipamentos.ID_BASE = {$this->matriz} 	                                        
	                                          GROUP BY MODELO");


        $this->set('modelo', $modelo);

        //Dados do Equipamento
        $cidade = $this->Equipamento->query("SELECT CIDADE FROM	equipamentos WHERE
	                                          equipamentos.SEQCONTRATO = {$id} AND 
	                                          equipamentos.ID_BASE = {$this->matriz}
	                                          GROUP BY CIDADE");


       // print_r($cidade);

        $this->set('cidade', $cidade);

        $contrato = $this->Contrato->find('first',array(
            'conditions' => array(
                'Contrato.SEQCONTRATO' => $id,
                'Contrato.ID_BASE'=>$this->matriz,
                'Contrato.empresa_id' => $this->empresa)));

        if (empty($modelo)) {
            $this->Session->setFlash('Erro: Contrato não encontrado.');
            $this->redirect(array(
                'controller' => 'Chamados',
                'action' => 'index',
            ));
        }
        
        $this->set('contrato', $contrato);

        //$this->request->data('Solicitacao.equipamento_id', $equip ['Equipamento'] ['CDEQUIPAMENTO']);
        // Dados do Clientes
        $cliente = $this->Cliente->find('all', array(
            'conditions' => array(
                'Cliente.CDCLIENTE' => $contrato['Contrato']['CDCLIENTE'],
                'Cliente.ID_BASE'=>$this->matriz)));

        $this->set('cliente', $cliente);

        $this->request->data('Solicitacao.cliente_id', $cliente[0]['Cliente']['CDCLIENTE']);
        $this->request->data('Solicitacao.contrato_id', $contrato['Contrato']['SEQCONTRATO']);
        //status da solicitação
        $this->request->data('Solicitacao.status', 'P');


        if ($auth_user['User']['filial_id'] == 0) {

            $this->request->data('Solicitacao.empresa_id', $auth_user['User']['empresa_id']);
        } else {

            $this->request->data('Solicitacao.empresa_id', $auth_user['User']['filial_id']);
        }

        $this->request->data('Solicitacao.ID_BASE', $this->matriz);
        $this->set('id_base', $this->matriz);

        //Grava a solicitação
        if ($this->request->is('post')) {
            $this->Solicitacao->create();
            $this->SolicitacaoSuprimento->create();
            $salvar = $this->Solicitacao->saveAll($this->request->data);

            //pega o id da solicitação salva
            $numero = $this->Solicitacao->id;

            //Lista os dados da solicitação recem adicionada.
            $solicitacao = $this->Solicitacao->read(null, $numero);
            $suprimentos = $this->SolicitacaoSuprimento->find('all', array(
                'conditions' => array(
                    'SolicitacaoSuprimento.solicitacao_id' => $this->Solicitacao->id,
                    'SolicitacaoSuprimento.ID_BASE' => $this->matriz)));

            if ($salvar) {
                $this->Session->setFlash('Solicitação realizada com sucesso!');

                // Inicio envio de email
                $enviado = 0;
                //forech usuários
                if (count($tpemails) > 0) {
                    foreach ($tpemails as $tpemail) {
                        if (self::enviaEmail($tpemail['c']['user_email'], 'Solicitação de Suprimento / Serviço Nº ' . $numero, $solicitacao, $numero, $suprimentos)) {
                            $enviado++;
                        }
                    }
                    // Envio de email copia do cliente
                    if ($enviado > 0) {
                        self::enviaEmail($this->request->data['Solicitacao']['email'], 'Solicitação de Suprimento / Serviço Nº ' . $numero, $solicitacao, $numero, $suprimentos);
                        $this->Session->setFlash('Email Enviado com Sucesso!');
                    } else {
                        $errors[] = 'Erro ao enviar email';
                    }
                } else {
                    $errors[] = $this->Session->setFlash('Solicitação realizada com sucesso!');
                    $errors[] = $this->Session->setFlash('Não foi possivel enviar email');
                }

                $this->redirect(array(
                    'controller' => 'Solicitacao',
                    'action' => 'view', $numero,
                ));

            } else {
                $errors = $this->Solicitacao->validationErrors;
            }
        }
        $this->set('errors', $errors);
    }


    /**
     * Enviar email
     */

    private function enviaEmail($to = null, $subject = null, $dados, $numero, $suprimentos, $edit = null)
    {

        App::uses('CakeEmail', 'Network/Email');
        App::uses('Setting', 'AuthAcl.Model');

        $Setting = new Setting ();
        $auth_user = $this->Session->read('auth_user');
        $general = $Setting->find('first', array(
            'conditions' => array(
                'setting_key' => sha1('general')
            )
        ));
        if (!empty ($general)) {
            $general = unserialize($general ['Setting'] ['setting_value']);
        }

        $email = new CakeEmail ();

        $email->addTo($to);
        $email->config('default');
        $email->emailFormat('html');
        if ($edit == 1) {
            $email->template('suprimento_edit', 'suprimento_edit');
        } else {
            $email->template('suprimento', 'suprimento');
        }

        $email->from(array(
            $general ['Setting'] ['email_address'] => __('Pws - Portal Web')
        ));
        $email->subject($subject);

        if ($edit == 1) {
            $email->viewVars(array('solicitacao' => $dados, 'numero' => $numero, 'auth_user' => $auth_user));
        } else {
            $email->viewVars(array('solicitacao' => $dados, 'numero' => $numero, 'suprimentos' => $suprimentos, 'auth_user' => $auth_user));
        }
        return $email->send();

    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */

    public
    function view($id = null)
    {
        $this->loadModel('Pws.SolicitacaoSuprimento');
        $errors = array();
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        $this->set('empresa_id', $auth_user['User']['empresa_id']);

        //$this->setarDB($this->conect);
        $this->Solicitacao->id = $id;
        if (!$this->Solicitacao->exists()) {
            $errors[] = $this->Session->setFlash('Erro: Solicitação de Suprimento não encontrada.');
        }


        $solicitacao = $this->Solicitacao->read(null, $id);
        $suprimentos = $this->SolicitacaoSuprimento->find('all', array(
            'conditions' => array(
                'SolicitacaoSuprimento.solicitacao_id' => $solicitacao['Solicitacao']['id'],
                'SolicitacaoSuprimento.ID_BASE' => $this->matriz,
            )));
        $this->set('suprimentos', $suprimentos);

        // Lista de acordo com o o grupo do usuário
        switch ($auth_user_group['id']) {
            case '1': // Admin
            case '6': // Admin
            case '7':
                $this->set('solicitacao', $solicitacao);
                break;
            case '3': // Cliente
//                if ($solicitacao ['Solicitacao'] ['cliente_id'] == $auth_user['User']['cliente_id']) {
//                    $this->set('solicitacao', $solicitacao);
//                } else {
//                    $errors[] = $this->Session->setFlash('Erro: Solicitação não encontrada ou sem premissão de acesso.');
//                }

                // Multi cliente - Acessar
                if ($auth_user['User']['cliente_id']== -1) {
                    $i = 0;
                    foreach ($auth_user['Cliente'] as $cliente) {
                        if ($solicitacao ['Solicitacao'] ['cliente_id'] == $cliente['CDCLIENTE']) {
                            $i++;
                        }
                    }
                    if ($i > 0) {
                        $this->set('solicitacao', $solicitacao);
                    } else {
                        $errors[] = $this->Session->setFlash('Erro: Solicitação não encontrada ou sem premissão de acesso.');
                    }
                } else {
                    if ($solicitacao ['Solicitacao'] ['cliente_id'] == $auth_user['User']['cliente_id']) {
                        $this->set('solicitacao', $solicitacao);
                    } else {
                        $errors[] = $this->Session->setFlash('Erro: Solicitação não encontrada ou sem premissão de acesso.');
                    }
                }

                break;
            case '4': // Técnico
                $this->set('solicitacao', $solicitacao);
                break;
            default:
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

    /**
     * Editar Solicitação de Suprimento
     *
     * @autor Wagner Martins
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {

        $this->loadModel('Pws.SolicitacaoSuprimento');
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');

        $errors = array();

        $this->Solicitacao->id = $id;
        $solicitacao = $this->Solicitacao->read(null, $id);

        if (!$this->Solicitacao->exists()) {
            $errors[] = $this->Session->setFlash('Erro: Solicitação de Suprimento não encontrada.');
        }

        //return $this->getDataSource()->getLog(false, false)

        if ($this->request->is('post') || $this->request->is('put')) {
            
            if ($this->Solicitacao->saveAll($this->request->data)) {
                App::import('Vendor', 'AuthAcl.functions');

                // Dados para enviar email para o cliente.
                $dadosEmail = array();
                //dados da solicitação
                $dadosEmail['created'] = $this->request->data['Solicitacao']['created'];
                $dadosEmail['contato'] = $this->request->data['Solicitacao']['contato'];
                $dadosEmail['fone'] = $this->request->data['Solicitacao']['fone'];
                $dadosEmail['email'] = $this->request->data['Solicitacao']['email'];
                $dadosEmail['status'] = $this->request->data['Solicitacao']['status'];
                $dadosEmail['transportadora'] = $this->request->data['Solicitacao']['transportadora'];
                $dadosEmail['cdrastreio'] = $this->request->data['Solicitacao']['cdrastreio'];
                $dadosEmail['NRNFSAIDA'] = $this->request->data['Solicitacao']['NRNFSAIDA'];
                $dadosEmail['DTEMISSAONFS'] = $this->request->data['Solicitacao']['DTEMISSAONFS'];

                //Dados do cliente
                $dadosEmail['NMCLIENTE'] = $this->request->data['Cliente']['NMCLIENTE'];
                //Dados do equipamento

                if (!empty($this->request->data['Solicitacao']['contrato_id'])){
                    $dadosEmail['contrato_id'] = $this->request->data['Solicitacao']['contrato_id'];
                    $dadosEmail['cidade'] = $this->request->data['Solicitacao']['cidade'];
                    $dadosEmail['modelo'] = $this->request->data['Solicitacao']['modelo'];
                    $dadosEmail['departamento'] = $this->request->data['Solicitacao']['departamento'];
                    $dadosEmail['localinstal'] = $this->request->data['Solicitacao']['localinstal'];
                } else {
                    $dadosEmail['SERIE'] = $this->request->data['Equipamento']['SERIE'];
                    $dadosEmail['PATRIMONIO'] = $this->request->data['Equipamento']['PATRIMONIO'];
                    $dadosEmail['MODELO'] = $this->request->data['Equipamento']['MODELO'];
                    $dadosEmail['DEPARTAMENTO'] = $this->request->data['Equipamento']['DEPARTAMENTO'];
                }
                
                $dadosEmail['url'] = siteURL() . "pws/Solicitacao/view/" . $this->Solicitacao->id;

                // regras para status 'Liberado'
                if($this->request->data['Solicitacao']['status'] == 'L'){

                    // consulta os usuários que devem receber mensagem de solitações liberadas
                $query = $this->Solicitacao->query("SELECT user_email FROM users u inner join users_tpemails tp on (tp.user_id = u.id and tp.tpemail_id = 6) where u.empresa_id = {$solicitacao['Solicitacao']['empresa_id']}");
                    
                    if(count($query) > 0){

                        // consulta os email
                        foreach($query as $key => $data){

                            // envia os emails aos usuários
                            self::enviaEmail($data['u']['user_email'], 'Solicitação liberada Nº ' . $this->Solicitacao->id, $dadosEmail, $this->Solicitacao->id, 0, 1);

                        }
                        
                    }
                }

                self::enviaEmail($this->request->data['Solicitacao']['email'], 'Alteração de Solicitação Nº ' . $this->Solicitacao->id, $dadosEmail, $this->Solicitacao->id, 0, 1);

                $this->redirect(array(
                    'action' => 'view', $id
                ));

            } else {
                $errors = $this->Solicitacao->validationErrors;
            }
        } else {

            // Lista de acordo com o o grupo do usuário
            switch ($auth_user_group['id']) {
                case '1': // Admin
                case '6': // Admin
                case '7':
                case '4': // operador suprimentos
                    $this->set('solicitacao', $solicitacao);
                    $suprimentos = $this->SolicitacaoSuprimento->find('all', array(
                        'conditions' => array(
                            'SolicitacaoSuprimento.solicitacao_id' => $id,
                            'SolicitacaoSuprimento.ID_BASE' => $this->matriz
                            )));
                    $this->set('suprimentos', $suprimentos);
                    $this->request->data = am($this->request->data, $solicitacao);
                    break;
                default:
                    $errors[] = $this->Session->setFlash('Atenção: Você não tem permissão de alterar esta solicitação.');
                    $this->redirect(array(
                        'controller' => 'Solicitacao',
                        'action' => 'index',
                    ));
            }

            if (count($errors) > 0) {
                $this->redirect(array(
                    'controller' => 'Solicitacao',
                    'action' => 'index',
                ));
            }


        }
        $this->set('errors', $errors);
    }
}
