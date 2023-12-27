<?php
App::uses('PwsAppModel', 'Pws.Model');

/**
 * Equipamento Model
 */
class Equipamento extends PwsAppModel
{
    /**
     * Validation rules
     *
     * @var array
     */
    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Produto' => array(
            'className' => 'Pws.Produto',
            'foreignKey' => false,
            'conditions' => array(
                'Equipamento.cdproduto = Produto.cdproduto',
                'Equipamento.ID_BASE = Produto.ID_BASE',
                // 'Equipamento.empresa_id = Produto.empresa_id'
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        ),
        'Cliente' => array(
            'className' => 'Pws.Cliente',
            'foreignKey' => false,
            'conditions' => array(
                'Equipamento.cdcliente = Cliente.cdcliente',
                'Equipamento.ID_BASE = Cliente.ID_BASE',
                // 'Equipamento.empresa_id = Cliente.empresa_id'
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        )

    );
}
