<?php
/**
 * Created by PhpStorm.
 * User: gsilva
 * Date: 26/10/17
 * Time: 15:18
 */
App::uses ( 'PwsAppModel', 'Pws.Model' );

class ChamadoAvaliacao extends PwsAppModel{


    public $belongsTo = array(
            'Chamado' => array(
                'className' => 'Pws.Chamado',
                'foreignKey' => false,
                'conditions' => array(
                    'ChamadoAvaliacao.id_fk_chamado = Chamado.id',
                    ),
                'type' => 'INNER',
                'fields' => '',
                'order' => ''
            ),
            'Cliente' => array(
                'className' => 'Pws.Cliente',
                'foreignKey' => false,
                'conditions' => array(
                    'Cliente.empresa_id = Chamado.empresa_id',
                    'Cliente.CDCLIENTE = Chamado.CDCLIENTE',
                ),
                'type' => 'INNER',
                'fields' => '',
                'order' => ''
            )
        );

}