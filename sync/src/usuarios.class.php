<?php
include_once "pdo/class.lpdo.php";
//include "config/config.php";
/**
 * Created by PhpStorm.
 * User: Wagner
 * Date: 13/06/2016
 * Time: 16:38
 */
class usuarios
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

    public function if_user_exist($email, $imei)
    {

        $condition = array('user_email' => $email);

        $user = $this->db->get_one('users', $condition);

        $result = array();

        if (!empty($user)) {

            $empresa_id = $user['empresa_id'];

            $this->empresa_id = $empresa_id;

            $tecnico_id = $user['tecnico_id'];

            if ($user['user_status'] == 0) {
                $result['USUARIO'] = 'BLOQUEADO';
            }

            if ($tecnico_id == '') {
                $result['TECNICO'] = 'NAO ENCONTRADO';
            }


            // listar a empresa que o usário faz parte para saber se possui acesso apk

            $condition_emp = array('id' => $empresa_id);
            $empresa = $this->db->get_one('empresas', $condition_emp);

            $this->cnpj = $empresa['cnpj'];
            $this->reg = $empresa['ch'];
            $this->id_base = $empresa_id;

            if ($empresa['apk_tecnico'] == 0) {
                $result['ACESSO'] = 'APLICATIVO BLOQUEADO';
            }

            // verificar se possui o IMEI cadastrado no tecnico

            if ($imei=='') {
                $result['TECNICO'] = 'CELULAR NAO CADASTRADO';
            }

            if (!empty($tecnico_id) ) {

                $condition_tec = array('NMSUPORTE' => $tecnico_id, 'ID_BASE' => $empresa_id, 'IMEI' => $imei);

                $tecnico = $this->db->get_one('tecnicos', $condition_tec);


                if ($imei != $tecnico['IMEI']) {
                    $result['TECNICO'] = 'IMEI INVALIDO';
                    //$json = json_encode(array('MSG'=>$result));

                }

            }

            // retornar em json a CH e o CNPJ da empresa do usuário
            if (count($result)) {
                $json = json_encode(array('MSG' => $result));
            } else {
                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, 'USUARIO'=>'LIBERADO'));
            }

        } else {
            $result['USUARIO'] = 'NAO ENCONTRADO';
            $json = json_encode(array('MSG' => $result));

        }
        return $json;
    }

//    public function empresa($ch1, $cnpj)
//    {
//        $ch = array('ch' => $ch1, 'cnpj' => $cnpj);
//
//        $empresa = $this->db->get_one('empresas', $ch);
//
//        $this->empresa_id = $empresa['id'];
//
//        $this->cnpj = $cnpj;
//        $this->reg = $ch1;
//        $this->id_base = $empresa['matriz_id'];
//
//        return $this->empresa_id;
//    }
//
//    public function index($index, $evt, $post)
//    {
//        $table = table($index);
//        switch ($evt) {
//            case 0: // Listar registros Incluidos pendentes de sincronismo
//                $condition1 = array('ATUALIZADO' => '1', 'empresa_id' => $this->empresa_id);
//                $rs1 = $this->db->get_rows($table, $condition1);
//                $results = array();
//                foreach ($rs1 as $key => $rows) {
//                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
//                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];
//                }
//                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results), JSON_NUMERIC_CHECK);
//                return $json;
//                break;
//            case 1: // Listar registros atualizados pendentes de sincronismo
//                $condition1 = array('ATUALIZADO' => '2', 'empresa_id' => $this->empresa_id);
//                $rs1 = $this->db->get_rows($table, $condition1);
//                $results = array();
//                foreach ($rs1 as $key => $rows) {
//                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);
//                    $results[$key]['ATUALIZADO'] = $results[$key]['ATUALIZADO_ILUX'];
//                }
//                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results), JSON_NUMERIC_CHECK);
//                return $json;
//                break;
//            case 2:
//                // Registro alterado ou incluido ILUX
//                $dados = array();
//                foreach ($post as $key => $value) {
//                    $dados["$key"] = str_replace("'", " ", str_replace("{QUEBRALINHA}", " /n ", $value));
//                }
//                unset($dados['LST']);
//                unset($dados['EVT']);
//                unset($dados['CH']);
//                unset($dados['CNPJSYNC']);
//                unset($dados['id']);
//                $dados['ATUALIZADO_WEB'] = date('Y-m-d H:i:s');
//                $dados['ATUALIZADO_ILUX'] = $dados['ATUALIZADO'];
//                $dados['empresa_id'] = $this->empresa_id;
//                $dados['ID_BASE'] = $this->id_base;
//
//                $condition = 'ID_SUPORTE =' . $dados['SEQILX'] . ' AND empresa_id= ' . $this->empresa_id;
//
//                if ($dados['SEQWEB'] > 0) {
//                    $condition .= ' AND id= ' . $dados['SEQWEB'];
//                }
//
//                unset($dados['ATUALIZADO']);
//                unset($dados['SEQILX']);
//                unset($dados['SEQWEB']);
//
//                $save = $this->db->save($table, $dados, $condition);
//
//
//                if ($save > 0) {
//                    $colunas = array('id', 'ID_SUPORTE');
//                    $return = $this->db->get_one($table, $condition, $colunas);
//
//                    $json = json_encode(array(
//                            'MSG' => 'Sucesso',
//                            'SEQILX' => $return['ID_SUPORTE'],
//                            'SEQWEB' => $return['id']
//                        )
//                    );
//                    gravarLog("Tabela: $table - " . $json . " - " . "ID_SUPORTE: " . $dados['ID_SUPORTE'] . " -  Empresa: " . $this->empresa_id . "; \n", $table);
//
//                    return $json;
//
//                } else {
//
//                    $json = json_encode(array(
//                        'MSG' => 'Erro',
//                        'SEQILX' => $dados['ID_SUPORTE'],
//                        'SEQWEB' => -1
//                    ));
//
//                    gravarLog("Tabela: $table - " . json_encode($dados) . "  -  Empresa: " . $this->empresa_id . "; \n", $table);
//
//                    return $json;
//                }
//
//
//                break;
//            case 3: // Excluir registro
//
//                $condition = 'ID_SUPORTE= ' . $post['SEQILX'] . ' AND id= ' . $post['SEQWEB'];
//
//                $save = $this->db->delete($table, $condition);
//
//                $error = $this->db->errorInfo();
//
//                if ($error[2] != NULL) {
//                    $json = json_encode(array('MSG' => $error[2]));
//                    gravarLog("Tabela: $table - " . "ID_SUPORTE: " . $post['SEQILX'] . "empresa = " . $this->empresa_id . "/n" . $json . "/n", $table);
//
//                    return $json;
//                } else {
//                    if ($save >= 0) {
//                        $json = json_encode(array('MSG' => 'Sucesso'));
//                        gravarLog("Tabela: $table - " . "ID_SUPORTE: " . $post['SEQILX'] . " - " . "empresa = " . $this->empresa_id . " - " . $json, $table);
//                        return $json;
//                    }
//                }
//                break;
//
//            case 4: // Retorno do sync ilux
//                $condition1 = array('id' => $post['SEQWEB'], 'empresa_id' => $this->empresa_id);
//                if (empty($post['ERR'])) {
//                    $dados = array(
//                        'ATUALIZADO' => '0',
//                        'ERR' => '',
//                        'ID_SUPORTE' => $post['SEQILX']
//                    );
//                } else {
//                    $dados = array('ERR' => $post['ERR']);
//                }
//
//                $save = $this->db->update($table, $dados, $condition1);
//
//                $error = $this->db->errorInfo();
//
//                if ($error[2] != NULL) {
//                    $json = json_encode(array('MSG' => $error[2]));
//                    gravarLog("Tabela: $table - " . "ID_SUPORTE: " . $post['SEQILX'] . " - Empresa: " . $this->empresa_id . " - " . $json, $table);
//                    return $json;
//                } else {
//                    if ($save > 0) {
//                        $json = json_encode(array('MSG' => 'Sucesso'));
//                        gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
//                        return $json;
//                    } else {
//                        $json = json_encode(array('MSG' => 'Erro: Nao foi possivel alterar o registro'));
//                        gravarLog("Tabela: $table - " . json_encode($post) . " - Empresa: " . $this->empresa_id . " - " . $json . "/n", $table);
//                        return $json;
//                    }
//                }
//
//                break;
//            default:
//                $json = json_encode(array('MSG' => 'Erro Desconhecido!'));
//                return $json;
//                break;
//
//        }
//    }


}