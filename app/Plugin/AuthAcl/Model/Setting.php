<?php
App::uses('AuthAclAppModel', 'AuthAcl.Model');
/**
 * Group Model
 *
*/
class Setting extends AuthAclAppModel {

	var $useDbConfig = 'default';
	public $primaryKey = 'setting_key';

	public $general_validate = array(
			'email_address' => array(
					'required' => array(
							'rule' => array('notEmpty'),
							'message' => 'Please enter the value for User Email.'
					),
					'email' => array(
							'rule' => array('email'),
							'message' => 'Please provide a valid email address for User Email.'
					)
			)
	);
}