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
class chamados extends RestController
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function index($index, $evt, $post)
    {
        $table = table($index); // Seleciona a tabela

        switch ($evt) {
            case 0: // Listar registros Incluidos pendentes de sincronismo
                $condition1 = array('ATUALIZADO' => '1', 'empresa_id' => $this->empresa_id);
                $rs1 = $this->db->get_rows($table, $condition1);

                $results = array();
                foreach ($rs1 as $key => $rows) {
                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
                   // $results[$key]['CDDEFEITO'] = (string)$results[$key]['CDDEFEITO'];
                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];
                    //$defeito = $results[$key]['CDDEFEITO'];

                }

                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results));
                //gravarLog("Tabela: $table - " . $json . " - " . " -  Empresa: " . $this->empresa_id . "; \n", $table);
                return $json;
                break;
            case 1: // Listar registros Alterados pendentes de sincronismo
                $condition1 = array('ATUALIZADO' => '2', 'empresa_id' => $this->empresa_id);
                $rs1 = $this->db->get_rows($table, $condition1);

                $results = array();
                foreach ($rs1 as $key => $rows) {
                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
                    // $results[$key]['CDDEFEITO'] = (string) $results[$key]['CDDEFEITO'];
                    //$defeito = $results[$key]['CDDEFEITO'];
                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];
//                    if (is_int($results[$key]['CDDEFEITO'])) {
//                        $results[$key]['CDDEFEITO'] = (int) $defeito;
//                    }

                }

                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results));
               // gravarLog("Tabela: $defeito  - " . $json . " - " . "SEQOS: " . " -  Empresa: " . $this->empresa_id . "; \n", $table);
                return $json;
                break;
            case 2:
                // Modificado ou incluido origem ILUX.
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

                $condition = 'SEQOS= ' . $dados['SEQILX'];

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
                    $colunas = array('id', 'SEQOS');
                    $return = $this->db->get_one($table, $condition, $colunas);

                    $json = json_encode(array(
                            'MSG' => 'Sucesso',
                            'SEQILX' => $return['SEQOS'],
                            'SEQWEB' => $return['id']
                        )
                    );
                    //gravarLog("Tabela: $table - " . $json . " - " . "SEQOS: " . $dados['SEQOS'] . " -  Empresa: " . $this->empresa_id . "; \n", $table);

                    //$this->db->gravarLogBD($this->empresa_id,$this->id_base,$this->nmfantasia,$table,$evt,$json);

                    return $json;

                } else {

                    $json = json_encode(array(
                        'MSG' => 'Erro',
                        'SEQILX' => $dados['SEQOS'],
                        'SEQWEB' => -1,
                        'SQL' => $this->db->sql,
                    ));

                    //gravarLog("Tabela: $table - " . json_encode($dados) . "  -  Empresa: " . $this->empresa_id . "; \n", $table);
                    //$this->db->gravarLogBD($this->empresa_id,$this->id_base,$this->nmfantasia,$table,$evt,$json);
                    return $json;
                }

                break;

            case 3: // Excluir registro

                //$condition = 'SEQOS= ' . $post['SEQILX'] . ' AND id= ' . $post['SEQWEB'];

                $condition = 'SEQOS= ' . $post['SEQILX'];

                if ($post['SEQWEB'] > 0) {
                    $condition .= ' AND id = ' . $post['SEQWEB'];
                    $condition .= ' AND empresa_id in (' . $this->empresas_ids . ')';
                } else {
                    $condition .= ' AND empresa_id = ' . $this->empresa_id;
                }

                $save = $this->db->delete($table, $condition);

                $error = $this->db->errorInfo();

                if ($error[2] != NULL) {
                    //$json = json_encode($error);
                    $json = json_encode(array('MSG' => $error[2]));
                    //gravarLog("Tabela: $table - " . "SEQOS: " . $post['SEQILX'] . " - Empresa: " . $this->empresa_id . " - " . $json, $table);
                    //$this->db->gravarLogBD($this->empresa_id,$this->id_base,$this->nmfantasia,$table,$evt,$json);
                    return $json;
                } else {
                    if ($save >= 0) {
                        $json = json_encode(array('MSG' => 'Sucesso', 'SEQOS' => $post['SEQILX']));
                       // gravarLog("Tabela: $table - " . "SEQOS: " . $post['SEQILX'] . " - Empresa: " . $this->empresa_id . " - " . $json, $table);
                        //$this->db->gravarLogBD($this->empresa_id,$this->id_base,$this->nmfantasia,$table,$evt,$json);
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
                        'SEQOS' => $post['SEQILX']
                    );
                } else {
                    $dados = array('ERR' => $post['ERR']);
                }

                $save = $this->db->update($table, $dados, $condition1);

                $error = $this->db->errorInfo();

                if ($error[2] != NULL) {
                    $json = json_encode(array('MSG' => $error[2]));
                    //gravarLog("Tabela: $table - " . "SEQOS: " . $post['SEQILX'] . " - Empresa: " . $this->empresa_id . " - " . $json, $table);
                    //$this->db->gravarLogBD($this->empresa_id,$this->id_base,$this->nmfantasia,$table,$evt,$json);
                    return $json;
                } else {
                    if ($save > 0) {
                        $json = json_encode(array('MSG' => 'Sucesso'));
                        //gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
                        //$this->db->gravarLogBD($this->empresa_id,$this->id_base,$this->nmfantasia,$table,$evt,$json);
                        return $json;
                    } else {
                        $json = json_encode(array('MSG' => 'Erro: Nao foi possivel alterar o registro'));
                        //gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
                        //$this->db->gravarLogBD($this->empresa_id,$this->id_base,$this->nmfantasia,$table,$evt,$json);
                        return $json;
                    }
                }

                break;
            case 7: // retorna o resultado de uma query
                // $condition1 = array('ATUALIZADO' => '2', 'empresa_id' => $this->empresa_id);

                $tecnico = "select NMSUPORTE from tecnicos where IMEI='{$post['IMEI']}'";
                $obj = $this->db->load($tecnico);

                if (isset($post['IMEI'])) {
                    $post['CONSULTA'] = str_replace('1=1', '1=1 AND NMSUPORTET = ' . "'{$obj->NMSUPORTE}'", $post['CONSULTA']);
                }

                $post['CONSULTA'] = str_replace('1=1', '1=1 AND empresa_id = ' . "'{$this->empresa_id}'", $post['CONSULTA']);
                $post['CONSULTA'] = str_replace('1=1', '1=1 AND ID_BASE = ' . "'{$this->id_base}'", $post['CONSULTA']);

                //echo $post['CONSULTA'];


                $rs1 = $this->db->loadall($post['CONSULTA']);

                $results = array();
                foreach ($rs1 as $key => $rows) {
                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];

                }

                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results), JSON_NUMERIC_CHECK);
                //gravarLog("Tabela: $table - " . $json . " - " . " -  Empresa: " . $this->empresa_id . "; \n");
                return $json;
                break;

            /**
             *
             *
             * Inicia eventos Mobile apk tecnicos
             * 
             *
             */

            case -1: // Listar chamados para o apk tecnicos

                $post['CONSULTA'] = str_replace('SELECT','',$post['CONSULTA']);
                $post['CONSULTA'] = str_replace('DROP','',$post['CONSULTA']);
                $post['CONSULTA'] = str_replace('DELETE','',$post['CONSULTA']);
                $post['CONSULTA'] = str_replace('INSERT','',$post['CONSULTA']);
                $post['CONSULTA'] = str_replace('UPDATE','',$post['CONSULTA']);
                $post['CONSULTA'] = str_replace('ALTER','',$post['CONSULTA']);

                $post['IMEI'] = str_replace('SELECT','',$post['IMEI']);
                $post['IMEI'] = str_replace('DROP','',$post['IMEI']);
                $post['IMEI'] = str_replace('DELETE','',$post['IMEI']);
                $post['IMEI'] = str_replace('INSERT','',$post['IMEI']);
                $post['IMEI'] = str_replace('UPDATE','',$post['IMEI']);
                $post['IMEI'] = str_replace('ALTER','',$post['IMEI']);

                if (isset($post['IMEI'])) {
                    $tecnico = "select NMSUPORTE from tecnicos where IMEI='{$post['IMEI']}'";
                    $obj = $this->db->load($tecnico);
                    $nmtecnico = $obj->NMSUPORTE;
                }



                $sql = "select c.*,e.MODELO,e.FABRICANTE,e.SERIE,e.PATRIMONIO,d.NMDEFEITO,t.NMOSTP from chamados c 
                          INNER JOIN equipamentos e on e.cdequipamento = c.cdequipamento
                          INNER JOIN defeitos d on d.cddefeito = c.cddefeito
                          INNER JOIN  chamado_tipos t on t.cdostp = c.cdostp
                          WHERE 1=1 ";
                $sql .= " AND c.empresa_id = $this->empresa_id";
                $sql .= " AND c.ID_BASE = $this->id_base";
                $sql .= " AND c.NMSUPORTET = '$nmtecnico'";
                $sql .= " AND {$post['CONSULTA']}";


                $rs1 = $this->db->loadall($sql);

                $results = array();
                foreach ($rs1 as $key => $rows) {
                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];

                }

                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results), JSON_NUMERIC_CHECK);

                return $json;
                break;

            case -2: // alterar registro do app na web com origem do apk tecnico
                
                $dados = array();

                foreach ($post as $key => $value) {
                    $dados["$key"] = str_replace("'", " ", str_replace("{QUEBRALINHA}", " /n ", $value));
                }

                unset($dados['LST']);
                unset($dados['EVT']);
                unset($dados['CH']);
                unset($dados['CNPJSYNC']);

                $dados['ATUALIZADO_WEB'] = date('Y-m-d H:i:s');
                $dados['ATUALIZADO'] = 2;

                $condition = 'id= ' . $dados['id'] . ' AND  empresa_id= ' . $this->empresa_id;
                $condition .= ' AND ID_BASE= ' . $this->id_base;


                $save = $this->db->save($table, $dados, $condition);

                if ($save > 0) {
                    $colunas = array('id', 'SEQOS');
                    $return = $this->db->get_one($table, $condition, $colunas);

                    $json = json_encode(array(
                            'MSG' => 'Sucesso',
                            'SEQOS' => $return['SEQOS'],
                            'id' => $return['id']
                        )
                    );

                    //gravarLog("MOB - update - Tabela: $table - " . $json . " - " . "SEQOS: " . $dados['SEQOS'] . " -  Empresa: " . $this->empresa_id . "; \n", $table);

                    return $json;

                } else {

                    $json = json_encode(array(
                        'MSG' => 'Erro',
                        'SEQOS' => $dados['SEQOS'],
                        'id' => -1,
                        'SQL' => $this->db->sql,
                    ));

                   // gravarLog("Tabela: $table - " . json_encode($dados) . "  -  Empresa: " . $this->empresa_id . "; \n", $table);

                    return $json;
                }

                break;


            default:
                $json = json_encode(array('MSG' => 'Erro Desconhecido!'));
                return $json;
                break;

        }
    }


}