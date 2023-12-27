<?php
error_reporting(0);
include_once "src/lst.php";
include_once('src/config/config.php');

header('Content-type: application/json');

unset($list,$lst,$evt,$cnpj,$ch,$post,$versao);

$lst = $_POST['LST']; // Tabelas
$evt = $_POST['EVT']; // eventos
//$email = $_POST['USER_MAIL'];  // evento
//$imei = $_POST['IMEI'];  // evento
$cnpj = $_POST['CNPJSYNC']; //cnpj da empresa
$ch = $_POST['CH']; // chave da base ilux
$post = $_POST;

$config = $config['Database'];

$versao = isset($_POST['VERSAO']) ? $_POST['VERSAO'] : 0;

$dataLog = date("d-m-y");
if ($cnpj == '02.312.399/0001-71')
    gravarLog("[$dataLog] | CNPJSYNC: [$cnpj] | LST: [$lst] | EVT: [$evt] "." \n"."_POST: [" . json_encode($post) . "] \n\n",'POST');
switch ($lst) {
    case '0': // Tabela Empresa
        $list = new syncKey($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $versao);
        echo $sync;
        break;
    case '1': // Tabela de O.S - chamados
        $list = new chamados($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '2': //Tabela clientes
        $list = new clientes($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '3': //Tabela equipamentos
        $list = new equipamentos($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '4': //Tabela medidores
        $list = new equipamentosMed($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '5': //Tabela equipamento medidores
        $list = new equipamentosMedG($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '6': //Tabela contratos
        $list = new contratos($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '7': //Tabela contrato_itens
        $list = new contratosIt($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '8':
        //$list = new usuarios($config);
        //$sync = $list->if_user_exist($email, $imei);
        //echo $sync;
        break;
    case '9': //Tabela grupo_contratos
        $list = new contratosGrp($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '10': //Tabela de medidores
        $list = new medidores($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '11':
        $list = new produtos($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '12':
        $list = new atendimentos($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '13':
        $list = new defeitos($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '14':
        $list = new status($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '15':
        $list = new tecnicos($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '16':
        $list = new tecnicosTerritorio($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '17':
        $list = new chamadoTipo($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '18':
        $list = new checklistPerguntas($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '19':
        $list = new checklists($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '20':
        $list = new fichaTecIt($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '21':
        $list = new nfsaidaEntregas($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '22':
        $list = new entregadores($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '23':
        $list = new oportunidades($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '24':
        $list = new nfes($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '25':
        $list = new appEnvioMedidores($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '26':
        $list = new chamadositens($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '27':
        $list = new estoqueLocal($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '28':
        $list = new estoqueLocalTecnico($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '29':
        $list = new estoqueSaldo($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    case '30':
        $list = new chamadosItensParams($config);
        unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;

        break;
    default:
        $sync = json_encode(array('MSG' => 'Não implementado!'));
        echo $sync;
        break;

}

unset($_POST);

?>