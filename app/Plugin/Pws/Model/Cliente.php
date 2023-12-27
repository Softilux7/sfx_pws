<?php
App::uses ( 'PwsAppModel', 'Pws.Model' );
App::uses('BrValidation', 'Localized.Validation');
/**
 * Category Model
 *
 * @property Cliente $Cliente
*/
class Cliente extends PwsAppModel {


	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	*/

	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'AuthAcl.User',
			'joinTable' => 'users_clientes',
			'foreignKey' => 'cliente_id',
			'associationForeignKey' => 'user_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);



}
