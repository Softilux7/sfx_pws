<?php
/**
 * Created by PhpStorm.
 * User: gsilva
 * Date: 31/10/17
 * Time: 13:18
 */

class DFaturamento extends PwsAppModel {

    public $belongsTo = array(
        'Cliente' => array(
            'className' => 'Pws.Cliente',
            'foreignKey' => false,
            'conditions' => array(
                'DFaturamento.id_fk_cliente = Cliente.id',
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        ),
        'Empresa' => array(
            'className' => 'AuthAcl.Empresa',
            'foreignKey' => false,
            'conditions' => array(
                'Cliente.empresa_id = Empresa.id',
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        )
    );

}