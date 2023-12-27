<?php
App::uses ( 'PwsAppModel', 'Pws.Model' );
App::uses('BrValidation', 'Localized.Validation');
/**
 * Category Model
 *
 * @property Contrato $Contrato
*/
class Contrato extends PwsAppModel {

	//

    public $belongsTo = array(
        'Cliente' => array(
            'className' => 'Pws.Cliente',
            'foreignKey' => false,
            'conditions' => array(
                'Contrato.CDCLIENTE= Cliente.CDCLIENTE',
                'Contrato.ID_BASE = Cliente.ID_BASE'
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        )

    );


}
