<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');

/**
 * Empresas Controller
 *
 * @property Empresa $Empresa
 *
 */
class EmpresasController extends AuthAclAppController
{
    public $components = array('RequestHandler', 'Upload');
    public $helpers = array('Js');

    public function index()
    {
        $auth_user = $this->Session->read('auth_user');
        if ($this->request->isAjax()) {
            $this->layout = null;
        }

        $this->Filter->addFilters('filter1');

        $this->Empresa->recursive = 0;
        $this->Filter->setPaginate('conditions', $this->Filter->getConditions());

        if ($auth_user ['User'] ['empresa_id'] == 1) { // se for usuario administrador da flix = 1
            $this->set('empresas', $this->paginate());
        } else {
            $this->set('empresas', $this->paginate(array(
                'id = ' => $auth_user ['User'] ['empresa_id']
            )));
        }
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        $auth_user = $this->Session->read('auth_user');
        $this->Empresa->id = $id;
        if (!$this->Empresa->exists()) {
            throw new NotFoundException (__('Invalid Empresa'));
        }
        $empresa = $this->Empresa->read(null, $id);

        if ($auth_user ['User'] ['empresa_id'] == 1) { // se for usuario administrador da flix = 1
            $this->set('empresa', $empresa);
        } else {
            if ($empresa ['Empresa'] ['empresa_id'] == $auth_user ['User'] ['empresa_id']) {
                $this->set('empresa', $empresa);
            } else {
                throw new NotFoundException (__('Invalid Empresa'));
            }
        }
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        App::import('Vendor', 'AuthAcl.functions');
        $errors = array();
        if ($this->request->is('post')) {

            if (!empty($this->data['Empresa']['logo']['name'])) {
                $this->request->data['Empresa']['logo'] = logoURL() . 'app/webroot/img/emp/' . UploadComponent::upload($this->data['Empresa']['logo']);
            } else {
                $this->request->data['Empresa']['logo'] = '';
            }

            if ($this->Empresa->save($this->request->data)) {
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $errors = $this->Empresa->validationErrors;
            }

            $this->Empresa->create();
            if ($this->Empresa->save($this->request->data)) {
                $this->Cookie->delete('srcPassArg');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $errors = $this->Empresa->validationErrors;
            }
        }
        $this->set('errors', $errors);
        self::getEstados();
    }

    /**
     * index method
     *
     * @return void
     */

    private function getEstados()
    {

        $this->loadModel('Estado');
        $this->loadModel('Cidade');
        $this->set('estados', $this->Estado->find('list', array('fields' => array('Estado.uf', 'Estado.uf'))));
        $this->set('cidades', $this->Cidade->find('list', array('fields' => array('Cidade.nome', 'Cidade.nome'))));
        $this->set(compact("estados"));
        $this->set(compact("cidades"));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        $auth_user = $this->Session->read('auth_user');
        $errors = array();
        $this->Empresa->id = $id;
        App::import('Vendor', 'AuthAcl.functions');

        if (!$this->Empresa->exists()) {
            throw new NotFoundException (__('Invalid Empresa'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {


            if (!empty($this->data['Empresa']['logo']['name'])) {
                $this->request->data['Empresa']['logo'] = logoURL() . 'app/webroot/img/emp/' . UploadComponent::upload($this->data['Empresa']['logo']);
            } else {
                $this->request->data['Empresa']['logo'] = $this->data['Empresa']['logo1'];
            }

            if ($this->Empresa->save($this->request->data)) {
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $errors = $this->Empresa->validationErrors;
            }

        } else {
            if ($auth_user ['User'] ['empresa_id'] == 1) { // se for usuario administrador da flix = 1
                $this->request->data = am($this->request->data, $this->Empresa->read(null, $id));
            } else {
                $empresa = $this->Empresa->read(null, $id);
                if ($empresa ['Empresa'] ['id'] == $auth_user ['User'] ['empresa_id']) {
                    $this->request->data = am($this->request->data, $this->Empresa->read(null, $id));
                } else {
                    throw new NotFoundException (__('Empresa invalida!'));
                }
            }
        }
        self::getEstados();
        $this->set('errors', $errors);
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->autoRender = false;
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException ();
        }
        $this->Empresa->id = $id;
        if (!$this->Empresa->exists()) {
            throw new NotFoundException (__('Invalid Empresa'));
        }
        if ($this->Empresa->delete()) {
            // $this->Session->setFlash(__('Empresa deleted'));
            // $this->redirect(array('action' => 'index'));
        }
        // $this->Session->setFlash(__('Empresa was not deleted'));
        // $this->redirect(array('action' => 'index'));
    }


    public function listar_cidades_json()
    {
        $this->layout = null;
        $this->loadModel('Cidade');
        if ($this->request->is('ajax')) {
            $this->set('cidades', $this->Cidade->find('list', array('fields' => array('nome', 'nome'), 'conditions' =>
                array('uf' => $this->request['url']['estadoId']),
                'recursive' => -1)));

            //var_dump($cidades);
        }

    }

}

