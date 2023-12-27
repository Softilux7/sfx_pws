<?php
App::uses ( 'PwsAppModel', 'Pws.Model' );
App::uses ( 'BrValidation', 'Localized.Validation' );
/**
 * Category Model
 *
 * @property Tecnico $Tecnico
 *
 */
class Tecnico extends PwsAppModel {
	
	/**
	 * Validation rules
	 *
	 * @var array
	 */
	public $validate = array (
			'nome' => array (
					'rule' => 'notEmpty',
					'required' => true,
					'message' => 'Favor preencha o campo Nome!' 
			),
			'email' => array (
					'valid' => array (
							'rule' => 'email',
							'required' => true,
							'message' => 'Favor digite um Email v�lido' 
					) 
			) 
	);
	
	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	 */
	public $hasAndBelongsToMany = array(
			'Territorio' => array(
					'className' => 'Pws.Territorio',
					'joinTable' => 'tecnicos_territorios',
					'foreignKey' => 'tecnico_id',
					'associationForeignKey' => 'territorio_id',
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

	/**
	 * belongsTo associations
	 *
	 * @var array
	 */

	public $belongsTo = array (
			'User' => array (
					'className' => 'AuthAcl.User',
					'foreignKey' => 'user_id',
					'conditions' => '',
					'fields' => '',
					'order' => '' 
			) 
	);

}
