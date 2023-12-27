<?php
App::uses('PwsAppModel', 'Pws.Model');
App::uses('BrValidation', 'Localized.Validation');

/**
 * SolicitacaoSuprimento Model
 *
 * @property SolicitacaoSuprimento $SolicitacaoSuprimento
 */
class SolicitacaoSuprimento extends PwsAppModel
{


    public $belongsTo = array(
        'SuprimentoTipo' => array(
            'className' => 'Pws.SuprimentoTipo',
            'foreignKey' => 'suprimento_tipo_id',
        ),
    );

}
