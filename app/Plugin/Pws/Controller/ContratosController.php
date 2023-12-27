<?php

App::uses('PwsAppController', 'Pws.Controller');

/**
 * Contratos Controller
 *
 * @property Contratos $Equipamento
 */
class ContratosController extends PwsAppController
{

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {
        $auth_user = $this->Session->read('auth_user');
        $auth_user_group = $this->Session->read('auth_user_group');
        $this->loadModel('Pws.Clientes');
        //$this->setarDB($this->conect);
        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->Contrato->recursive = 0;

        // Filtro de equipamentos
        $this->Filter->addFilters('filter1');
        // Condição de filtragem inicial
        $conditions = array();
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
                $contratos = $this->paginate(array(
                    'Contrato.empresa_id ' => $this->empresa,
                    'Contrato.ID_BASE = ' => $this->matriz,
                    'Contrato.STATUS' => array('G', 'I')
                ));
                break;
            case '9':
                $contratos = $this->paginate(array(
                    'Contrato.CDCLIENTE  ' => $this->cdCliente,
                    'Contrato.empresa_id ' => $this->empresa,
                    'Contrato.ID_BASE = ' => $this->matriz,
                    'Contrato.STATUS' => array('G', 'I')
                ));
                break;
            case '3': // Cliente
                $contratos = $this->paginate(array(
                    'Contrato.CDCLIENTE  ' => $this->cdCliente,
                    'Contrato.empresa_id  ' => $this->empresa,
                    'Contrato.ID_BASE = ' => $this->matriz,
                    'Contrato.STATUS' => array('G', 'I')
                ));
                break;
            case '2': // Técnico
                if (empty($auth_user['User']['cliente_id'])) {
                    $contratos = $this->paginate(array(
                        'Contrato.empresa_id  ' => $this->empresa,
                        'Contrato.ID_BASE = ' => $this->matriz,
                        'Contrato.STATUS' => array('G', 'I')
                    ));
                } else {
                    $contratos = $this->paginate(array(
                        'Contrato.CDCLIENTE  ' => $this->cdCliente,
                        'Contrato.empresa_id  ' => $this->empresa,
                        'Contrato.ID_BASE = ' => $this->matriz,
                        'Contrato.STATUS' => array('G', 'I')
                    ));
                }
                break;
            default:
                $this->redirect(array(
                    'controller' => 'ContratoItens',
                    'action' => 'index',
                ));
        }

        $this->set('contratos', $contratos);
    }
}
