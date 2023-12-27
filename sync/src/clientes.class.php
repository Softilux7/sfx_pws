<?php
include_once "pdo/class.lpdo.php";
require_once "RestController.php";

/**
 * Created by PhpStorm.
 * User: Wagner
 * Date: 13/06/2016
 * Time: 16:38
 */
class clientes extends RestController
{
    // public $db = '';
    // public $config = '';
    // public $empresa_id = '';
    // public $cnpj = '';
    // public $reg = '';
    // public $id_base = '';


    // public function __construct($config)
    // {
    //     $this->config = $config;
    //     $this->db = new lpdo($this->config);
    // }

    // /**
    //  * @param $ch1
    //  * @return integer
    //  */
    // public function empresa($ch1, $cnpj)
    // {
    //     unset($ch);
    //     $ch = array('ch' => $ch1, 'cnpj' => $cnpj);

    //     unset($empresa);
    //     $empresa = $this->db->get_one('empresas', $ch);

    //     unset($this->empresa_id);
    //     $this->empresa_id = $empresa['id'];

    //     unset($this->cnpj);
    //     $this->cnpj = $cnpj;

    //     unset($this->reg);
    //     $this->reg = $ch1;

    //     unset($this->id_base);
    //     $this->id_base = $empresa['matriz_id'];

    //     unset($this->nmfantasia);
    //     $this->nmfantasia = $empresa['empresa_fantasia'];

    //     return $this->empresa_id;
    // }

    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function index($index, $evt, $post)
    {
        $table = table($index);
        switch ($evt) {
            case 0: // Listar registros Incluidos pendentes de sincronismo
                $condition1 = array('ATUALIZADO' => '1', 'empresa_id' => $this->empresa_id);
                $rs1 = $this->db->get_rows($table, $condition1);
                $results = array();
                foreach ($rs1 as $key => $rows) {
                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];
                }
                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results), JSON_NUMERIC_CHECK);
                return $json;
                break;
            case 1: // Listar registros atualizados pendentes de sincronismo
                $condition1 = array('ATUALIZADO' => '2', 'empresa_id' => $this->empresa_id);
                $rs1 = $this->db->get_rows($table, $condition1);
                $results = array();
                foreach ($rs1 as $key => $rows) {
                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];
                }
                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results), JSON_NUMERIC_CHECK);
                return $json;
                break;
            case 2:
                // Registro alterado ou incluido ILUX
                $dados = array();
                foreach ($post as $key => $value) {
                    $dados["$key"] = str_replace("'", " ", str_replace("{QUEBRALINHA}", " /n ", $value));
                }
                unset($dados['LST']);
                unset($dados['EVT']);
                unset($dados['CH']);
                unset($dados['CNPJSYNC']);
                unset($dados['id']);
                $dados['ATUALIZADO_WEB'] = date('Y-m-d H:i:s');
                $dados['ATUALIZADO_ILUX'] = $dados['ATUALIZADO'];
                $dados['empresa_id'] = $this->empresa_id;
                $dados['ID_BASE'] = $this->id_base;

                $condition = 'CDCLIENTE =' . $dados['SEQILX'] . ' AND ID_BASE= ' . $this->id_base;

                unset($dados['ATUALIZADO']);
                unset($dados['SEQILX']);
                // unset($dados['SEQWEB']);

                // $save = $this->db->save($table, $dados, $condition);
                $SEQWEB = isset($dados['SEQWEB']) ? $dados['SEQWEB'] : -1;
                
                if ($dados['SEQWEB'] > 0) {
                    $condition .= ' AND id = ' . $dados['SEQWEB'];
                    // $condition .= ' AND empresa_id in (' . $this->empresas_ids . ')';
                    $dados = $this->limparDados($dados);
                    
                    $check = $this->db->get_one($table, $condition, array('id'));
                    
                    $save = 0;
                    if($check != false){
                        $save = $this->db->update($table, $dados, $condition);
                    }
                    
                } else {
                    $condition .= ' AND empresa_id = ' . $this->empresa_id;
                    $dados = $this->limparDados($dados);
                    $save = $this->db->save($table, $dados, $condition);
                }

                if ($save > 0) {
                    $colunas = array('id', 'CDCLIENTE');
                    $return = $this->db->get_one($table, $condition, $colunas);

                    $json = json_encode(array(
                            'MSG' => 'Sucesso',
                            'SEQILX' => $return['CDCLIENTE'],
                            'SEQWEB' => $return['id']
                        )
                    );
                    //gravarLog("Tabela: $table - " . $json . " - " . "CDCLIENTE: " . $dados['CDCLIENTE'] . " -  Empresa: " . $this->empresa_id . "; \n", $table);

                    return $json;

                } else {

                    $json = json_encode(array(
                        'MSG' => 'Erro',
                        'SEQILX' => $dados['CDCLIENTE'],
                        'SEQWEB' => $SEQWEB,
                        'SQL' => $this->db->sql,
                    ));

                    //gravarLog("Tabela: $table - " . json_encode($dados) . "  -  Empresa: " . $this->empresa_id . "; \n", $table);

                    return $json;
                }


                break;
            case 3: // Excluir registro

                //$condition = 'CDCLIENTE= ' . $post['SEQILX'] . ' AND ID_BASE= ' . $this->id_base;

                $condition = 'CDCLIENTE =' . $post['SEQILX'] . ' AND ID_BASE= ' . $this->id_base;

                if ($post['SEQWEB'] > 0) {
                    $condition .= ' AND id= ' . $post['SEQWEB'];
                }

                $save = $this->db->delete($table, $condition);

                $error = $this->db->errorInfo();

                if ($error[2] != NULL) {
                    $json = json_encode(array('MSG' => $error[2]));
//                    gravarLog("Tabela: $table - " . "CDCLIENTE: " . $post['SEQILX'] . "empresa = " . $this->empresa_id . "/n" . $json . "/n", $table);

                    return $json;
                } else {
                    if ($save >= 0) {
                        $json = json_encode(array('MSG' => 'Sucesso'));
  //                      gravarLog("Tabela: $table - " . "CDCLIENTE: " . $post['SEQILX'] . " - " . "empresa = " . $this->empresa_id . " - " . $json, $table);
                        return $json;
                    }
                }
                break;

            case 4: // Retorno do sync ilux
                $condition1 = array('id' => $post['SEQWEB'], ' ID_BASE' => $this->id_base);
                if (empty($post['ERR'])) {
                    $dados = array(
                        'ATUALIZADO' => '0',
                        'ERR' => '',
                        'CDCLIENTE' => $post['SEQILX']
                    );
                } else {
                    $dados = array('ERR' => $post['ERR']);
                }

                $save = $this->db->update($table, $dados, $condition1);

                $error = $this->db->errorInfo();

                if ($error[2] != NULL) {
                    $json = json_encode(array('MSG' => $error[2]));
                    //gravarLog("Tabela: $table - " . "CDCLIENTE: " . $post['SEQILX'] . " - Empresa: " . $this->empresa_id . " - " . $json, $table);
                    return $json;
                } else {
                    if ($save > 0) {
                        $json = json_encode(array('MSG' => 'Sucesso'));
                        //gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
                        return $json;
                    } else {
                        $json = json_encode(array('MSG' => 'Erro: Nao foi possivel alterar o registro'));
                       // gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
                        return $json;
                    }
                }

                break;
            default:
                $json = json_encode(array('MSG' => 'Erro Desconhecido!'));
                return $json;
                break;

        }
    }


}
