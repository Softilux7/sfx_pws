<?php
App::uses('PwsAppModel', 'Pws.Model');
App::uses('BrValidation', 'Localized.Validation');

/**
 *  NfsaidaEntrega Model
 *
 * @property  NfsaidaEntrega $NfsaidaEntrega
 */
class NfsaidaEntrega extends PwsAppModel
{


    public $belongsTo = array(
        'Entregadore' => array(
            'className' => 'Pws.Entregadore',
            'foreignKey' => False,
            'type' => 'inner',
            'conditions' => array (
                'NfsaidaEntrega.ID_ENTREGADOR = Entregadore.ID_ENTREGADOR',
                'NfsaidaEntrega.ID_BASE = Entregadore.ID_BASE'
            )
        ),
        'Nfe' => array(
            'className' => 'Pws.Nfe',
            'foreignKey' => False,
            'type' => 'inner',
            'conditions' => array (
                'NfsaidaEntrega.SEQINCNFS = Nfe.SEQINCNFS',
                'NfsaidaEntrega.ID_BASE = Nfe.ID_BASE'
            )
        ),

        );

}
