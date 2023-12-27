<?php
App::uses ( 'PwsAppModel', 'Pws.Model' );
App::uses('BrValidation', 'Localized.Validation');
/**
 * Category Model
 *
 * @property Territorio $Territorio
*/
class Territorio extends PwsAppModel {


	/**
	 * Validation rules
	 *
	 * @var array
	 */
    public $validate = array(
        'teritorio_nome' => array(
            'rule' => 'notEmpty',
        		'message' => 'Favor preencha o campo Territorio Nome!'
        )
    );
	
	/**
	 * hasAndBelongsToMany associations
	 *
	 * @var array
	*/
	public $hasAndBelongsToMany = array(
			'Tecnico' => array(
					'className' => 'Pws.Tecnico',
					'joinTable' => 'tecnicos_territorios',
					'foreignKey' => 'territorio_id',
					'associationForeignKey' => 'tecnico_id',
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
