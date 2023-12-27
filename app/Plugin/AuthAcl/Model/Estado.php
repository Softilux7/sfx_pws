<?php
App::uses ( 'AuthAclAppModel', 'AuthAcl.Model' );
/**
 * Category Model
 *
 * @property Empresa $Empresa
*/
class Estado extends AuthAclAppModel {
	
	var $name = 'Estado';
	var $displayField = 'nome';
	var $validate = array(
		'nome' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);


}
