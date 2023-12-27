<?php
App::uses('PwsAppController', 'Pws.Controller');

/**
 * Equipamentos Controller
 *
 * @property Equipamento $Equipamento
 */
class DefeitosController extends PwsAppController
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
        $this->loadModel('Pws.Defeito');
        //$this->setarDB($this->conect);
        if ($this->request->isAjax()) {
            $this->layout = null;
        }


        $this->Defeito->recursive = 0;

        // Filtro de equipamentos
        $this->Filter->addFilters('filter1');
        // Condição de filtragem inicial
        $conditions = array();
        //$conditions = $this->Filter->setPaginate ( 'conditions', $this->Filter->getConditions () );
        $paginate = array();
        $paginate ['conditions'] = $conditions;
        $paginate ['limit'] = 15;
        $this->paginate = $paginate;

        if ($this->request->is('post') || $this->request->is('put') || $this->request->is('get')) {
            $this->Filter->setPaginate('conditions', $this->Filter->getConditions());
        }


        // Lista de acordo com o o grupo do usuário
        switch ($auth_user_group['id']) {
            case '1': // Admin
            case '6':
            case '7':
                $defeitos = $this->paginate(array(
                    'Defeito.empresa_id  ' => $this->empresa,
                    'Defeito.ID_BASE = ' => $this->matriz,
                    'Defeito.TFINATIVO = ' => 'N'
                ));
                break;
            default:
                $this->redirect(array(
                    'controller' => 'ContratoItens',
                    'action' => 'index',
                ));
        }

        $this->set('defeitos', $defeitos);
    }

    public function changeStatus()
    {
        $this->autoRender = false;

        $defeito = $this->Defeito->read(null, $this->request->data ['Defeito'] ['id']);
        $this->request->data ['Defeito'] = am($defeito ['Defeito'], $this->request->data ['Defeito']);
        $this->Defeito->data = $this->request->data;
        $this->Defeito->save($this->request->data, false);

    }

}
