<?php
include_once "pdo/class.lpdo.php";
require_once "RestController.php";

class estoqueLocal extends RestController
{
    public function __construct($config)
    {
        parent::__construct($config);
    }

    public function index($index, $evt, $post)
    {
        $table = table($index); // Seleciona a tabela

        switch ($evt) {
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

                $condition = 'ID_LOC_ESTOQUE = ' . $dados['SEQILX'];

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
                    $colunas = array('id', 'ID_LOC_ESTOQUE');
                    $return = $this->db->get_one($table, $condition, $colunas);

                    $json = json_encode(array(
                            'MSG' => 'Sucesso',
                            'SEQILX' => $return['ID_LOC_ESTOQUE'],
                            'SEQWEB' => $return['id']
                        )
                    );

                    return $json;

                } else {

                    $json = json_encode(array(
                        'MSG' => 'Erro',
                        'SEQILX' => $dados['ID_LOC_ESTOQUE'],
                        'SEQWEB' => -1,
                        'SQL' => $this->db->sql,
                    ));

                    return $json;
                }

                break;

            case 3: // Excluir registro

                $condition = 'ID_LOC_ESTOQUE= ' . $post['SEQILX'];

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

                    return $json;
                } else {
                    if ($save >= 0) {
                        $json = json_encode(array('MSG' => 'Sucesso', 'SEQILX' => $post['SEQILX']));

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