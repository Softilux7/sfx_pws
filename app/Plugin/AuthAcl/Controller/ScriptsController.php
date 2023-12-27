<?php
App::uses('AuthAclAppController', 'AuthAcl.Controller');

/**
 * Scripts
 * 
 * @autor Gustavo Andrade
 * @since 16/11/2021
 */
class ScriptsController extends AuthAclAppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
    }

    private function checkPermission(){

        $auth_user = $this->Session->read('auth_user');
        $users = array('gsilva.floripa@gmail.com', 'luciano@softilux.com.br');

        return in_array($auth_user['User']['user_email'], $users);

    }

    public function cleanDatabase(){

        // verifica os usuários liberados
        if($this->checkPermission()){

            $this->set('amountScripts', count($this->scriptsCleanDatabase()));

        }else{
            exit();
        }
    }

    public function runCleanDatabase(){

        
        $this->layout       = false;
        $this->autoRender   = false;

        if($this->checkPermission()){

            $idbase = $_POST['idbase'];

            // busca os sql
            $listScripts = $this->scriptsCleanDatabase();

            // pega o sql correspondente a transação
            $script = $listScripts[$_POST['position']];

            // substitui o id da base
            $sql = str_replace('%%ID_BASE%%', $idbase, $script['sql']);
            $success = true;
            $error = '';

            // executa o sql
            try{

                $this->Script->query($sql);

            }catch(Exception $e){

                $error = $e->getMessage();

            }
            
            // faz o retorno
            return json_encode(array('success' => true, 'sql' => $sql, 'success' => $success, 'error' => $error));

        }

    }

    private function scriptsCleanDatabase(){

        return array(
            array('sql' => 'DELETE FROM app_atendimento_photos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'app_atendimento_photos'),
            array('sql' => 'DELETE FROM app_atendimento_timeline WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'app_atendimento_timeline'),
            array('sql' => 'DELETE FROM app_envio_medidores WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'app_envio_medidores'),
            array('sql' => 'DELETE FROM atendimento_backup_offline WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'atendimento_backup_offline'),
            array('sql' => 'DELETE FROM atendimentos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'atendimentos'),
            array('sql' => 'DELETE FROM chamado_tipos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'chamado_tipos'),
            array('sql' => 'DELETE FROM checklist_perguntas WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'checklist_perguntas'),
            array('sql' => 'DELETE FROM checklists WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'checklists'),
            array('sql' => 'DELETE FROM clientes WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'clientes'),
            array('sql' => 'DELETE FROM contrato_itens WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'contrato_itens'),
            array('sql' => 'DELETE FROM contratos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'contratos'),
            array('sql' => 'DELETE FROM defeitos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'defeitos'),
            array('sql' => 'DELETE FROM entregadores WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'entregadores'),
            array('sql' => 'DELETE FROM equipamento_medidores WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'equipamento_medidores'),
            array('sql' => 'DELETE FROM equipamento_medidores_it_g WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'equipamento_medidores_it_g'),
            array('sql' => 'DELETE FROM equipamentos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'equipamentos'),
            array('sql' => 'DELETE FROM estoque_local WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'estoque_local'),
            array('sql' => 'DELETE FROM estoque_local_tecnico WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'estoque_local_tecnico'),
            array('sql' => 'DELETE FROM estoque_saldo WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'estoque_saldo'),
            array('sql' => 'DELETE FROM ficha_tecnica_it WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'ficha_tecnica_it'),
            array('sql' => 'DELETE FROM grupo_contratos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'grupo_contratos'),
            array('sql' => 'DELETE FROM log_status_atendimento WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'log_status_atendimento'),
            array('sql' => 'DELETE FROM medidores WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'medidores'),
            // array('sql' => 'DELETE FROM mensagens_pre_atendimento WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'mensagens_pre_atendimento'),
            array('sql' => 'DELETE FROM nfes WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'nfes'),
            array('sql' => 'DELETE FROM nfsaida_entregas WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'nfsaida_entregas'),
            array('sql' => 'DELETE FROM oportunidades WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'oportunidades'),
            array('sql' => 'DELETE FROM produtos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'produtos'),
            array('sql' => 'DELETE FROM solicitacao_suprimentos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'solicitacao_suprimentos'),
            array('sql' => 'DELETE FROM solicitacoes WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'solicitacoes'),
            array('sql' => 'DELETE FROM status WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'status'),
            array('sql' => 'DELETE FROM tecnico_territorios WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'tecnico_territorios'),
            array('sql' => 'DELETE FROM tecnicos WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'tecnicos'),
            array('sql' => 'SELECT uc.* FROM users_clientes uc INNER JOIN users u ON (u.id = uc.user_id AND u.empresa_id = %%ID_BASE%%);', 'info' => 'users_clientes'),
            array('sql' => 'SELECT ue.* FROM users_empresas ue INNER JOIN users u ON (u.id = ue.user_id AND u.empresa_id = %%ID_BASE%%);', 'info' => 'users_empresas'),
            array('sql' => 'SELECT ug.* FROM users_groups ug INNER JOIN users u ON (u.id = ug.user_id AND u.empresa_id = %%ID_BASE%%);', 'info' => 'users_groups'),
            array('sql' => 'SELECT ut.* FROM users_tpemails ut INNER JOIN users u ON (u.id = ut.user_id AND u.empresa_id = %%ID_BASE%%);', 'info' => 'users_tpemails'),
            array('sql' => 'DELETE FROM chamados WHERE ID_BASE = %%ID_BASE%%;', 'info' => 'chamados'),
            array('sql' => 'DELETE FROM users WHERE empresa_id = %%ID_BASE%%;', 'info' => 'users'),
            array('sql' => 'DELETE FROM empresas WHERE id = %%ID_BASE%%;', 'info' => 'empresas')
        );

    }

}