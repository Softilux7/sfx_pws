<?php
include_once "pdo/class.lpdo.php";
//include "config/config.php";

/**
 * Created by PhpStorm.
 * User: Wagner
 * Date: 13/06/2016
 * Time: 16:38
 */
class mobile
{
    public $db = '';
    public $config = '';
    public $empresa_id = '';
    public $cnpj = '';
    public $reg = '';
    public $id_base = '';
    public $nmsuportet = '';
    public $err = '';


    public function __construct($config)
    {
        $this->config = $config;
        $this->db = new lpdo($this->config);
    }


    public function empresa($post)
    {

        if (empty($post['CH']) || empty($post['CNPJSYNC']) || empty($post['IMEI'])) {
            echo json_encode(array('RETORNO' => 'ERRO', 'MSG' => 'UM OU MAIS PARAMETROS OBRIGATORIOS NAO PREENCHIDOS'));
            exit;
        }


        $condition_emp = array('ch' => $post['CH'], 'cnpj' => $post['CNPJSYNC']);
        $empresa = $this->db->get_one('empresas', $condition_emp);
        $this->cnpj = $empresa['cnpj'];
        $this->reg = $empresa['ch'];
        $this->id_base = $empresa['matriz_id'];

        if (!isset($empresa['cnpj'])) {
            echo json_encode(array('RETORNO' => 'ERRO', 'MSG' => 'CNPJ OU CH NÃO ENCONTRADO'));
            exit;
        }


        $condition_tec = array('ID_BASE' => $this->id_base, 'IMEI' => $post['IMEI']);
        $tecnico = $this->db->get_one('tecnicos', $condition_tec);
        $this->nmsuportet = $tecnico['NMSUPORTE'];

        if (!isset($tecnico['NMSUPORTE'])) {
            echo json_encode(array('RETORNO' => 'ERRO', 'MSG' => 'TECNICO NÃO LOCALIZADO NA BASE WEB OU IMEI INVALIDO'));
            exit;
        }


    }



    public function index($evt, $post)
    {
        //$table = table($index);
        switch ($evt) {
            case 1: // Listar chamados do dia
                $dataChamado = date('Y-m-d');
                //$dataChamado= '2017-04-24';

                //$condition1 = array('ID_BASE' => $this->id_base, 'NMSUPORTET'=>$this->nmsuportet, 'DTPREVENTREGA'=>$dataChamado);
                $condition1 = 'ID_BASE = ' . $this->id_base . ' AND NMSUPORTET = ' . "'" . $this->nmsuportet . "'" . ' AND DTPREVENTREGA = ' . "'" . $dataChamado . "'";
                $condition1 .= " AND STATUS = 'P'";
                $rs1 = $this->db->get_rows('chamados', $condition1);
                $results = array();

                foreach ($rs1 as $key => $rows) {

                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", array_change_key_case($rows, CASE_UPPER));
                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];
                }

                $json = json_encode(array('RETORNO' => 'OK', 'MSG' => 'SUCESSO', 'CNPJ' => $this->cnpj, 'CH' => $this->reg, 'DADOS' => $results));

                return $json;
                break;

            default:
                $json = json_encode(array('RETORNO' => 'ERRO', 'MSG' => 'EVENTO NÃO IMPLEMENTADO'));
                return $json;
                break;

        }
    }


}