<?php
App::uses('PwsAppModel', 'Pws.Model');
App::uses('BrValidation', 'Localized.Validation');

/**
 * Category Model
 *
 * @property ContratoIten $ContratoIten
 */
class ContratoIten extends PwsAppModel
{

    //
    public $belongsTo = array(
        'Contrato' => array(
            'className' => 'Pws.Contrato',
            'foreignKey' => false,
            'conditions' => array(
                'ContratoIten.SEQCONTRATO = Contrato.SEQCONTRATO',
                'ContratoIten.ID_BASE = Contrato.ID_BASE'
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        ),
        'GrupoContrato' => array(
            'className' => 'Pws.GrupoContrato',
            'foreignKey' => false,
            'conditions' => array(
                'Contrato.SEQCONTRATOGRP = GrupoContrato.SEQCONTRATOGRP',
                'Contrato.ID_BASE = GrupoContrato.ID_BASE'

            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        ),
        'Equipamento' => array(
            'className' => 'Pws.Equipamento',
            'foreignKey' => false,
            'conditions' => array(
                'ContratoIten.CDEQUIPAMENTO = Equipamento.CDEQUIPAMENTO',
                'ContratoIten.ID_BASE = Equipamento.ID_BASE'
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        ),
        'Cliente' => array(
            'className' => 'Pws.Cliente',
            'foreignKey' => false,
            'conditions' => array(
                'Equipamento.CDCLIENTE= Cliente.CDCLIENTE',
                'ContratoIten.SEQCONTRATO = Equipamento.SEQCONTRATO',
                'Equipamento.ID_BASE = Cliente.ID_BASE'
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        ),

    );

}
