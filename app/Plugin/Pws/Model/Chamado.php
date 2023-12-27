<?php
App::uses('PwsAppModel', 'Pws.Model');
App::uses('BrValidation', 'Localized.Validation');

/**
 * Ordem Model
 */
class Chamado extends PwsAppModel
{

public $validate = array(
    'CONTATO' => array(
        'rule' => 'notBlank',
        'message' => 'Favor preencha o campo Nome!'
    ),
    'DDD' => array(
        'required' => array(
            'rule' => array(
                'notBlank'
            ),
            'message' => 'Favor preencha um DDD válido!'
        )
    ),
    'FONE' => array(
        'valid' => array(
            'rule' => array(
                'phone',
                null,
                'br'
            ),
            'message' => 'Favor digite um Telefone válido!'
        )
    ),
    'EMAIL' => array(
        'required' => array(
            'rule' => array(
                'notBlank'
            ),
            'message' => 'Favor digite um Email!'
        ),
        'mustBeEmail' => array(
            'rule' => array(
                'email'
            ),
            'message' => 'Favor digite um Email Válido!'
        ),
    ),
    'OBSDEFEITOCLI' => array(
        'required' => array(
            'rule' => array(
                'notBlank'
            ),
            'message' => 'Favor descreva o defeito!'
        )
    )

);


/**
 * belongsTo associations
 *
 * @var array
 */
public
$belongsTo = array(
    'Equipamento' => array(
        'className' => 'Pws.Equipamento',
        'foreignKey' => false,
        'conditions' => array(
            'Chamado.ID_BASE = Equipamento.ID_BASE',
            'Chamado.cdequipamento = Equipamento.cdequipamento',
        ),
        'type' => 'INNER',
        'fields' => '',
        'order' => ''
    ),
    'ChamadoTipo' => array(
        'className' => 'Pws.ChamadoTipo',
        'foreignKey' => false,
        'conditions' => array(
            'Chamado.CDOSTP = ChamadoTipo.CDOSTP',
            'Chamado.ID_BASE = ChamadoTipo.ID_BASE'
        ),
        'fields' => '',
        'order' => ''
    ),
    'Defeito' => array(
        'className' => 'Pws.Defeito',
        'foreignKey' => false,
        'conditions' => array(
            'Chamado.CDDEFEITO = Defeito.CDDEFEITO',
            'Chamado.ID_BASE = Defeito.ID_BASE'
        ),
        'fields' => '',
        'order' => ''
    ),
    'ChamadoAvaliacao' => array(
        'className' => 'Pws.ChamadoAvaliacao',
        'foreignKey' => false,
        'conditions' => array(
            'Chamado.id = ChamadoAvaliacao.id_fk_chamado',
        ),
        'fields' => '',
        'order' => ''
    )
);

    /**
     * Sava os dados da avaliação
     *
     * @autor Gustavo Silva
     * @since 26/10/2017
     */
    public function saveRating($post){

        $this->useTable = 'chamado_avaliacao';

        // verificar se já foi feita a avaliação
        //$query = $this->Chamado->query("SELECT id_fk_chamados FROM chamados_avaliacao WHERE id_fk_chamados = {$post['idOS']}");

        // verifica
        $query = $this->query("SELECT id_fk_chamados FROM chamados_avaliacao WHERE id_fk_chamados = {$post['idOS']}");

        if(count($query) == 0){

            //$this->setSource('chamados_avaliacao');

            //_tst($this->find('first'));

        }

    }
    
    /**
     * Método de verificação antes executar o método salvar
     *
     * @autor Gustavo Silva
     * @since 22/02/2018
     *
     */
    function beforeSave($data = array()) {

        if(count($this->data['Chamado']) > 0){
        
            $num        = $this->data['Chamado']['NUM'];
            $cdCliente  = $this->data['Chamado']['CDCLIENTE'];
            $empresaId  = $this->data['Chamado']['empresa_id'];
            $idBase     = $this->data['Chamado']['ID_BASE'];
            $dtInclusao = $this->data['Chamado']['DTINCLUSAO'];
            $hrInclusao = $this->data['Chamado']['HRINCLUSAO'];
    
            // faz uma consulta para verifica se possui o registro
            $query = $this->query("SELECT id 
                                                FROM chamados 
                                                WHERE CDCLIENTE = {$cdCliente}
                                                AND empresa_id  = {$empresaId}
                                                AND ID_BASE     = {$idBase}
                                                AND num         = '{$num}'
                                                AND DTINCLUSAO  = '{$dtInclusao}'
                                                AND HRINCLUSAO  = '{$hrInclusao}:00'");
    
            return count($query) > 0 ? false : true;
        
        }else{
            
            return true;
            
        }

    }

}