<?php

require_once "pdo/class.lpdo.php";
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 10/04/2019
 * Time: 23:48
 */

abstract class RestController
{
    public $db = '';

    public $config = '';

    public $empresa_id = '';

    public $empresas_ids = '';

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
        $ch = array('ch' => $ch1);

        unset($chCnpj);
        $chCnpj = array('ch' => $ch1, 'cnpj' => $cnpj);

        unset($empresa);
        $empresa = $this->db->get_one('empresas', $chCnpj);

        unset($empresas);
        $empresas = $this->db->get_rows('empresas', $ch, false, array('id'));
        $this->eachEmpresas($empresas);

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

    private function eachEmpresas($empresas)
    {
        $this->empresas_ids = '';
        if (!empty($empresas)) {
            foreach ($empresas as $empresa) {
                $this->empresas_ids = $this->empresas_ids . $empresa['id'] . ",";
            }
            $this->empresas_ids = rtrim($this->empresas_ids, ",");
        }
    }

    public function limparDados ($dados)
    {
        unset($dados['ATUALIZADO']);
        unset($dados['SEQILX']);
        unset($dados['SEQWEB']);

        return $dados;
    }
}