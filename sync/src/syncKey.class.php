<?php
include_once "pdo/class.lpdo.php";
//include "config/config.php";
/**
 * Created by PhpStorm.
 * User: Wagner
 * Date: 13/06/2016
 * Time: 16:38
 */
class syncKey
{
    public $db = '';
    public $config = '';
    public $empresa_id = '';
    public $cnpj = '';
    public $reg = '';
    public $id_base = '';


    public function __construct($config)
    {
        $this->config = $config;
        $this->db = new lpdo($this->config);
    }

    /** 
     * @param $ch1
     * @return integer
     */
    public function empresa($ch1, $cnpj)
    {
        unset($ch);
        $ch = array('ch' => $ch1, 'cnpj' => $cnpj);

        unset($empresa);
        $empresa = $this->db->get_one('empresas', $ch);

        unset($this->empresa_id);
        $this->empresa_id = $empresa['id'];

        unset($this->cnpj);
        $this->cnpj = $cnpj;

        unset($this->reg);
        $this->reg = $ch1;

        unset($this->id_base);
        $this->id_base = $empresa['matriz_id'];

        unset($this->nmfantasia);
        $this->nmfantasia = $empresa['empresa_fantasia'];

        return $this->empresa_id;
    }

    public function index($index, $evt, $versao)
    {
        $table = table($index);
        switch ($evt) {
            case 0:
                $sql = "select 'OS' as tables, COUNT(*)  from chamados where ATUALIZADO != 0  and ID_BASE = $this->id_base
                        union 
                        select 'Atendimento' as tables, COUNT(*)  from atendimentos where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union
                        select 'Equipamento' as tables, COUNT(*)  from equipamentos where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union
                        select 'Cliente' as tables, COUNT(*)  from clientes where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'Medidor' as tables, COUNT(*)  from medidores where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union
                        select 'EquipMedidor' as tables, COUNT(*)  from equipamento_medidores where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'EquipMedidorGarantia' as tables, COUNT(*)  from equipamento_medidores_it_g where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'Contrato' as tables, COUNT(*)  from contratos where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'ContratoEquipamento' as tables, COUNT(*)  from contrato_itens where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        -- select 'ContratoMedidor' as tables, COUNT(*)  from IXLCONTRATOSMED where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        -- union
                        select 'Produto' as tables, COUNT(*)  from produtos where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union
                        select 'DefeitoTipo' as tables, COUNT(*)  from defeitos where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'OrdemServicoStatus' as tables, COUNT(*)  from status where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union
                        select 'Suporte' as tables, COUNT(*)  from tecnicos where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union    
                        select 'SuporteTerritorio' as tables, COUNT(*)  from tecnico_territorios where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'OrdemServicoTipo' as tables, COUNT(*)  from chamado_tipos where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'ChecklistPergunta' as tables, COUNT(*)  from checklist_perguntas where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union        
                        select 'Checklist' as tables, COUNT(*)  from checklists where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'FichaTecnicaItem' as tables, COUNT(*)  from ficha_tecnica_it where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                        select 'NotaFiscalEntrega' as tables, COUNT(*)  from nfsaida_entregas where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union
                        select 'TransportadoraEntregador' as tables, COUNT(*)  from entregadores where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        union 
                         select 'Oportunidade' as tables, COUNT(*)  from oportunidades where ATUALIZADO != 0 and ID_BASE = $this->id_base
                         union 
                        select 'NotaFiscalSaida' as tables, COUNT(*)  from nfes where ATUALIZADO != 0 and ID_BASE = $this->id_base
                        order by 2 desc";

                $rs1 = $this->db->loadall($sql);

                //print_r($rs1[0]['COUNT(*)']);
                $results = 0;
                if ($rs1[0]['COUNT(*)'] > 0) {
                    $results = 1;
                }


                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results), JSON_NUMERIC_CHECK);
                return $json;
                break;
            case 5:
                $condition1 = array('id' => $this->empresa_id);
                $rs1 = $this->db->get_one($table, $condition1);

                if ($rs1 == true) {

                    // verifica o campo versão
                    if($rs1['versao'] == 0 && $versao == 1){

                        // atualiza o campo versao
                        $this->db->update($table, array('versao' => 1), array('id' => $this->empresa_id));

                    }

                    $json = json_encode(array('MSG' => 'Sucesso', 'SYNC_KEY' => $rs1['sync_key']), JSON_NUMERIC_CHECK);


                } else {
                    $json = json_encode(array('MSG' => 'Empresa não licenciada'), JSON_NUMERIC_CHECK);
                }

                //gravarLog("Tabela: - " . $json . " - " . " -  Empresa: " . $this->empresa_id . "; \n");
                return $json;
                break;

            default:
                $json = json_encode(array('MSG' => 'Erro Desconhecido!'));
                return $json;
                break;

        }
    }


}