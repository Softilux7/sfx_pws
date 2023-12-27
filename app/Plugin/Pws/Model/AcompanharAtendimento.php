<?php


class AcompanharAtendimento extends PwsAppModel
{

    public $useTable = 'atendimentos';

    public $belongsTo = array(
        'Chamado' => array(
            'className' => 'Pws.Chamado',
            'foreignKey' => false,
            'conditions' => array(
                'AcompanharAtendimento.chamado_id = Chamado.id',
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        ),
        'Cliente' => array(
            'className' => 'Pws.Cliente',
            'foreignKey' => false,
            'conditions' => array(
                'Cliente.ID_BASE = Chamado.ID_BASE',
                'Cliente.CDCLIENTE = Chamado.CDCLIENTE',
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        )
        /*'Cliente' => array(
            //'className' => 'AuthAcl.Empresa',
            'foreignKey' => false,
            'conditions' => array(
                'AcompanharAtendimento.empresa_id = Cliente.empresa_id',
            ),
            'type' => 'INNER',
            'fields' => '',
            'order' => ''
        )*/
    );

    public function timeline($id)
    {

        $this->useTable = 'app_atendimento_timeline';

        $query = $this->query(
            "SELECT DISTINCT id_transaction, ID_BASE, empresa_id, id_atendimento, create_at, andamento_chamado_snapshot, tipo_time_line, latitute, longitute, location_captured, motivo, motivo_outros 
                FROM app_atendimento_timeline "
                . "WHERE id_atendimento = {$id} "
                // . "AND location_captured = 1 "
                . "AND tipo_time_line = 1 "
                . "ORDER BY id_transaction,id ASC"
        );

        return $query;
    }

    public function locations($id)
    {

        $this->useTable = 'app_atendimento_timeline';

        $query = $this->query(
            "SELECT * FROM app_atendimento_timeline "
                . "WHERE id_atendimento = {$id} "
                . "AND location_captured = 1 "
                // . "AND id_transaction = 0 "
                . "ORDER BY create_at ASC"
        );

        return $query;
    }

    public function calcLatLong($latA, $longA, $latB, $longB) {

        $distance = sin(deg2rad($latA))
                      * sin(deg2rad($latB))
                      + cos(deg2rad($latA))
                      * cos(deg2rad($latB))
                      * cos(deg2rad($longA - $longB));
      
        $distance = (rad2deg(acos($distance))) * 69.09;
      
        return $distance;
    }

    public function image($id, $type)
    {

        $this->useTable = 'app_atendimento_photos';

        $query = $this->query("SELECT * FROM app_atendimento_photos WHERE id_atendimento = {$id} AND type = '{$type}' AND status = 1  ORDER BY id DESC");

        return $query;
    }

    public function getImage($id)
    {

        $this->useTable = 'app_atendimento_photos';

        $query = $this->query("SELECT * FROM app_atendimento_photos WHERE id = {$id} LIMIT 1");

        return $query;
    }

    public function getTecnico($idEmpresa, $idBase)
    {

        $this->useTable = 'tecnicos';

        $query = $this->query("SELECT NMSUPORTE, empresa_id FROM tecnicos WHERE empresa_id IN ({$idEmpresa}) AND ID_BASE = {$idBase} AND TFATIVO = 'S'");

        return $query;
    }

    public function getCliente($idEmpresa, $idBase)
    {

        $this->useTable = 'clientes';

        $query = $this->query("SELECT FANTASIA, empresa_id, CDCLIENTE FROM clientes WHERE empresa_id IN ({$idEmpresa}) AND ID_BASE = {$idBase}");

        return $query;
    }
}
