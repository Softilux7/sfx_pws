<?php
App::uses ( 'AuthAclAppModel', 'AuthAcl.Model' );
/**
 * Category Model
 *
 * @property Empresa $Empresa
*/
class Cidade extends AuthAclAppModel {
	
	var $name = 'Cidade';
	var $displayField = 'nome';

	

}
