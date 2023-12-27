<?php
App::uses ( 'PwsAppController', 'Pws.Controller' );
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 *
 */ 
class ClientesController extends PwsAppController {
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$auth_user = $this->Session->read ( 'auth_user' );
		
		if ($this->request->isAjax ()) {
			$this->layout = null;
		}
		
		$this->Filter->addFilters ( 'filter1' );
		
		$this->Cliente->recursive = 0;
		$this->Filter->setPaginate ( 'conditions', $this->Filter->getConditions () );
		
		if ($auth_user ['User'] ['empresa_id'] == 1) { // se for usuario administrador da flix = 1
			
			$this->set ( 'clientes', $this->paginate () );
		} else {
			/* >>>9 */
			if ($auth_user ['User'] ['user_filial'] == 1) {
				$this->set ( 'clientes', $this->paginate ( array (
						'empresa_id = ' => $auth_user ['User'] ['filial_id'] 
				) ) );
			} elseif (! $auth_user ['User'] ['user_filial'] == 1) {
				$this->set ( 'clientes', $this->paginate ( array (
						'empresa_id = ' => $auth_user ['User'] ['empresa_id'] 
				) ) );
			}
			/* <<<9 */
		}
	}
	
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function view($id = null) {
		$auth_user = $this->Session->read ( 'auth_user' );
		$this->Cliente->id = $id;
		if (! $this->Cliente->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
		}
		
		$cliente = $this->Cliente->read ( null, $id );
		
		if ($auth_user ['User'] ['empresa_id'] == 1) { // se for usuario administrador da flix = 0
			$this->set ( 'cliente', $cliente );
		} else {
			/* >>>9 */
			if ($auth_user ['User'] ['user_filial'] == 1) {
				if ($cliente ['Cliente'] ['empresa_id'] == $auth_user ['User'] ['filial_id']) {
					$this->set ( 'cliente', $cliente );
				} else {
					throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
				}
			} elseif (! $auth_user ['User'] ['user_filial'] == 1) {
				if ($cliente ['Cliente'] ['empresa_id'] == $auth_user ['User'] ['empresa_id']) {
					$this->set ( 'cliente', $cliente );
				} else {
					throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
				}
			}
			/* <<<9 */
		}
	}
	
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		$errors = array ();
		$auth_user = $this->Session->read ( 'auth_user' );
		if ($this->request->is ( 'post' )) {
			$this->Cliente->create ();
			/* >>>9 */
			if (! $auth_user ['User'] ['user_filial'] == 1) {
				//$this->Cliente->empresa_id = $auth_user ['User'] ['empresa_id'];
				$this->request->data['Cliente']['empresa_id'] = $auth_user ['User'] ['empresa_id'];
			} else {
				//$this->Cliente->empresa_id = $auth_user ['User'] ['filial_id'];
				$this->request->data['Cliente']['empresa_id'] = $auth_user ['User'] ['filial_id'];
			}
			/* <<<9 */
			
			if ($this->Cliente->save ( $this->request->data )) {
				$this->redirect ( array (
						'action' => 'index' 
				) );
			} else {
				$errors = $this->Cliente->validationErrors;
			}
		}
		$this->set ( 'errors', $errors );
	}
	
	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function edit($id = null) {
		$auth_user = $this->Session->read ( 'auth_user' );
		$errors = array ();
		$this->Cliente->id = $id;
		if (! $this->Cliente->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
		}
		if ($this->request->is ( 'post' ) || $this->request->is ( 'put' )) {
			if ($this->Cliente->save ( $this->request->data )) {
				$this->redirect ( array (
						'action' => 'index' 
				) );
			} else {
				$errors = $this->Cliente->validationErrors;
			}
		} else {
			
			if ($auth_user ['User'] ['empresa_id'] == 1) { // se for usuario administrador da flix = 0
				$this->request->data = am ( $this->request->data, $this->Cliente->read ( null, $id ) );
			} else {
				$cliente = $this->Cliente->read ( null, $id );
				/* >>>9 */
				if (! $auth_user ['User'] ['user_filial'] == 1) {
					if ($cliente ['Cliente'] ['empresa_id'] == $auth_user ['User'] ['empresa_id']) {
						$this->request->data = am ( $this->request->data, $this->Cliente->read ( null, $id ) );
					} else {
						throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
						// $this->Session->setFlash(__('Cliente deleted'));
						// $this->redirect(array('action' => 'index'));
					}
				} else {
					if ($cliente ['Cliente'] ['empresa_id'] == $auth_user ['User'] ['filial_id']) {
						$this->request->data = am ( $this->request->data, $this->Cliente->read ( null, $id ) );
					} else {
						throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
						// $this->redirect(array('action' => 'index'));
					}
				}
				/* <<<9 */
			}
		}
		$this->set ( 'errors', $errors );
	}
	
	/**
	 * delete method
	 *
	 * @throws MethodNotAllowedException
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function delete($id = null) {
		$auth_user = $this->Session->read ( 'auth_user' );
		$this->autoRender = false;
		if (! $this->request->is ( 'post' )) {
			throw new MethodNotAllowedException ();
		}
		$this->Cliente->id = $id;
		if (! $this->Cliente->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
		}
		
		if ($auth_user ['User'] ['empresa_id'] == 1) { // se for usuario administrador da flix = 0
			$this->Cliente->delete ();
		} else {
			/* >>>9 */
			$cliente = $this->Cliente->read ( null, $id );
			if (! $auth_user ['User'] ['user_filial'] == 1) {
				if ($cliente ['Cliente'] ['empresa_id'] == $auth_user ['User'] ['empresa_id']) {
					$this->Cliente->delete ();
				} else {
					throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
					 //$this->Session->setFlash(__('Cliente deleted'));
					// $this->redirect(array('action' => 'index'));
				}
			} else {
				if ($cliente ['Cliente'] ['empresa_id'] == $auth_user ['User'] ['filial_id']) {
					$this->Cliente->delete ();
				} else {
					throw new NotFoundException ( __ ( 'Invalid Cliente' ) );
					// $this->redirect(array('action' => 'index'));
				}
			}
			/* <<<9 */
		}

	}
}
