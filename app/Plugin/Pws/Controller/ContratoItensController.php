<?php
App::uses('PwsAppController', 'Pws.Controller');

/**
 * Equipamentos Controller
 *
 * @property Equipamento $Equipamento
 */
class ContratoItensController extends PwsAppController
{

    public $components = array(
        'EmpresaPermission'
    );

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow('checkChamadoEquipamento');
    }

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

        $this->ContratoIten->recursive = 0;

        // Filtro de equipamentos
        $this->Filter->addFilters('filter1');
        // Condição de filtragem inicial
        $conditions = array();
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
                    'GrupoContrato.empresa_id ' => $this->empresa,
                    'GrupoContrato.ID_BASE = ' => $this->matriz,
                    'Contrato.STATUS' => array('G', 'I')
                ));
                break;
            case '9':

                $equipamentos = $this->paginate(array(
                    'OR' => array('Equipamento.CDCLIENTE' => $this->cdCliente, 'Equipamento.CDCLIENTEENT' => $this->cdCliente),
                    'GrupoContrato.empresa_id ' => $this->empresa,
                    'GrupoContrato.ID_BASE = ' => $this->matriz,
                    'Contrato.STATUS' => array('G', 'I')
                ));
                break;
            case '3':
            case '12':
                $equipamentos =  $this->paginate(array(
                    'OR' => array('Equipamento.CDCLIENTE' => $this->cdCliente, 'Equipamento.CDCLIENTEENT' => $this->cdCliente),
                    'GrupoContrato.empresa_id ' => $this->empresa,
                    'GrupoContrato.ID_BASE = ' => $this->matriz,
                    'Contrato.STATUS' => array('G', 'I')
                ));
                break;
            case '2': // Técnico
                if (empty($auth_user['User']['cliente_id'])) {
                    $equipamentos =  $this->paginate(array(
                        'GrupoContrato.empresa_id ' => $this->empresa,
                        'GrupoContrato.ID_BASE = ' => $this->matriz,
                        'Contrato.STATUS' => array('G', 'I')
                    ));
                } else {
                    
                    $equipamentos =  $this->paginate(array(
                        // 'GrupoContrato.CDCLIENTE' => 4003,
                        'GrupoContrato.empresa_id ' => $this->empresa,
                        'GrupoContrato.ID_BASE = ' => $this->matriz,
                        'Contrato.STATUS' => array('G', 'I')
                    ));

                    if(count($this->cdCliente) > 0){
                        $equipamentos[] = array('GrupoContrato.CDCLIENTE' =>  $this->cdCliente);
                    }
                }
                break;
            default:
                $this->redirect(array(
                    'plugin' => 'auth_acl',
                    'controller' => 'AuthAcl',
                    'action' => 'index',
                ));
        }

        $this->set('Equipamentos', $equipamentos);
    }

    public function checkChamadoEquipamento(){

        $this->layout       = null;
        $this->autoRender   = false;
        $this->response->type('application/json');



        $this->loadModel('Pws.Equipamento');

        $params = json_decode(file_get_contents('php://input'), true);
        
        // verifica se possui algum chamado para o equipamento
        $query = $this->Equipamento->query("SELECT c.id,  c.SEQOS, c.OBSDEFEITOCLI, c.STATUS, c.NMCLIENTE, e.SERIE, e.MODELO, c.EMAIL,
                                                    c.DTINCLUSAO, c.HRINCLUSAO
                                                    FROM chamados AS c
                                                    INNER JOIN equipamentos AS e ON e.CDEQUIPAMENTO = c.CDEQUIPAMENTO and e.ID_BASE = c.ID_BASE
                                                    WHERE c.ID_BASE = {$params['idBase']}
                                                    AND c.empresa_id = {$params['empresaId']} 
                                                    AND c.CDEQUIPAMENTO = {$params['cdEquipamento']}
                                                    AND c.CDCLIENTEENT = {$params['cdCliente']}
                                                    AND c.STATUS NOT IN  ('O', 'C', 'R')
                                                    ORDER BY id DESC
                                                    LIMIT 1");


        

        if($query[0] != null){

            $query[0]['a'] = $query[0][0];
            unset($query[0][0]);

        }
        
        $this->response->body(json_encode($query[0]));
    }
}
