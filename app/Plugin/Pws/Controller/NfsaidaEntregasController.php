<?php
App::uses ( 'PwsAppController', 'Pws.Controller' );
/**
 * Produtos Controller
 *
 * @property Produto $Produto
 *
 */
class NfsaidaEntregasController extends PwsAppController {
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {

		$auth_user = $this->Session->read('auth_user');
		$auth_user_group = $this->Session->read('auth_user_group');
		//$this->setarDB($this->conect);
		if ($this->request->isAjax()) {
			$this->layout = null;
		}
		$this->NfsaidaEntrega->recursive = 0;
		// print_r($auth_user);
		// Filtro de Chamados
		$this->Filter->addFilters('filter1');
		// Condição de filtragem inicial
		$conditions = array();
		//$conditions = $this->Filter->setPaginate ( 'conditions', $this->Filter->getConditions () );
		$paginate = array();
		$paginate ['conditions'] = $conditions;
		//$paginate ['order'] = 'NfsaidaEntrega.id DESC';
		$paginate ['limit'] = 15;
        $paginate ['order'] = 'NfsaidaEntrega.id DESC';
		$this->paginate = $paginate;

		$this->Filter->setPaginate('conditions', $this->Filter->getConditions());
		$this->set('NfsaidaEntrega', $this->paginate(array(
			'NfsaidaEntrega.ID_ENTREGADOR = ' => $auth_user['User']['entregador_id'],
			'NfsaidaEntrega.SITUACAO_ENTREGA = ' => 'T',
			'NfsaidaEntrega.empresa_id  ' => $this->empresa,
			'NfsaidaEntrega.ID_BASE = ' => $this->matriz,
		)));

	}

	public function edit($id = null){
		//$this->setarDB($this->conect);
		$this->autoRender = false;
		$this->NfsaidaEntrega->read ( null, $id );
		//$this->Cliente->Modulo(null, $id);
//		$this->Cliente->set(array('ds_versao' => $ultimaversao['Versao']['versao'],
//		'versao_id'=>$ultimaversao['Versao']['id']));


		if ($this->NfsaidaEntrega->saveField('NM_RECEBEDOR', $this->request->data('nmrecebedor'))) {
			$this->NfsaidaEntrega->saveField('DATAHORA', $this->request->data('datahora'));
			$this->NfsaidaEntrega->saveField('SITUACAO_ENTREGA', 'E');//Status Marcado como Entregue
			$this->NfsaidaEntrega->saveField('ATUALIZADO', '2');
			$errors[] = $this->Session->setFlash('Alteração realizada com sucesso!');
			$this->redirect(array(
				'action' => 'index'
			));
		} else {
			throw new NotFoundException ( __ ( 'Erro ao Atualizar registro' ) );
		}
		$this->set('errors', $errors);
	}

}
