<?php
App::uses('AuthAclAppModel', 'AuthAcl.Model');
/**
 * TpEmails Model
 *
*/
class Tpemail extends AuthAclAppModel {

	var $useDbConfig = 'default';

	public $hasAndBelongsToMany = array(
			'User' => array(
					'className' => 'User',
					'joinTable' => 'users_tpemails',
					'foreignKey' => 'tpemail_id',
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


	public $validate = array(
			'tipo' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'Please enter the value for tipe of the email.'
					)
			),
	);

	public $actsAs = array('Acl' => array('type' => 'requester'));

	public function parentNode() {
		return null;
	}
}
