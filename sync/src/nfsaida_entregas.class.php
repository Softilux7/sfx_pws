<?php
include_once "pdo/class.lpdo.php";
require_once "RestController.php";
//include "config/config.php";
/**
 * Created by PhpStorm.
 * User: Wagner
 * Date: 13/06/2016
 * Time: 16:38
 */
class nfsaidaEntregas extends RestController
{
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

                $condition = 'ID_ENTREGA =' . $dados['SEQILX'];

                if ($dados['SEQWEB'] > 0) {
                    $condition .= ' AND id = ' . $dados['SEQWEB'];
                    $condition .= ' AND empresa_id in (' . $this->empresas_ids . ')';
                    $dados = $this->limparDados($dados);
                    $save = $this->db->update($table, $dados, $condition);
                } else {
                    $condition .= ' AND empresa_id = ' . $this->empresa_id;
                    $dados = $this->limparDados($dados);
                    $save = $this->db->save($table, $dados, $condition);
                }

                if ($save > 0) {
                    $colunas = array('id', 'ID_ENTREGA');
                    $return = $this->db->get_one($table, $condition, $colunas);

                    $json = json_encode(array(
                            'MSG' => 'Sucesso',
                            'SEQILX' => $return['ID_ENTREGA'],
                            'SEQWEB' => $return['id']
                        )
                    );
                    //gravarLog("Tabela: $table - " . $json . " - " . "ID_ENTREGA: " . $dados['ID_ENTREGA'] . " -  Empresa: " . $this->empresa_id . "; \n", $table);

                    return $json;

                } else {

                    $json = json_encode(array(
                        'MSG' => 'Erro',
                        'SEQILX' => $dados['ID_ENTREGA'],
                        'SEQWEB' => -1,
                        'SQL' => $this->db->sql,
                    ));

                    //gravarLog("Tabela: $table - " . json_encode($dados) . "  -  Empresa: " . $this->empresa_id . "; \n", $table);

                    return $json;
                }


                break;
            case 3: // Excluir registro

                //$condition = 'ID_ENTREGA= ' . $post['SEQILX'] . ' AND id= ' . $post['SEQWEB'];

                $condition = 'ID_ENTREGA =' . $post['SEQILX'];

                if ($post['SEQWEB'] > 0) {
                    $condition .= ' AND id = ' . $post['SEQWEB'];
                    $condition .= ' AND empresa_id in (' . $this->empresas_ids . ')';
                } else {
                    $condition .= ' AND empresa_id = ' . $this->empresa_id;
                }

                $save = $this->db->delete($table, $condition);

                $error = $this->db->errorInfo();

                if ($error[2] != NULL) {
                    $json = json_encode(array('MSG' => $error[2]));
                    //gravarLog("Tabela: $table - " . "ID_ENTREGA: " . $post['SEQILX'] . "empresa = " . $this->empresa_id . "/n" . $json . "/n", $table);

                    return $json;
                } else {
                    if ($save >= 0) {
                        $json = json_encode(array('MSG' => 'Sucesso'));
                        //gravarLog("Tabela: $table - " . "ID_ENTREGA: " . $post['SEQILX'] . " - " . "empresa = " . $this->empresa_id . " - " . $json, $table);
                        return $json;
                    }
                }
                break;

            case 4: // Retorno do sync ilux
                $condition1 = array('id' => $post['SEQWEB'], 'empresa_id' => $this->empresa_id);
                if (empty($post['ERR'])) {
                    $dados = array(
                        'ATUALIZADO' => '0',
                        'ERR' => '',
                        'ID_ENTREGA' => $post['SEQILX']
                    );
                } else {
                    $dados = array('ERR' => $post['ERR']);
                }

                $save = $this->db->update($table, $dados, $condition1);

                $error = $this->db->errorInfo();

                if ($error[2] != NULL) {
                    $json = json_encode(array('MSG' => $error[2]));
                    //gravarLog("Tabela: $table - " . "ID_ENTREGA: " . $post['SEQILX'] . " - Empresa: " . $this->empresa_id . " - " . $json, $table);
                    return $json;
                } else {
                    if ($save > 0) {
                        $json = json_encode(array('MSG' => 'Sucesso'));
                        //gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
                        return $json;
                    } else {
                        $json = json_encode(array('MSG' => 'Erro: Nao foi possivel alterar o registro'));
                        //gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
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