<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');
/**
 * Groups Controller
 *
*/
class GroupsController extends AuthAclAppController {

	public function index(){
		if ($this->request->isAjax()){
			$this->layout = null;
		}
		$this->set('groups', $this->Group->find('listAll'));
	}
	public function add() {
		$this->autoRender = false;
		$var = array();
		if ($this->request->is('post') && $this->request->isAjax()) {
			$this->Group->create();
			if ($this->Group->save($this->request->data)) {
				$var['error'] = 0;
			} else {
				$var['error'] = 1;
				$errors = $this->Group->validationErrors;
				$var['error_message'] = implode('<br />', $errors['name']);
			}
		}
		echo json_encode($var);
	}

	public function edit($id = null) {
		$this->autoRender = false;
		$var = array();
		$this->Group->id = $id;
		if ($this->Group->exists() && $this->request->isAjax()) {
			if ($this->request->is('post') || $this->request->is('put')) {
				if ($this->Group->save($this->request->data)) {
					$var['error'] = 0;
				} else {
					$var['error'] = 1;
					$errors = $this->Group->validationErrors;
					$var['error_message'] = implode('<br />', $errors['name']);
				}
			}
		}
		echo json_encode($var);
	}

	public function delete($id = null) {
		$this->autoRender = false;
		if ($this->request->is('post') && $this->request->isAjax()) {
			$this->Group->id = $id;
			if ($this->Group->exists()) {
				$this->Group->delete();
			}
		}

	}
}
