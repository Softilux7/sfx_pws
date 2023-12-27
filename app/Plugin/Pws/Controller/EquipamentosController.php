<?php
App::uses('PwsAppController', 'Pws.Controller');

/**
 * Equipamentos Controller
 *
 * @property Equipamento $Equipamento
 */
class EquipamentosController extends PwsAppController
{

    public $components = array(
        'EmpresaPermission'
    );

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');
        $this->loadModel('Pws.Equipamento');
        //$this->setarDB($this->conect);
        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->Equipamento->recursive = 0;

        // Filtro de equipamentos
        $this->Filter->addFilters('filter1');
        // Condição de filtragem inicial
        $conditions = array(
            'Equipamento.empresa_id  ' => $this->empresa,
                    'Equipamento.ID_BASE = ' => $this->matriz,
//                     'Equipamento.SEQCONTRATO = ' => 0
                    '(Equipamento.SEQCONTRATO is null OR Equipamento.SEQCONTRATO = 0)'
        );
        //$conditions = $this->Filter->setPaginate ( 'conditions', $this->Filter->getConditions () );
        $paginate = array();
        $paginate['conditions'] = $conditions;
        $paginate['limit'] = 15;
        $this->paginate = $paginate;

        if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {
            $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        }

        // Lista de acordo com o o grupo do usuário
        switch ($auth_user_group['id']) {
            case '1': // Admin
            case '6':
            case '4':
            case '7':
                $equipamentos = $this->paginate(array(
                    'Equipamento.empresa_id  ' => $this->empresa,
                    'Equipamento.ID_BASE = ' => $this->matriz,
//                     'Equipamento.SEQCONTRATO = ' => 0
                    '(Equipamento.SEQCONTRATO is null OR Equipamento.SEQCONTRATO = 0)'
                ));
                break;
            case '9':
                $equipamentos = $this->paginate(array(
                    'Equipamento.empresa_id  ' => $this->empresa,
                    'Equipamento.ID_BASE = ' => $this->matriz,
                    'Equipamento.CDCLIENTE  ' => $this->cdCliente,
//                     'Equipamento.SEQCONTRATO = ' => ''
                    '(Equipamento.SEQCONTRATO is null OR Equipamento.SEQCONTRATO = 0)'
                ));
                break;
            case '3': // Cliente
            case '12':
                $equipamentos =  $this->paginate(array(
                    'Equipamento.CDCLIENTE  ' => $this->cdCliente,
                    'Equipamento.empresa_id  ' => $this->empresa,
                    'Equipamento.ID_BASE = ' => $this->matriz,
                    '(Equipamento.SEQCONTRATO is null OR Equipamento.SEQCONTRATO = 0)',
                ));
                break;
            case '2': // Técnico
                if (empty($auth_user['User']['cliente_id'])  || $auth_user['User']['cliente_id'] == -1) {
                    
                    $equipamentos =  $this->paginate(array(
                        'Equipamento.empresa_id  ' => $this->empresa,
                        // 'Equipamento.ID_BASE = ' => $this->matriz,
                        // 'Equipamento.SEQCONTRATO = ' => 0
                    ));
                    
                } else {
                    
                    $equipamentos =  $this->paginate(array(
                        'Equipamento.CDCLIENTE  ' => $this->cdCliente,
                        'Equipamento.empresa_id  ' => $this->empresa,
                        'Equipamento.ID_BASE = ' => $this->matriz,
//                         'Equipamento.SEQCONTRATO = ' => 0
                        '(Equipamento.SEQCONTRATO is null OR Equipamento.SEQCONTRATO = 0)'
                    ));
                }
                break;
            default:
                $this->redirect(array(
                    'controller' => 'ContratoItens',
                    'action' => 'index',
                ));
        }

        $this->set('Equipamentos', $equipamentos);
    }

    public function editTemp()
    {
        $this->layout = null;
        $this->autoRender = false;
        //$authUser = $this->Auth->user();
        print_r($this->request->data['Equipamento']);
        if ($this->request->is('post')) {
            $this->Equipamento->read(null, $this->request->data['Equipamento']['id']);
            $this->Equipamento->saveField('TEMPOFECHAMENTO', $this->request->data['Equipamento']['TEMPOFECHAMENTO']);
            //if () {
            $var['error'] = 0;
            // } else {
            //$var['error'] = 1;
            // }
        }
        echo json_encode($var);
    }
}
