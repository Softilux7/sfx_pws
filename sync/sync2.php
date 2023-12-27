<?php
//error_reporting(E_ALL);
include_once "src/lst.php";
include_once('src/config/config.php');

header('Content-type: application/json');

$lst = $_GET['LST']; // Tabela
$evt = $_GET['EVT']; // evento
$cnpj = $_GET['CNPJSYNC']; //cnpj da empresa
$ch = $_GET['CH']; // chave
$post = $_GET;
$config = $config['Database'];

// arquivo de teste

switch ($lst) {
    case '0': // Tabela de O.S - chamados
        $list = new syncKey($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt);
        echo $sync;
        break;
    case '1': // Tabela de O.S - chamados
        $list = new chamados($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '2': //Tabela de clientes
        $list = new clientes($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '3': //Tabela de equipamentos
        $list = new equipamentos($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '4': //Tabela de medidores
        $list = new equipamentosMed($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '5': //Tabela de equipamento medidores
        $list = new equipamentosMedG($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '6':
        $list = new contratos($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '7':
        $list = new contratosIt($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '8':
        $sync = json_encode(array('MSG' => 'Não implementado!'));
        echo $sync;
        break;
    case '9':
        $list = new contratosGrp($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '10': //Tabela de medidores
        $list = new medidores($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '11':
        $list = new produtos($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '12':
        $list = new atendimentos($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '13':
        $list = new defeitos($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '14':
        $list = new status($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '15':
        $list = new tecnicos($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '16':
        $list = new tecnicosTerritorio($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '17':
        $list = new chamadoTipo($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '18':
        $list = new checklistPerguntas($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '19':
        $list = new checklists($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '20':
        $list = new fichaTecIt($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '21':
        $list = new nfsaidaEntregas($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '22':
        $list = new entregadores($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '23':
        $list = new oportunidades($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    case '24':
        $list = new nfes($config);
        $list->empresa($ch, $cnpj);
        $sync = $list->index($lst, $evt, $post);
        echo $sync;
        break;
    default:
        $sync = json_encode(array('MSG' => 'Não implementado!'));
        echo $sync;
        break;

}


?>