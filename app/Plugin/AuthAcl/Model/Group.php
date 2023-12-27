<?php
App::uses('AuthAclAppModel', 'AuthAcl.Model');
/**
 * Group Model
 *
*/
class Group extends AuthAclAppModel {

	var $useDbConfig = 'default';

	public $hasAndBelongsToMany = array(
			'User' => array(
					'className' => 'User',
					'joinTable' => 'users_groups',
					'foreignKey' => 'group_id',
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
			'name' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'Please enter the value for Group name.'
					)
			),
	);

	public $actsAs = array('Acl' => array('type' => 'requester'));

	public function parentNode() {
		return null;
	}
}
