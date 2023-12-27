<style>
.table-bordered th, .table-bordered td{
    border-left:none;
}
.table-bordered{
    border:none;
}
</style>


<div class="span14" style="margin:0px">
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span14">
            <ul class="nav nav-pills">
                <li class="active">
                    <?php //echo $this->Html->link(__('Voltar'), array('controller' => 'relatorios', 'action' => 'chamado_c')); ?>
                    <a href="javascript:window.history.go(-1)">Voltar</a>
                </li>
                <ul>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span14">
            <p>
            <h1 class="page-header"><i class="fa fa-file-text-o fa-lg"></i> <?php echo __('Relatório de Chamados Concluídos'); ?>
            </h1></p>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
            <br/>
        </div>
    <?php } ?>
    <div class="row-fluid show-grid">
        <div class="span14">
            <div class="table">
                <table class="table table-bordered" style="margin-top:20px">
                    <thead>
                        <tr>
                            <th style="background-color:#fff">Cliente - Razão Social</th>
                            <th style="background-color:#fff">Periodo Inicial</th>
                            <th style="background-color:#fff">Periodo Inicial</th>
                            <th style="background-color:#fff">Total de Chamados</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $cdcliente . ' - ' . $nmcliente; ?></td>
                        <td><?php echo  $periodoini; ?></td>
                        <td><?php echo  $periodofim; ?></td>
                        <td><?php echo  $totalChamados; ?></td>
                    </tr> 
                    </tr>
                </table>
                <p class="text-right">
                    <a href="javascript:window.print()" class="btn btn-large btn-default">
                        <i class="fa fa-print" aria-hidden="true"></i>Imprimir
                    </a>
                </p>
            <div class="table">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Série</th>
                            <th>Modelo</th>
                            <th>Patrimônio</th>
                            <th>Departamento</th>
                            <th>Data Abertura</th>
                            <th>Data Fechamento</th>
                            <!-- <th>Data Solução</th>
                            <th>Tempo Solução</th>
                            <th>Técnico</th> -->
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($chamados as $chamado): ?>
                        <?php

//                        // -- CALCULO PREVISÃO DE FECHAMENTO DA O.S --
//
//                        $tpatendimento = $chamado ['Equipamento'] ['TEMPOFECHAMENTO'];
//                        $tfdiasuteis = $chamado ['Equipamento'] ['TFDIASUTEIS'];
//                        $tfhorasuteis = $chamado ['Equipamento'] ['TFHORASUTEIS'];
//
//                        if ($tfhorasuteis != 'S') {
//                            HorasDiasUteisComponent::$HORAFIN2 = '24:00';
//                            HorasDiasUteisComponent::$HORAFIN1 = '12:00';
//                            HorasDiasUteisComponent::$HORAINI1 = '00:00';
//                            HorasDiasUteisComponent::$HORAINI2 = '12:00';
//                        } else {
//                            HorasDiasUteisComponent::$HORAFIN2 = $chamado ['Equipamento'] ['HORAFIN2'];
//                            HorasDiasUteisComponent::$HORAFIN1 = $chamado ['Equipamento'] ['HORAFIN1'];
//                            HorasDiasUteisComponent::$HORAINI1 = $chamado ['Equipamento'] ['HORAINI1'];
//                            HorasDiasUteisComponent::$HORAINI2 = $chamado ['Equipamento'] ['HORAINI2'];
//                        }
//
//                        if ($tfdiasuteis == 'S' or $tfhorasuteis == 'S') {
//
//                            $srt = strlen($tpatendimento);
//                            if ($srt == '1') {
//                                $prazo = '0' . $tpatendimento . ":00";
//                            } else {
//                                $prazo = $tpatendimento . ":00";
//                            }
//
//                            $dataAtual = date('Y-m-d H:i',strtotime($chamado['Chamado']['DTINCLUSAO'].$chamado['Chamado']['HRINCLUSAO']));
//                            $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal($dataAtual, $prazo);
//
//                            // $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal ( '02/04/2015 15:00', $prazo );
//
//                            $dataPrevista = date('Y-m-d', $dtPrevisao);
//                            $horaPrevista = date('H:i', $dtPrevisao);
//
//                            $diaSemana = date('w', $dtPrevisao);
//                            $a1 = '';
//                            if ($diaSemana == 0 || $diaSemana == 6) {
//                                // se SABADO OU DOMINGO, SOMA 01
//                                $a1 = '0';
//                            } else {
//                                for ($i = 0; $i <= 12; $i++) {
//                                    if ($dataPrevista == HorasDiasUteisComponent::Feriados(date('Y'), $i)) {
//                                        $a1 = '1';
//                                    }
//                                }
//                            }
//                            switch ($a1) {
//                                case '0' :
//                                    $diaSemana = date('w', $dtPrevisao);
//                                    if ($diaSemana == 6) {
//                                        $dtPrevisao = HorasDiasUteisComponent::Soma1dia($dataPrevista);
//                                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dtPrevisao);
//                                    } else {
//                                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);
//                                    }
//                                    break;
//                                case '1' :
//                                    $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);
//
//                                    $diaSemanaF = date('w', strtotime($dataPrevista));
//                                    if ($diaSemanaF == 6) {
//                                        $dtPrevisao = HorasDiasUteisComponent::Soma1dia($dataPrevista);
//                                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dtPrevisao);
//                                    } else {
//                                        $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);
//                                    }
//                                    break;
//                                default :
//                                    $dataPrevista;
//                                    break;
//                            }
//
//                            //$this->request->data('Chamado.DTPREVENTREGA', $dataPrevista);
//                            //$this->request->data('Chamado.HRPREVENTREGA', $horaPrevista);
//                        }
//                        else {
//                                $srt = strlen($tpatendimento);
//                                if ($srt == '1') {
//                                    $prazo = '0' . $tpatendimento . ":00";
//                                } else {
//                                    $prazo = $tpatendimento . ":00";
//                                }
//
//                                $dataAtual = date('Y-m-d H:i', strtotime($Chamado['Chamado']['DTINCLUSAO'] . $Chamado['Chamado']['HRINCLUSAO']));
//                                $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal($dataAtual, $prazo);
//
//                                // $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal ( '02/04/2015 15:00', $prazo );
//
//                                $dataPrevista = date('Y-m-d', $dtPrevisao);
//                                $horaPrevista = date('H:i', $dtPrevisao);
//
//                        }
//
//
//                        // -- FIM DA ROTINA DE FECHAMENTO
//
//
////                        if (empty($chamado['Chamado']['TEMPOSOLUCAO'])) {
////                            $chamado['Chamado']['TEMPOSOLUCAO'] = '0:00';
////                        }
////                        $tempoR = explode(':', $chamado['Chamado']['TEMPOSOLUCAO']);
////                        //$tempoAt = explode(':',$chamado['Chamado']['TEMPOATENDIMENTO']);
////
////                        $tempoR = mktime($tempoR[0], $tempoR[1], 00, 0, 0, 0);
////                        $tempoAt = mktime($chamado['Equipamento']['TEMPOFECHAMENTO'], 00, 00, 0, 0, 0);
//
//                        ?>
                                <tr>
                                    <?php
                                        $chamadoAtendimento = $arrAtendimento[$chamado['Chamado']['SEQOS']];
                                        $amountAtendimento  = count($chamadoAtendimento);
                                        $lastAtedimento     = $chamadoAtendimento[$amountAtendimento - 1];
        
                                        $dtAtendimento      = $lastAtedimento['DTATENDIMENTO'];
                                        $horaIniAtendimento = $lastAtedimento['HRATENDIMENTO'];
                                        $horaFimAtendimento = $lastAtedimento['HRATENDIMENTOFIN'];

                                        if($auth_user['User']['tecnico_terceirizado'] == true || $auth_user_group['id'] == 6 || $auth_user_group['id'] == 1){
                                            // mantem os dados
                                            // todo::
                                        }else{
                                            // remove
                                            unset($arrAtendimento[$chamado['Chamado']['SEQOS']]);
                                        }
                                    ?>
                                    <td>
                                        <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'chamados', 'action' => 'view', $chamado['Chamado']['id'])); ?>"><?php echo h($chamado['Chamado']['SEQOS']); ?></a>
                                    </td>
                                    <td><?php echo $chamado['Chamado']['NMCLIENTE']; ?></td>
                                    <td><?php echo h($chamado['Equipamento']['SERIE']); ?></td>
                                    <td><?php echo h($chamado['Equipamento']['MODELO']); ?></td>
                                    <td><?php echo h($chamado['Equipamento']['PATRIMONIO']); ?></td>
                                    <td><?php echo h($chamado['Equipamento']['DEPARTAMENTO']); ?></td>
                                    <!-- <td><?php echo h(date('d/m/Y', strtotime($chamado['Chamado']['DTINCLUSAO']))) . ' ' . h(date('H:i', strtotime($chamado['Chamado']['HRINCLUSAO']))); ?></td> -->
                                    <td>
                                        <?php
                                            echo h(date('d/m/Y', strtotime($chamado['Chamado']['DTINCLUSAO']))) .' '. h(date('H:i', strtotime($chamado['Chamado']['HRINCLUSAO'])));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($dtAtendimento != '') {
                                                echo h(date('d/m/Y', strtotime($dtAtendimento))).' '. h(date('H:i', strtotime($horaFimAtendimento)));
                                            }else{
                                                echo h(date('d/m/Y', strtotime($chamado['Chamado']['DTATENDIMENTO']))) .' '. h(date('H:i', strtotime($chamado['Chamado']['HRATENDIMENTO1'])));
                                            }
                                        ?>
                                    </td>
                                    <!-- <td>
                                        <?php
                                        echo $chamado['Chamado']['TEMPOSOLUCAO'];
                                        ?>
                                    </td> -->
                                    <!-- <td>
                                        <?php
                                        echo $chamado['Chamado']['NMSUPORTET'];
                                        ?>
                                    </td> -->
                                    <td>
                                        <?php
                                        // status L,S e R serão visualizados como P=pendente para perfil cliente
                                        $statusPendente = array('S', 'L', 'R', 'P');

                                        // perfil cliente
                                        if($auth_user_group['id'] == 3){
                                            // se identificar status S,L,R seta para P
                                            $Chamado['Chamado']['STATUS'] = in_array($Chamado['Chamado']['STATUS'], $statusPendente) ? 'P' : $Chamado['Chamado']['STATUS'];
                                        }
                                        
                                        switch ($chamado['Chamado']['STATUS']) {
                                            case 'P':
                                                echo "<span class='label label-info'style='font-size: 12px'>Pendente</span>";
                                                break;
                                            case 'S':
                                                echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                break;
                                            case 'L':
                                                echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                break;
                                            
                                            case 'R':
                                                echo "<span class='label label-default'style='font-size: 14px'>Retorno</span>";
                                                break;

                                            case 'M':
                                                echo "<span class='label label-warning'style='font-size: 12px'>Em Manutenção</span>";
                                                break;
                                            case 'C':
                                                echo "<span class='label label-danger'style='font-size: 12px'>Cancelado</span>";
                                                break;
                                            case 'O':
                                                echo "<span class='label label-success'style='font-size: 12px'>Concluído</span>";
                                                break;
                                            case 'E':
                                                echo "<span class='label label-primary-bootstrap4'style='font-size: 12px'>Despachado</span>";
                                                break;
                                            case 'A':
                                                echo "<span class='label label-info-bootstrap4'style='font-size: 12px'>Abertura</span>";
                                                break;
                                            case 'T':
                                                echo "<span class='label label-default'style='font-size: 12px'>Atendido</span>";
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php if($chamado['Chamado'][STATUS] != 'C' && isset($arrAtendimento[$chamado['Chamado']['SEQOS']])){ ?>
                                <?php
                                    $valAtendimento = 0;
                                    $valKm = 0;
                                    $valEstacionamento = 0;
                                    $valPedagio = 0;
                                    $valOutrasDesp = 0;
                                    $total = 0;    
                                ?>
                                <tr>
                                    <td colspan="14" style="padding:0px; border-bottom: 5px #e1e1e1 solid;">
                                        <table class="table table-hover" style="margin-bottom:0px; border-top:0px;margin-left:50%;width:50%">
                                            <tbody>
                                                <thead>
                                                    <tr>
                                                        <!-- <th style="background:#fff; color:#999">Valor Atendimento</th>
                                                        <th style="background:#fff; color:#999">Valor Deslocamento</th>
                                                        <th style="background:#fff; color:#999">Valor Estacionamento</th>
                                                        <th style="background:#fff; color:#999">Valor Pedágio</th>
                                                        <th style="background:#fff; color:#999">Outros Valores</th>
                                                        <th style="background:#fff; color:#999">Total</th> -->
                                                        <th style="background:#fff; color:#999; border-top:0px;font-size:13px">Data</th>
                                                        <th style="background:#fff; color:#999; border-top:0px;font-size:13px">Atendimento</th>
                                                        <th style="background:#fff; color:#999; border-top:0px;font-size:13px">Deslocamento</th>
                                                        <th style="background:#fff; color:#999; border-top:0px;font-size:13px">Estacionamento</th>
                                                        <th style="background:#fff; color:#999; border-top:0px;font-size:13px">Pedágio</th>
                                                        <th style="background:#fff; color:#999; border-top:0px;font-size:13px">Outros</th>
                                                        <th style="background:#fff; color:#999; border-top:0px;font-size:13px">Total</th>
                                                    </tr>
                                                </thead>
                                                <?php foreach ($arrAtendimento[$chamado['Chamado']['SEQOS']] as $key => $data): ?>
                                                <tr>
                                                    <td style="font-size:13px"><?php echo h(date('d/m/Y', strtotime($data['DTATENDIMENTO'])))?></td>
                                                    <td style="font-size:13px"><?php echo $data['VALATENDIMENTO']?></td>
                                                    <td style="font-size:13px"><?php echo $data['VALKM']?></td>
                                                    <td style="font-size:13px"><?php echo $data['VALESTACIONAMENTO']?></td>
                                                    <td style="font-size:13px"><?php echo $data['VALPEDAGIO']?></td>
                                                    <td style="font-size:13px"><?php echo $data['VALOUTRASDESP']?></td>
                                                    <td style="font-size:13px"><strong><?php echo $data['TOTAL']?></strong></td>
                                                </tr>
                                                <?php
                                                    $valAtendimento = $valAtendimento + str_replace(',', '.', $data['VALATENDIMENTO']);
                                                    $valKm = $valKm + str_replace(',', '.', $data['VALKM']);
                                                    $valEstacionamento = $valEstacionamento + str_replace(',', '.', $data['VALESTACIONAMENTO']);
                                                    $valPedagio = $valPedagio + str_replace(',', '.', $data['VALPEDAGIO']);
                                                    $valOutrasDesp = $valOutrasDesp + str_replace(',', '.', $data['VALOUTRASDESP']);
                                                    $total = $total + str_replace(',', '.', $data['TOTAL']);    
                                                ?>
                                                <?php endforeach; ?>
                                                <?php
                                                    $amountValAtendimento += $valAtendimento;
                                                    $amountValKm += $valKm;
                                                    $amountValEstacionamento += $valEstacionamento;
                                                    $amountValPedagio += $amountValPedagio;
                                                    $amountValOutrasDesp += $valOutrasDesp;
                                                    $amountTotal += $total;
                                                ?>
                                                <tr>
                                                    <td style="font-size:13px"><strong><em>Total..........</em></strong></td>
                                                    <td style="font-size:13px"><strong><?php echo number_format($valAtendimento, 2, ',', '.')?></strong></td>
                                                    <td style="font-size:13px"><strong><?php echo number_format($valKm, 2, ',', '.')?></strong></td>
                                                    <td style="font-size:13px"><strong><?php echo number_format($valEstacionamento, 2, ',', '.')?></strong></td>
                                                    <td style="font-size:13px"><strong><?php echo number_format($valPedagio, 2, ',', '.')?></strong></td>
                                                    <td style="font-size:13px"><strong><?php echo number_format($valOutrasDesp, 2, ',', '.')?></strong></td>
                                                    <td style="font-size:13px"><strong><?php echo number_format($total, 2, ',', '.')?></strong></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            
                        <?php }?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
            if($auth_user['User']['tecnico_terceirizado'] == true || $auth_user_group['id'] == 6 || $auth_user_group['id'] == 1){
        ?>
        <table class="table table-bordered" style="margin-top:20px;margin-bottom:0px;margin-left:50%;width:50%">
            <thead>
                <tr>
                    <th>Resumo Geral</th>
                </tr>
                <tr>
                    <th style="background-color:#fff"></th>
                    <th style="background-color:#fff">Atendimento</th>
                    <th style="background-color:#fff">Deslocamento</th>
                    <th style="background-color:#fff">Estacionamento</th>
                    <th style="background-color:#fff">Pedágio</th>
                    <th style="background-color:#fff">Outros</th>
                    <th style="background-color:#fff">Total</th>
                </tr>
            </thead>
            <tbody>
            <tr>
                <td><strong><em>Total Geral....</strong></em></td>
                <td><strong><em><?php echo number_format($amountValAtendimento, 2, ',', '.')?></strong></em></td>
                <td><strong><em><?php echo number_format($amountValKm, 2, ',', '.')?></strong></em></td>
                <td><strong><em><?php echo number_format($amountValEstacionamento, 2, ',', '.')?></strong></em></td>
                <td><strong><em><?php echo number_format($amountValPedagio, 2, ',', '.')?></strong></em></td>
                <td><strong><em><?php echo number_format($amountValOutrasDesp, 2, ',', '.')?></strong></em></td>
                <td><strong><em><?php echo number_format($amountTotal, 2, ',', '.')?></strong></em></td>
            </tr> 
            </tr>
            <t/body>
        </table>
        <?php
        }
        ?>
    </div>
</div>
<script>

    const {getMostRecentBrowserWindow} = require('sdk/window/utils');

    var chromewin = getMostRecentBrowserWindow();
    chromewin.PrintUtils.printPreview(chromewin.PrintPreviewListener);

</script>