<?php
date_default_timezone_set('America/Sao_Paulo');
$config = array();
$config['Database'] = array();
$config['Database']['dbtype'] = 'mysql';
$config['Database']['dbname'] = 'pws';
$config['Database']['host'] = '10.180.0.8';
$config['Database']['port'] = 3306;
$config['Database']['username'] = 'softilux';
$config['Database']['password'] = 'YceHw7WC5usvP1#mLtST';
$config['Database']['charset'] = 'utf8';

function table($index){

    switch ($index) {
        case '0': // Tabela de empresas
            return 'empresas';
            break;
        case '1': // Tabela de O.S
            return 'chamados';
            break;
        case '2': // Tabela de clientes
            return 'clientes';
            break;
        case '3': // Tabela de equipamentos
            return 'equipamentos';
            break;
        case '4': // Tabela de equipamento_medidores
            return 'equipamento_medidores';
        case '5': // Tabela de equipamento_medidores_it_g
            return 'equipamento_medidores_it_g';
            break;
        case '6': // Tabela de contratos
            return 'contratos';
            break;
        case '7': // Tabela de contratos itens
            return 'contrato_itens';
            break;
        case '8': // nao implementado
            return '';
            break;
        case '9': // Tabela de grupo_contratos
            return 'grupo_contratos';
            break;
        case '10': // Tabela de contratos itens
            return 'medidores';
            break;
        case '11': // Tabela de produtos
            return 'produtos';
            break;
        case '12': // Tabela de atendimentos
            return 'atendimentos';
            break;
        case '13': // Tabela de defeitos
            return 'defeitos';
            break;
        case '14': // Tabela de status
            return 'status';
            break;
        case '15': // Tabela de tecnicos
            return 'tecnicos';
            break;
        case '16': // Tabela de tecnico_territorios
            return 'tecnico_territorios';
            break;
        case '17': // Tabela de chamado_tipos
            return 'chamado_tipos';
            break;
        case '18': // Tabela de checklist_perguntas
            return 'checklist_perguntas';
            break;
        case '19': // Tabela de checklists
            return 'checklists';
            break;
        case '20': // Tabela de ficha_tecnica_it
            return 'ficha_tecnica_it';
            break;
        case '21': // Tabela de nfsaida_entregas
            return 'nfsaida_entregas';
            break;
        case '22': // Tabela de entregadores
            return 'entregadores';
            break;
        case '23': // Tabela de oportunidades
            return 'oportunidades';
            break;
        case '24': // Tabela de nfes
            return 'nfes';
            break;
        case '25': // Tabela de app_envio_medidores
            return 'app_envio_medidores';
            break;
        case '26': // 
            return 'chamados_itens';
            break;
        case '27': // 
            return 'estoque_local';
            break;
        case '28': // 
            return 'estoque_local_tecnico';
            break;
        case '29': // 
            return 'estoque_saldo';
            break;
        case '30': // 
            return 'chamado_itens_params';
            break;
        default:
            break;
    }

}

/**
 * Grava Log em txt
 * @param $msg
 */
function gravarLog($msg, $table)
{

    $data = date("d-m-y");
    $t = explode(" ",microtime());
    $hora = date("H:i:s",$t[1]).substr((string)$t[0],1,4);
     //date("H:i:s:u");
    $ip = $_SERVER['REMOTE_ADDR'];

    //Nome do arquivo:
    //mkdir(getcwd()."/log/$table/", 0777);
// rodrigo motta
    //$arquivo = getcwd()."/log/".$data. "_" . "$table" . ".txt";

    //Texto a ser impresso no log:
    $texto = "[$hora][$ip]> $msg \n";

    // $manipular = fopen("$arquivo", "a+ b");
    // fwrite($manipular, $texto);
    // fclose($manipular);

}

?>
