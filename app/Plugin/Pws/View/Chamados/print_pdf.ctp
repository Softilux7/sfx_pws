<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http-~~-//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http-~~-//www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo($auth_user ['EmpresaSelected']['Empresa']['empresa_fantasia'] . ' | Portal Web de Serviços'); ?></title>
</head>
<style type="text/css">
    div {padding: 0px; margin:0px;}
    table {font-size:10px;font-family:Verdana, Geneva, sans-serif}
</style>
<body>
<table cellspacing="0" style="width: 100%;border:1px solid">
    <tbody>
    <tr>
    <?php
        $img = explode('emp/', $_SESSION['auth_user']['Empresa'][0]['logo']);
    ?>
        <td style="width: 20%; text-align:center">
            <img src="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>/pws/app/webroot/img/emp/<?php echo $img[1];?>" width="65" height="65"/>
        </td>
        <td style="width: 50%;font-size:9px">
            <?php  $empresa = $_SESSION['auth_user']['Empresa'][0]; ?>
            <div><h3><?php echo $empresa['empresa_nome']; ?></h3></div>
            <div><strong>CNPJ: </strong> <?php echo $empresa['cnpj']; ?> <strong>Inscrição Estadual: </strong> <?php echo $empresa['ie']; ?></div>
            <div><strong>Endereço: </strong> <?php echo $empresa['endereco']; ?></div>
            <div><strong>Cidade: </strong> <?php echo $empresa['cidade']; ?> <strong>Bairro: </strong><?php echo $empresa['bairro']; ?></div>
            <div><strong>Fone: </strong><?php echo $empresa['ddd']; ?> <?php echo $empresa['fone']; ?> <strong>CEP: </strong> <?php echo $empresa['cep']; ?></div>
        </td>
        <td style="width: 30%">
            <div><H3>ORDEM DE SERVIÇO</H3></div>
            <div>Número: <?php echo $data['Chamado']['SEQOS']; ?> / <?php echo $data['Chamado']['id']; ?> </div>
            <div>Data abertura: <?php echo date('d/m/Y', strtotime($data['Chamado']['DTINCLUSAO'])); ?> Hora: <?php echo date('H:i', strtotime($data['Chamado']['HRINCLUSAO'])); ?></div>
            <div>Atendente: WEB  Técnico: <?php echo $data['Chamado']['NMSUPORTET']; ?></div>
            <div>Atendimento Prev.:  <?php echo date('d/m/Y', strtotime($data['Chamado']['DTPREVENTREGA'])) . ' ' . date('H:i', strtotime($data['Chamado']['HRPREVENTREGA'])); ?></div>
            <div>Priorid.:  <?php echo $data['Chamado']['PRIORIDADE']; ?></div>
            <div>Tipo O.S.:</div>
            <div>
                <table cellspacing="0" style="width: 100%;">
                    <tr>
                        <td style="width: 33%;text-align:center;"> <input type="checkbox" checked = checked>Atendimento</td>
                        <td style="width: 33%;text-align:center;"> <input type="checkbox">Garantia</td>
                        <td style="width: 33%;text-align:center;"> <input type="checkbox">Orçamento</td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<?php 

        // foreach($atendimento as $key => $dataAtendimento){
        $dataAtendimento = reset($atendimento);
        $currentArray = current($dataAtendimento);

        // define o atendimento que está selecionado
        $idAtendimentoSelecionado = ($selectedAtendimento > 0) ? $selectedAtendimento : $currentArray['atendimento']['id'];

    ?>
<table cellspacing="0" style="width: 100%;border-left:1px solid;border-right:1px solid">
    <tr>
        <td style="width: 50%;text-align:center;border-right:1px solid;border-bottom: 1px solid; background: #e1e1e1;"> <strong style="font-size:12px">Cliente</strong></td>
        <td style="width: 50%;text-align:center;solid;border-bottom: 1px solid; background: #e1e1e1;"> <strong style="font-size:12px">Equipamento</strong></td>
    </tr>
    <tr>
        <td style="width: 50%;text-align:center;border-right:1px solid;text-align:left">
            <div>Cliente: <?php echo $data['Chamado']['NMCLIENTE']; ?> </div>
            <div>Endereço: <?php echo $data['Chamado']['ENDERECO']; ?> </div>
            <div>Bairro: <?php echo $data['Chamado']['BAIRRO']; ?> NUM.: <?php echo $cliente['Chamado']['NUM']; ?>  CEP: <?php echo $cliente['Chamado']['CEP']; ?></div>
            <div>Cidade: <?php echo $data['Chamado']['CIDADE']; ?> </div>
            <!-- <div>CNPJ/CPF: <?php echo $data['Chamado']['CNPJ']; ?></div> -->
            <div>Contato: <?php echo $data['Chamado']['CONTATO']; ?> Fone: <?php echo $data['Chamado']['DDD']; ?> <?php echo $data['Chamado']['FONE']; ?></div>
        </td>
        <td style="width: 50%;text-align:center;text-align:left">
            <div>Equipamento: <?php echo $data['Equipamento']['CDEQUIPAMENTO']; ?></div>
            <div>Modelo: <?php echo $data['Equipamento']['MODELO']; ?></div>
            <div>Série: <?php echo $data['Equipamento']['SERIE']; ?> Patrimônio: <?php echo $data['Equipamento']['PATRIMONIO']; ?></div>
            <!-- <div>Tipo de contrato:  Território: <?php echo $data['Equipamento']['SERIE']; ?></div> -->
            <div>Departamento: <?php echo $data['Equipamento']['DEPARTAMENTO']; ?></div>
            <div>Local instalação: <?php echo $data['Equipamento']['LOCALINSTAL']; ?></div>
        </td>
    </tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <table cellspacing="0" style="width: 100%;">
            <tr>
                <td style="width: 10%;text-align:center;border-right:1px solid; border-top:1px solid;border-left:1px solid; background: #e1e1e1;"> <strong>Data visita</strong></td>
                <td style="width: 10%;text-align:center;border-right:1px solid; border-top:1px solid;background: #e1e1e1;"> <strong>Hora Ini.</strong></td>
                <td style="width: 10%;text-align:center;border-right:1px solid; border-top:1px solid;background: #e1e1e1;"> <strong>Hora Final</strong></td>
                <td style="width: 10%;text-align:center;border-right:1px solid; border-top:1px solid; background: #e1e1e1;"> <strong>KM Ini.</strong></td>
                <td style="width: 10%;text-align:center;border-right:1px solid; border-top:1px solid; background: #e1e1e1;"> <strong>KM Final</strong></td>
                <td style="width: 10%;text-align:center;border-right:1px solid; border-top:1px solid;background: #e1e1e1;"> <strong>Placa</strong></td>
                <td style="width: 20%;text-align:center;border-right:1px solid; border-top:1px solid; background: #e1e1e1;"> <strong>Descrição visita</strong></td>
                <!-- <td style="width: 10%;text-align:center;border-right:1px solid; border-top:1px solid; background: #e1e1e1;"> <strong>Assinatura</strong></td> -->
            </tr>
        </table>
    </tr>
    
    <tr>
        <table cellspacing="0" style="width: 100%;">
            <tr>
                <td style="width: 10%;border-top:1px solid;border-right: 1px solid;border-left:1px solid"><div><?php echo date('d/m/Y', strtotime($atendimento[$idAtendimentoSelecionado]['atendimento']['DTATENDIMENTO']));?></div></td>
                <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo substr($atendimento[$idAtendimentoSelecionado]['atendimento']['HRATENDIMENTO'], 0, 5);?></div></td>
                <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo substr($atendimento[$idAtendimentoSelecionado]['atendimento']['HRATENDIMENTOFIN'], 0, 5);?></div></td>
                <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo $atendimento[$idAtendimentoSelecionado]['atendimento']['KMINICIAL'];?></div></td>
                <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo $atendimento[$idAtendimentoSelecionado]['atendimento']['KMFINAL'];?></div></td>
                <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo $atendimento[$idAtendimentoSelecionado]['atendimento']['PLACAVEICULO'];?></div></td>
                <td style="width: 20%;border-top:1px solid;border-right: 1px solid"><div><?php echo $atendimento[$idAtendimentoSelecionado]['atendimento']['ACAO'];?></div></td>
            </tr>
                <!-- <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div></div></td> -->
        </table>
    </tr>
    <?php
        // }
    ?>

</table>
<?php
if(count($atendimento) > 1){
?>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; background: #e1e1e1;"> <strong style="font-size:12px">Histórico</strong></td>
    </tr>
    <tr>
        <table cellspacing="0" style="width: 100%;">
            <?php 
                foreach($atendimento as $key => $dataAtendimento){
                    if($dataAtendimento['atendimento']['id'] != $idAtendimentoSelecionado){
            ?>
                <tr>
                    <td style="width: 10%;border-top:1px solid;border-right: 1px solid;border-left:1px solid"><div><?php echo $dataAtendimento['atendimento']['DTATENDIMENTO'];?></div></td>
                    <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo substr($dataAtendimento['atendimento']['HRATENDIMENTO'], 0, 5);?></div></td>
                    <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo substr($dataAtendimento['atendimento']['HRATENDIMENTOFIN'], 0, 5);?></div></td>
                    <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo $dataAtendimento['atendimento']['KMINICIAL'];?></div></td>
                    <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo $dataAtendimento['atendimento']['KMFINAL'];?></div></td>
                    <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div><?php echo $dataAtendimento['atendimento']['PLACAVEICULO'];?></div></td>
                    <td style="width: 20%;border-top:1px solid;border-right: 1px solid"><div><?php echo $dataAtendimento['atendimento']['ACAO'];?></div></td>
                    <!-- <td style="width: 10%;border-top:1px solid;border-right: 1px solid"><div></div></td> -->
                </tr>
            <?php
                    }
                }
            ?>
        </table>
    </tr>
</table>
<?php
}
?>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; background: #e1e1e1; border-top:1px solid; "> <strong style="font-size:12px">Peças trocadas</strong></td>
    </tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 12%;text-align:center;border-right:1px solid; border-top:1px solid;border-left:1px solid; background: #e1e1e1;"> <strong>Produto/Serviço</strong></td>
        <td style="width: 28%;text-align:center;border-right:1px solid; border-top:1px solid;background: #e1e1e1;"> <strong>Descrição Produto / Serviço</strong></td>
        <td style="width: 12%;text-align:center;border-right:1px solid; border-top:1px solid;background: #e1e1e1;"> <strong>Status</strong></td>
        <td style="width: 12%;text-align:center;border-right:1px solid; border-top:1px solid; background: #e1e1e1;"> <strong>Quantidade</strong></td>
        <td style="width: 12%;text-align:center;border-right:1px solid; border-top:1px solid;background: #e1e1e1;"> <strong>Preço Unitário</strong></td>
        <td style="width: 12%;text-align:center;border-right:1px solid; border-top:1px solid; background: #e1e1e1;"> <strong>Valor total (R$)</strong></td>
    </tr>
    <tr>
        <td style="width: 10%;border-top:1px solid;border-right: 1px solid;border-left:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 28%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
    </tr>
    <tr>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid;border-left:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 28%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
    </tr>
    <tr>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid;border-left:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 28%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid"><div style="color:#fff">.</div></td>
    </tr>
    <tr>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid;border-left:1px solid;border-bottom:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 28%;border-top:1px solid;border-right: 1px solid;border-bottom:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid;border-bottom:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid;border-bottom:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid;border-bottom:1px solid"><div style="color:#fff">.</div></td>
        <td style="width: 12%;border-top:1px solid;border-right: 1px solid;border-bottom:1px solid"><div style="color:#fff">.</div></td>
    </tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ;background:#e1e1e1">
            <strong style="font-size:12px">Status O.S.</strong>
        </td>
    </tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ">
            <div>
            <table cellspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 33%;text-align:center;"> <input type="checkbox" <?php if($data['Chamado']['STATUS'] == 'A'){?> checked =checked <?php } ?>>Aberto</td>
                    <td style="width: 33%;text-align:center;"> <input type="checkbox" <?php if($data['Chamado']['STATUS'] == 'P'){?> checked =checked <?php } ?>>Pendente</td>
                    <td style="width: 33%;text-align:center;"> <input type="checkbox" <?php if($data['Chamado']['STATUS'] == 'M'){?> checked =checked <?php } ?>>Em manutenção</td>
                    <td style="width: 33%;text-align:center;"> <input type="checkbox" <?php if($data['Chamado']['STATUS'] == 'C'){?> checked =checked <?php } ?>>Cancelado</td>
                    <td style="width: 33%;text-align:center;"> <input type="checkbox" <?php if($data['Chamado']['STATUS'] == 'O'){?> checked =checked <?php } ?>>Concluído</td>
                </tr>
            </table>
            </div>
            <div style="text-align:left">Tipo de defeito: <?php echo $data['Defeito']['NMDEFEITO']?></div>
            <div style="height:20px;text-align:left">Observação: <?php echo $data['Chamado']['OBSDEFEITOATS']?> </div>
            <div></div>
        </td>
    </tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ;background:#e1e1e1">
            <strong style="font-size:12px">Medidores</strong>
        </td>
    </tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr style="font-size:9px">
        <td style="width: 10%;text-align:center;border-right:1px solid;border-left:1px solid">
            <div>Medidores:</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div>Medidor (A)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div>Valor medidor (A)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div>Desc. (A)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid;border-bottom:1px solid; ">
            <div>Medidor (B)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div>Valor Medidor (B)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div>Desc. (B)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div>Medidor (C)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid;border-bottom:1px solid; ">
            <div>Valor Medidor (C)</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid;border-bottom:1px solid; ">
            <div>Desc. (C)</div>
        </td>
    </tr>
    <tr style="font-size:9px">
        <td style="width: 10%;text-align:center;border-right:1px solid;border-left:1px solid">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid;border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid; border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid;border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
        <td style="width: 10%;text-align:center;border-right:1px solid;border-bottom:1px solid; ">
            <div style="color:#fff">.</div>
        </td>
    </tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ;background:#e1e1e1">
        <strong style="font-size:12px">Defeito relatado pelo cliente</strong>
        </td>
    </tr>
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ">
        <div style="height:50px"><?php echo $data['Chamado']['OBSDEFEITOCLI']; ?></div>
        </td>
    <tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ;background:#e1e1e1">
        <strong style="font-size:12px">Follow-up do Técnico</strong>
        </td>
    </tr>
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ">
            <div style="height:50px"><?php echo $data['Chamado']['OBSDEFEITOATS']; ?></div>
        </td>
    <tr>
</table>
<table cellspacing="0" style="width: 100%;">
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ;background:#e1e1e1">
            <strong style="font-size:12px">Fotos</strong>
        </td>
    </tr>
    <tr>
        <td style="width: 100%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ">
            <div style="height:100px">
                <?php 
                
                    // monta a lista de fotos 
                    foreach($atendimento as $keyPhotos => $atendimentoPhotos){
                        // pega todas as fotos do tipo 1
                        $dataPhotos = $atendimentoPhotos['photos'][1];

                        foreach($dataPhotos as $keyType => $photosType){
                            // monta o caminhoi das imagens
                            $path = '/var/www/html/files' . $photosType['path'].$photosType['filename'];

                            echo "<img src='{$path}' height='100' width='100' style='margin:2px'/>";
                        }
                    }
                ?>
            </div>
        </td>
    <tr>
</table>
<table cellspacing="0" style="width: 100%">
    <tr>
        <td style="width: 70%;text-align:center;border-left:1px solid; border-bottom:1px solid; ;background:#e1e1e1">
            <strong style="font-size:12px">Aceite da O.S.</strong>
        </td>
        <td style="width: 30%;text-align:center;border-bottom:1px solid; ;background:#e1e1e1;border-right:1px solid"> </td>
    </tr>
    <tr>
        <td style="width: 70%;text-align:center;border-right:1px solid;border-left:1px solid; border-bottom:1px solid; ">
            <div style="padding-top:30px;padding-bottom:30px">
                 <!-- Favor efetuar o Aceite de Implantação e Liberação do(s) serviço(s) acima relacionado(s)</div> -->
                 <!-- <div style="height:40px">Local, ________________________________ Data  ____/____/______</div> -->
                 <?php 
                    $data = $atendimento[$idAtendimentoSelecionado];
                    $data = $data['atendimento'];
                    $date = explode("-", $data['DTATENDIMENTO']);
                    $hour = explode(":", $data['HRATENDIMENTO'])
                 ?>
                 <div style="height:40px">Atendimento realizando na data  <?php echo $date[2]?>/<?php echo$date[1]?>/<?php echo $date[0]?> às <?php echo $hour[0]?>:<?php echo $hour[1]?></div>
        </td>
        <td style="width: 30%;text-align:center;border-right:1px solid;border-bottom:1px solid">
            
            <?php 
                // pega o primeiro atendimento
                $photos = $atendimento[$idAtendimentoSelecionado];
                $photos = $photos['photos'][2];
                $assinatura = $photos[0];
                $path = '/var/www/html/files' . $assinatura['path'].$assinatura['filename'];

                echo "<div style='margin:2px'><img src='{$path}' height='60' width='60'/></div>"; 
            ?>
            <div style="padding-top:5px;padding-bottom:5px">____________________________</br>
            Assinatura do cliente</div>
            <div>contato: <strong><?php echo $atendimento[$idAtendimentoSelecionado]['atendimento']['NOME_CONTATO'] ;?></strong></div>
        </td>
    <tr>
</table>
<table cellspacing="0" style="width: 100%;border-top:1px solid">
    <tr>
        <td style="width: 100%;text-align:center"><div style="color:#fff">.</div></td>
    <tr>
</table>
</body>
