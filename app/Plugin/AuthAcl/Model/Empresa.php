<?php
App::uses ( 'AuthAclAppModel', 'AuthAcl.Model' );
App::uses('BrValidation', 'Localized.Validation');
/**
 * Category Model
 *
 * @property Empresa $Empresa
*/
class Empresa extends AuthAclAppModel {

	var $useDbConfig = 'default';
	//var $actsAs = array('Pws.Upload');

	/**
	 * Validation rules
	 *
	 * @var array
	 */

    public $validate = array(
        'empresa_nome' => array(
            'rule' => 'notBlank',
        		'message' => 'Favor preencha o campo razão social!'
        ),
    	'empresa_fantasia' => array(
    				'rule' => 'notBlank',
    				'message' => 'Favor preencha o campo nome fantasia!'
    		),
       'cnpj' => array(
           'valid' => array( 
                'rule' =>array('ssn', null, 'br'), 
                  'message' => 'Favor digite um CNPJ válido'
            ) 
        ));
	
	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	*/
	public $hasAndBelongsToMany = array(
		'User' => array(
			'className' => 'AuthAcl.User',
			'joinTable' => 'users_empresas',
			'foreignKey' => 'empresa_id',
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

