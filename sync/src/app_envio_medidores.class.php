<?php
include_once "pdo/class.lpdo.php";
require_once "RestController.php";
require_once "RestResponse.php";
//include "config/config.php";
/**
 * User: Gustavo
 * Date: 28/06/2021
 */
class appEnvioMedidores extends RestController
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
                $condition = array('ATUALIZADO' => '-1', 'empresa_id' => $this->empresa_id);

                $orderBy = ' ORDER BY CDEQUIPAMANTO, cdmedidor, data_leitura, medidor ASC';

                $rs1 = $this->db->get_rows($table, $condition, false, array(), $orderBy);

                $results = array();

                foreach ($rs1 as $key => $rows) {

                    // TODO:: efeito para corrigir erro no nome dos campos
                    $rows['CDEQUIPAMENTO'] = $rows['CDEQUIPAMANTO'];
                    $rows['INFORMANTE'] = $rows['INFORMENTE'];
                    unset($rows['CDEQUIPAMANTO']);
                    unset($rows['INFORMENTE']);

                    $rows['SEQWEB'] = $rows['id'];

                    // AJUSTE para correção de um nome de campo errado
                    $results[$key] = str_replace("/n", "{QUEBRALINHA}", $rows);

                }

                // monta o retorno
                $json = json_encode(array('CNPJ' => $this->cnpj, 'CH' => $this->reg, $index => $results));
                
                return $json;

                break;

            case 4: // Retorno do sync ilux
                $condition = array('id' => $post['SEQWEB'], 'empresa_id' => $this->empresa_id);

                $dados = array(
                    'ATUALIZADO' => '1',
                    'ATUALIZADO_MSG' => $post['ERR'],
                );

                $save = $this->db->update($table, $dados, $condition);

                $error = $this->db->errorInfo();

                if ($error[2] != NULL) {
                    $json = json_encode(array('MSG' => $error[2]));
                    return $json;
                } else {
                    if ($save > 0) {
                        $json = json_encode(array('MSG' => 'Sucesso'));
                        return $json;
                    } else {
                        $json = json_encode(array('MSG' => 'Erro: Nao foi possivel alterar o registro'));
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