<?php
//error_reporting(E_ALL);
include_once "src/lst.php";
include_once "src/config/config.php";

header('Content-type: application/json');

unset($lst,$evt,$cnpj,$ch,$post);

//$post = $_POST;
if ($_SERVER["REQUEST_METHOD"] == 'GET' ) {
    $post = $_GET;
} else {
    $post = $_POST;
}

//$post = $_GET;
$evt = $post['EVT']; // evento
$imei = $post['IMEI']; // evento
$cnpj = $post['CNPJSYNC']; //cnpj da empresa
$ch = $post['CH']; // chave
$config = $config['Database'];

//$dataLog = date("d-m-y");

//gravarLog("[$dataLog] | CNPJSYNC: [$cnpj] | LST: [$lst] | EVT: [$evt] "." \n"."_POST: [" . json_encode($post) . "] \n\n",'POST');


switch ($evt) {

    case '1': // Tabela de O.S - chamados
        $list = new mobile($config);
       // unset($list->empresa_id,$list->id_base,$list->cnpj,$list->reg);
        $list->empresa($post);
        $sync = $list->index($evt, $post);
        echo $sync;
        break;

    default:
        $sync = json_encode(array('RETORNO'=>'ERRO', 'MSG' => 'EVENTO NÃO IMPLEMENTADO'));
        header('Content-type: application/json');
        echo $sync;
        break;

}

unset($_POST);

?>