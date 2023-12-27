<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i class="fa fa-tasks fa-lg"></i> <?php echo __('Lista de Chamados'); ?></h1>
        </div>
    </div>
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li>
                    <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>
                        <?php echo $this->Html->link(__('Equipamentos Com Contrato'), array('controller' => 'ContratoItens', 'action' => 'index')); ?>
                    <?php }?>
                </li>
                <li>
                    <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>     
                        <?php echo $this->Html->link(__('Equipamentos Sem Contrato'), array('controller' => 'Equipamentos', 'action' => 'index')); ?>
                    <?php }?>
                </li>
                <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>
                    <?php if (EmpresaPermissionComponent::verifiquePermissaoModuloContrato($auth_user['User']['empresa_id'], $auth_user_group['id'])) { ?>
                        <li>
                            <?php echo $this->Html->link(__('Contratos'), array('controller' => 'Contratos', 'action' => 'index')); ?>
                        </li>
                    <?php } ?>
                <?php }?>
                <li class="active">
                    <?php echo $this->Html->link(__('Chamados'), array('controller' => 'Chamados', 'action' => 'index')); ?>
                </li>
                <li>
                    <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?> 
                        <?php echo $this->Html->link(__('Solicitações'), array('controller' => 'Solicitacao', 'action' => 'index')); ?>
                    <?php }?>
                </li>
            </ul>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo ($this->Session->flash()); ?></b>
            <br />
        </div>
    <?php } ?>
    <button type="button" class="btn btn-large btn-search" data-toggle="collapse" data-target="#search">
        <i class="icon-filter"></i> Filtrar Resultados
    </button>
    <div id="search" class="collapse">
        <div class="row-fluid show-grid">
            <div class="span10">
                <?php echo $this->Search->create('', array('class' => 'form-inline')); ?>
                <?php echo $this->Form->input('filter', array('type' => 'hidden','value'=>1)); ?>
                <fieldset>
                    <legend>Filtro</legend>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Coluna:'); ?> </label>

                            <div class="controls">
                                <?php

                                echo $this->Search->selectFields('filter1', array(
                                    'Chamado.id' => __('Nº Chamado WEB', true),
                                    'Chamado.SEQOS' => __('Nº Chamado Sistema', true),
                                    'Equipamento.SERIE' => __('Serie', true),
                                    'Equipamento.PATRIMONIO' => __('Patrimônio', true),
                                    'Chamado.SEQCONTRATO' => __('Contrato', true),
                                    'Chamado.NMSUPORTET' => __('Técnico', true),
                                    'Chamado.NMCLIENTE' => __('Razão Social', true)
                                ), array(
                                    'class' => 'select-box'
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Operador:'); ?> </label>

                            <div class="controls">
                                <?php echo $this->Search->selectOperators('filter1'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Campo:'); ?> </label>

                            <div class="controls">
                                <?php
                                echo $this->Search->input('filter1', array(
                                    'placeholder' => "Localizar Chamado"
                                ));
                                ?>
                                <button class="btn" type="submit">
                                    <?php echo __('Filtrar'); ?>
                                </button>
                                <button class="btn" type="button" onclick="cancelSearch();">
                                    <i class="icon-remove-sign"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <?php echo $this->Search->end(); ?>

                    <?php echo $this->Session->flash(); ?>
                </fieldset>
            </div>
        </div>
    </div>
    <?php echo $this->Form->create('Chamado', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
    <?php echo $this->Form->end(); ?>
    <div class="row-fluid show-grid">
        <div class="span12">
            <div class="pagination pagination-small">
                <ul>
                    <?php
                    echo $this->Paginator->prev('<< ' . __(''), array(
                        'tag' => 'li',
                        'escape' => false
                    ));
                    echo $this->Paginator->numbers(array(
                        'separator' => '',
                        'tag' => 'li'
                    ));
                    echo $this->Paginator->next(__('') . ' >>', array(
                        'tag' => 'li',
                        'escape' => false
                    ));
                    ?>
                </ul>
            </div>
            <div class="row-fluid show-grid">
                <div class="span12">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Status do Chamado') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->Html->link(__('Aberturas'), array('controller' => 'Chamados', 'action' => 'index', 'A')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Despachados'), array('controller' => 'Chamados', 'action' => 'index', 'E')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Pendentes'), array('controller' => 'Chamados', 'action' => 'index', 'P')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Em Manutenção'), array('controller' => 'Chamados', 'action' => 'index', 'M')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Cancelados'), array('controller' => 'Chamados', 'action' => 'index', 'C')); ?>
                            </li>
                            <!-- AJUSTES EMPRESA DATA VOICE - CLIENTES NÃO PODE VER CHAMADOS CONCLUÍDOS   -->
                            <?php if($auth_user_group['id'] == 3 and $auth_user['User']['empresa_id'] == 15){ }else{ ?>
                                <li>
                                    <?php echo $this->Html->link(__('Concluídos'), array('controller' => 'Chamados', 'action' => 'index', 'O')); ?>
                                </li>
                            <?php } ?>
                            <?php if($auth_user_group['id'] != 3){ ?>
                            <li>
                                <?php echo $this->Html->link(__('Retornos'), array('controller' => 'Chamados', 'action' => 'index', 'R')); ?>
                            </li>
                            <?php } ?>
                            <li>
                                <?php echo $this->Html->link(__('Em Aberto'), array('controller' => 'Chamados', 'action' => 'index')); ?>
                            </li>
                            <?php if($checkStatusAtendido == true){?>
                                <li>
                                    <?php echo $this->Html->link(__('Atendido'), array('controller' => 'Chamados', 'action' => 'index', 'T')); ?>
                                </li>
                            <?php }?>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn  btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Ordenar por:') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Paginator->sort('id', 'Nº Chamado WEB'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('SEQOS', 'Nº Chamado Sistema'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('SEQCONTRATO', 'Contrato'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('Equipamento.SERIE', 'Serie'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('CIDADE', 'Cidade'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('DEPARTAMENTO', 'Departamento'); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php
            $attr = 0;
            foreach ($Chamados as $Chamado) :
            ?>
                <?php

                // -- CALCULO PREVISÃO DE FECHAMENTO DA O.S --

                $tpatendimento = $Chamado['Equipamento']['TEMPOFECHAMENTO'];
                $tfdiasuteis = $Chamado['Equipamento']['TFDIASUTEIS'];
                $tfhorasuteis = $Chamado['Equipamento']['TFHORASUTEIS'];

                if ($tfhorasuteis != 'S') {
                    HorasDiasUteisComponent::$HORAFIN2 = '24:00';
                    HorasDiasUteisComponent::$HORAFIN1 = '12:00';
                    HorasDiasUteisComponent::$HORAINI1 = '00:00';
                    HorasDiasUteisComponent::$HORAINI2 = '12:00';
                } else {
                    HorasDiasUteisComponent::$HORAFIN2 = $Chamado['Equipamento']['HORAFIN2'];
                    HorasDiasUteisComponent::$HORAFIN1 = $Chamado['Equipamento']['HORAFIN1'];
                    HorasDiasUteisComponent::$HORAINI1 = $Chamado['Equipamento']['HORAINI1'];
                    HorasDiasUteisComponent::$HORAINI2 = $Chamado['Equipamento']['HORAINI2'];
                }


                if ($tfdiasuteis == 'S' or $tfhorasuteis == 'S') {

                    $srt = strlen($tpatendimento);
                    if ($srt == '1') {
                        $prazo = '0' . $tpatendimento . ":00";
                    } else {
                        $prazo = $tpatendimento . ":00";
                    }

                    $dataAtual = date('Y-m-d H:i', strtotime($Chamado['Chamado']['DTINCLUSAO'] . $Chamado['Chamado']['HRINCLUSAO']));
                    $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal($dataAtual, $prazo);

                    // $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal ( '02/04/2015 15:00', $prazo );

                    $dataPrevista = date('Y-m-d', $dtPrevisao);
                    $horaPrevista = date('H:i', $dtPrevisao);

                    $diaSemana = date('w', $dtPrevisao);
                    $a1 = '';
                    if ($diaSemana == 0 || $diaSemana == 6) {
                        // se SABADO OU DOMINGO, SOMA 01
                        $a1 = '0';
                    } else {
                        for ($i = 0; $i <= 12; $i++) {
                            if ($dataPrevista == HorasDiasUteisComponent::Feriados(date('Y'), $i)) {
                                $a1 = '1';
                            }
                        }
                    }
                    switch ($a1) {
                        case '0':
                            $diaSemana = date('w', $dtPrevisao);
                            if ($diaSemana == 6) {
                                $dtPrevisao = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                                $dataPrevista = HorasDiasUteisComponent::Soma1dia($dtPrevisao);
                            } else {
                                $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                            }
                            break;
                        case '1':
                            $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);

                            $diaSemanaF = date('w', strtotime($dataPrevista));
                            if ($diaSemanaF == 6) {
                                $dtPrevisao = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                                $dataPrevista = HorasDiasUteisComponent::Soma1dia($dtPrevisao);
                            } else {
                                $dataPrevista = HorasDiasUteisComponent::Soma1dia($dataPrevista);
                            }
                            break;
                        default:
                            $dataPrevista;
                            break;
                    }

                    //$this->request->data('Chamado.DTPREVENTREGA', $dataPrevista);
                    //$this->request->data('Chamado.HRPREVENTREGA', $horaPrevista);
                } else {
                    $srt = strlen($tpatendimento);
                    if ($srt == '1') {
                        $prazo = '0' . $tpatendimento . ":00";
                    } else {
                        $prazo = $tpatendimento . ":00";
                    }

                    $dataAtual = date('Y-m-d H:i', strtotime($Chamado['Chamado']['DTINCLUSAO'] . $Chamado['Chamado']['HRINCLUSAO']));
                    $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal($dataAtual, $prazo);

                    // $dtPrevisao = HorasDiasUteisComponent::calculaPrazoFinal ( '02/04/2015 15:00', $prazo );

                    $dataPrevista = date('Y-m-d', $dtPrevisao);
                    $horaPrevista = date('H:i', $dtPrevisao);
                }

                // -- FIM DA ROTINA DE FECHAMENTO

                if (empty($Chamado['Chamado']['TEMPOSOLUCAO'])) {
                    $Chamado['Chamado']['TEMPOSOLUCAO'] = '0:00';
                }
                $tempoR = explode(':', $Chamado['Chamado']['TEMPOSOLUCAO']);
                //$tempoAt = explode(':',$chamado['Chamado']['TEMPOATENDIMENTO']);

                $tempoR = mktime($tempoR[0], $tempoR[1], 00, 0, 0, 0);
                $tempoAt = mktime($Chamado['Equipamento']['TEMPOFECHAMENTO'], 00, 00, 0, 0, 0);

                ?>
                <div class="row-fluid show-grid" style="margin-top: 10px;">
                    <div class="span12 well">
                        <div class="span2">
                            <div><strong>Chamado Nº:</strong>&nbsp;<?php echo h($Chamado['Chamado']['id']); ?>
                                / <?php echo h($Chamado['Chamado']['SEQOS']); ?></div>
                            <div><strong>Série:</strong>&nbsp;<?php echo h($Chamado['Equipamento']['SERIE']); ?></div>
                            <div><strong>Contrato:</strong>&nbsp;<?php echo h($Chamado['Chamado']['SEQCONTRATO']); ?>
                            </div>
                            <div><strong>Tipo Defeito:</strong>&nbsp;<?php echo h($Chamado['Defeito']['NMDEFEITO']); ?>
                            </div>
                        </div>

                        <div class="span3">
                            <div>
                                <strong>Patrimônio:</strong>&nbsp;<?php echo h($Chamado['Equipamento']['PATRIMONIO']); ?>
                            </div>
                            <div>
                                <strong>Técnico:</strong>&nbsp;<?php echo h($Chamado['Chamado']['NMSUPORTET']); ?>
                            </div>
                            <div>
                                <strong>Departamento: </strong><?php echo h($Chamado['Equipamento']['DEPARTAMENTO']); ?>
                            </div>
                            <div>
                                <strong>Local de Instalação: </strong><?php echo h($Chamado['Equipamento']['LOCALINSTAL']); ?>
                            </div>
                        </div>

                        <div class="span3">
                            <div>
                                <strong>Cliente: </strong>&nbsp;<?php echo h($Chamado['Chamado']['CDCLIENTE']) . ' | ' . h($Chamado['Chamado']['NMCLIENTE']); ?>
                            </div>
                            <div>
                                <strong>Cidade: </strong>&nbsp;<?php echo h($Chamado['Chamado']['CIDADE']); ?>&nbsp;
                            </div>
                            <div>
                                <strong>Data de Abertura: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($Chamado['Chamado']['DTINCLUSAO'])) . ' ' . date('H:i', strtotime($Chamado['Chamado']['HRINCLUSAO'])); ?>
                            </div>
                            <div>
                                <strong>Severidade: </strong>&nbsp;<?php echo $STATUS_SEVERIDADE[$Chamado['Defeito']['CD_SEVERIDADE']]; ?>
                            </div>
                        </div>

                        <div class="span3">
                            <div>
                                <strong>Status: </strong>&nbsp;
                                <?php

                                // status L,S e R serão visualizados como P=pendente para perfil cliente
                                $statusPendente = array('S', 'L', 'R', 'P');
                                
                                // perfil cliente
                                if($auth_user_group['id'] == 3){
                                    // se identificar status S,L,R seta para P
                                    $Chamado['Chamado']['STATUS'] = in_array($Chamado['Chamado']['STATUS'], $statusPendente) ? 'P' : $Chamado['Chamado']['STATUS'];
                                }

                                switch ($Chamado['Chamado']['STATUS']) {
                                    case 'A':
                                        echo "<span class='label label-info-bootstrap4'style='font-size: 14px'>Abertura</span>";
                                        break;
                                    case 'E':
                                        echo "<span class='label label-primary-bootstrap4' style='font-size: 14px;'>Despachado</span>";
                                        break;
                                    case 'P':
                                        echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                        break;
                                    case 'S':
                                        echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                        break;
                                    case 'L':
                                        echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                        break;

                                    case 'R':
                                        echo "<span class='label label-default' style='font-size: 14px'>Retorno</span>";
                                        break;


                                    case 'M':
                                        echo "<span class='label label-warning'style='font-size: 14px'>Em Manutenção</span>";
                                        break;
                                    case 'C':
                                        echo "<span class='label label-important'style='font-size: 14px'>Cancelado</span>";
                                        break;
                                    case 'O':
                                        echo "<span class='label label-success'style='font-size: 14px'>Concluído</span>";
                                        break;
                                    case 'T':
                                        echo "<span class='label label-default'style='font-size: 14px'>Atendido</span>";
                                        break;
                                }
                                ?>&nbsp;
                            </div>
                            <?php if ($Chamado['Chamado']['STATUS'] != 'O') { ?>
                                <div><strong>Data
                                        Prevista
                                        Atendimento: </strong>
                                        <?php echo TempoComponent::calcularSLA($Chamado, isset($preAtendimento[$Chamado['Chamado']['id']]) ? $preAtendimento[$Chamado['Chamado']['id']] : null); ?>
                                </div>
                            <?php } else { ?>
                                <div><strong>Data
                                        Conclusão: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($Chamado['Chamado']['DTATENDIMENTO'])) . ' ' . date('H:i', strtotime($Chamado['Chamado']['HRATENDIMENTO'])); ?>
                                </div>
                            <?php } ?>
                            <?php if ($Chamado['Chamado']['DTATENDIMENTO1'] != '0000-00-00 00:00:00' && $Chamado['Chamado']['DTATENDIMENTO1'] != '') { ?>
                                <div><strong>Data
                                        Atendimento: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($Chamado['Chamado']['DTATENDIMENTO1'])) . ' ' . date('H:i', strtotime($Chamado['Chamado']['HRATENDIMENTO1'])); ?>
                                </div>
                            <?php } ?>
                            <?php if ($Chamado['Chamado']['ID_BASE'] == 4) { ?>
                                <div><strong>Data Prevista
                                        Solução</strong>&nbsp;<?php echo h(date('d/m/Y', strtotime($dataPrevista))) . ' ' . h(date('H:i', strtotime($horaPrevista))); ?>
                                </div>
                            <?php } ?>
                            
                        </div>
                        <div class="row-fluid ">
                            <div class="span12 text-right">&nbsp;

                                <?php
                                echo $this->Acl->link('<i class="fa fa-eye"></i>', array(
                                    'controller' => 'Chamados',
                                    'action' => 'view',
                                    $Chamado['Chamado']['id']
                                ), array(
                                    'class' => 'btn btn-large btn-default',
                                    'escape' => false,
                                    'title' => 'Ver Chamado'
                                ));
                                ?>
                                &nbsp;

                                <?php if($auth_user_group['id'] != 12) {?>

                                    <?php if ($Chamado['Chamado']['STATUS'] == 'O' && $Chamado['ChamadoAvaliacao']['id_fk_chamado'] == '') : ?>
                                        <?php
                                        echo $this->Acl->link('<i class="fa fa-reply"></i>', array(
                                            'controller' => 'Chamados',
                                            'action' => 'emailavaliacao',
                                            $Chamado['Chamado']['id']
                                        ), array(
                                            'class' => 'btn btn-large btn-default',
                                            'escape' => false,
                                            'title' => 'Enviar email avaliação'
                                        ));
                                        ?>
                                    <?php endif; ?>

                                    <?php if ($Chamado['Chamado']['STATUS'] == 'E' &&  $auth_user_group['id'] != 3 && $auth_user_group['id'] != 4) : ?>
                                        <button href="javascript;;" class="btn btn-large btn-success" id="btn_update_chamado_manutencao" title="Começar Manutenção" onclick="modalUpdateStatusChamado(<?php echo $Chamado['Chamado']['id']; ?>);">
                                            <i class="fa fa-check-square-o"></i>
                                        </button>&nbsp;
                                    <?php endif; ?>

                                    
                                    <?php if ($Chamado['Chamado']['STATUS'] != 'O') { ?>

                                        <?php
                                        echo $this->Acl->link('<i class="fa fa-edit"></i>', array(
                                            'controller' => 'Chamados',
                                            'action' => 'edit',
                                            $Chamado['Chamado']['id']
                                        ), array(
                                            'class' => 'btn btn-large btn-info',
                                            'escape' => false,
                                            'title' => 'Atender Chamado'
                                        ));
                                        ?>
                                        &nbsp;
                                        <?php
                                        echo $this->Acl->link('<i class="fa fa-newspaper-o"></i>', array(
                                            'controller' => 'Oportunidades',
                                            'action' => 'add',
                                            $Chamado['Chamado']['id']
                                        ), array(
                                            'class' => 'btn btn-large btn-default',
                                            'escape' => false,
                                            'title' => 'Add Oportunidade Comercial'
                                        ));
                                        ?>

                                        <?php if (($Chamado['Chamado']['STATUS'] == 'A' || $Chamado['Chamado']['STATUS'] == 'E') and $auth_user_group['id'] == 3) { ?>
                                            <button href="javascript:;;" class="btn btn-large btn-danger" id="btn_update_chamado_cancelar" title="Cancelar chamado" onclick="cancelarChamado(<?php echo $Chamado['Chamado']['id']; ?>)">
                                                <i class="fa fa-times"></i>
                                            </button>&nbsp;
                                        <?php }?>


                                    <?php } ?>
                                    <?php if($Chamado['Chamado']['STATUS'] == 'O'){ ?>
                                        <?php
                                        echo $this->Acl->link('<i class="fa fa-file-archive-o"></i>', array(
                                            'controller' => 'Chamados',
                                            'action' => 'printPdf',
                                            $Chamado['Chamado']['id'],
                                            0
                                        ), array(
                                            'class' => 'btn btn-large btn-default',
                                            'escape' => false,
                                            'title' => 'Formulário da O.S'
                                        ));
                                        ?>
                                    <?php }?>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <?php $attr++; ?>
    <?php endforeach; ?>

    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de {:count} no total, iniciando no registro {:start}, terminando em {:end}')
        ));
        ?>
    </p>

    <div class="pagination">
        <ul>
            <?php
            echo $this->Paginator->prev('<< ' . __('Anterior'), array(
                'tag' => 'li',
                'escape' => false
            ));
            echo $this->Paginator->numbers(array(
                'separator' => '',
                'tag' => 'li'
            ));
            echo $this->Paginator->next(__('Proximo') . ' >>', array(
                'tag' => 'li',
                'escape' => false
            ));
            ?>
        </ul>
    </div>
    </div>
</div>
</div>
<script type="text/javascript">
    function cancelarChamado(idChamado){
        // const baseUrl = "<?php echo $this->request->base . "/" . strtolower($this->request->data['auth_plugin']) . "/"; ?>";

        // // const idChamado = 12312;

        // if(confirm('Deseja realmente cancelar o chamado?') == true){

        //     $.ajax({
        //     url : `${baseUrl}/Chamados/cancelar`,
        //     type : "POST",
        //     async: false,
        //     data : JSON.stringify({idChamado}),
        //     contentType: 'application/json',
        //     dataType: 'json',
        //     processData : false,
        //     }).done(function(result){
        //         response = result
        //     }).fail(function(){
        //         // Here you should treat the http errors (e.g., 403, 404)
        //     }).always(function(){
        //         // alert("AJAX request finished!");
        //     });
            
        //     if(response.success == true){

        //         alert('Chamado cancelado com sucesso!');

        //         // redireciona
        //         window.location.href = baseUrl + "/Chamados/";

        //     }

        // }else{
        //     return false;
        // }
        $.sModal({
            header: '<?php echo __('Cancelar chamado'); ?>',
            animate: 'fadeDown',
            width: 450,
            content: '<div id="group_error"></div><br> <form style="margin: 0px;"><div class="control-group"><label class="control-label" for="tipo_status_chamado_cancel" style="font-weight: bold;">Tipo do Status</label><div class="controls"><select id="tipo_status_chamado_cancel" name="tipo_status_chamado_cancel" style="width:100%;"></select></div></div></form>',
            buttons: [{
                text: ' <?php echo __('Confirmar cancelamento'); ?> ',
                addClass: 'btn-primary',
                click: function(id, data) {
                    const value = $('#' + id).find('#tipo_status_chamado_cancel').val();

                    if(value != ''){
                    
                        var btnSubmit = $('#' + id).children('.modal-footer').children().first();
                        var modal = $('#' + id).children('.modal-footer').children('a');
                        modal.attr({
                            disabled: 'disabled'
                        });
                        btnSubmit.text('<?php echo __('Carregando...'); ?>');


                        $.ajax({
                            url : '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'cancelar')); ?>',
                            type : "POST",
                            async: false,
                            data : JSON.stringify({idChamado, cdStatus: $('#' + id).find('#tipo_status_chamado_cancel').val()}),
                            contentType: 'application/json',
                            dataType: 'json',
                            processData : false,
                        }).done(function(result){
                            $.sModal('close', id);
                            window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?>';
                        }).fail(function(){
                            modal.removeAttr('disabled');
                            btnSubmit.text('<?php echo __('Confirmar cancelamento'); ?>');
                            var str_error = '<div class="alert alert-error">' +
                                '<button data-dismiss="alert" class="close" type="button">×</button>' +
                                '<strong><?php echo __('Erro! '); ?></strong> ' + o.error_message +
                                '</div>'
                            $('#group_error').html(str_error);
                        }).always(function(){
                            // alert("AJAX request finished!");
                        });


                        // $.post('<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'cancelar')); ?>/' + idChamado, {
                        //     data: {
                        //         idChamado: idChamadom
                        //         cdStatus: $('#' + id).find('#tipo_status_chamado_cancel').val()
                        //     }
                        // }, function(o) {
                        //     if (o.error == 0) {
                        //         $.sModal('close', id);
                        //         window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?>';
                        //     } else {
                        //         modal.removeAttr('disabled');
                        //         btnSubmit.text('<?php echo __('Confirmar cancelamento'); ?>');
                        //         var str_error = '<div class="alert alert-error">' +
                        //             '<button data-dismiss="alert" class="close" type="button">×</button>' +
                        //             '<strong><?php echo __('Erro! '); ?></strong> ' + o.error_message +
                        //             '</div>'
                        //         $('#group_error').html(str_error);
                        //     }
                        // }, 'json');
                    }else{
                        alert('Selecione um status');
                    }
                }
            }, {
                text: ' <?php echo __('Cancel'); ?> ',
                click: function(id, data) {
                    $.sModal('close', id);
                }
            }]
        });

    }

    $('#btn_update_chamado_cancelar').live('click', function() {
        $.getJSON("<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'chamados', 'action' => 'listar_status_json_cancelamento')); ?>", {
            idBase: <?php echo $Chamado['Chamado']['ID_BASE'];?>
        }, function(cidades) {
            
            if (cidades != null)
                // popularListaDeCidades(cidades, $('#tipo_status_chamado_cancel').val());
                var options = '<option value="">Selecione um Status</option>';
                $.each(cidades, function(index, cidade) {
                    if ('0' === index)
                        options += '<option selected="selected" value="' + index + '">' + cidade + '</option>';
                    else
                        options += '<option value="' + index + '">' + cidade + '</option>';
                });
                $('#tipo_status_chamado_cancel').html(options);
        });
    });


    function cancelSearch() {
        removeUserSearchCookie();
        window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?>';
    }

    function modalUpdateStatusChamado(Chamado_id) {
        $.sModal({
            header: '<?php echo __('Atualizar chamado para Em Manutenção'); ?>',
            animate: 'fadeDown',
            width: 450,
            content: '<div id="group_error"></div><br> <form style="margin: 0px;"><div class="control-group"><label class="control-label" for="tipo_status_chamado" style="font-weight: bold;">Tipo do Status</label><div class="controls"><select id="tipo_status_chamado" name="tipo_status_chamado" style="width:100%;"></select></div></div></form>',
            buttons: [{
                text: ' <?php echo __('Atualizar'); ?> ',
                addClass: 'btn-primary',
                click: function(id, data) {
                    var btnSubmit = $('#' + id).children('.modal-footer').children().first();
                    var modal = $('#' + id).children('.modal-footer').children('a');
                    modal.attr({
                        disabled: 'disabled'
                    });
                    btnSubmit.text('<?php echo __('Carregando...'); ?>');
                    $.post('<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'updateChamadoStatus')); ?>/' + Chamado_id, {
                        data: {
                            Status: {
                                tipo_status: $('#' + id).find('#tipo_status_chamado').val()
                            }
                        }
                    }, function(o) {
                        if (o.error == 0) {
                            $.sModal('close', id);
                            window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?>';
                        } else {
                            modal.removeAttr('disabled');
                            btnSubmit.text('<?php echo __('Atualizar'); ?>');
                            var str_error = '<div class="alert alert-error">' +
                                '<button data-dismiss="alert" class="close" type="button">×</button>' +
                                '<strong><?php echo __('Erro! '); ?></strong> ' + o.error_message +
                                '</div>'
                            $('#group_error').html(str_error);
                        }
                    }, 'json');
                }
            }, {
                text: ' <?php echo __('Cancel'); ?> ',
                click: function(id, data) {
                    $.sModal('close', id);
                }
            }]
        });
    }

    $('#btn_update_chamado_manutencao').live('click', function() {
        $.getJSON("<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'chamados', 'action' => 'listar_status_json')); ?>", {
            estadoId: 'M'
        }, function(cidades) {
            if (cidades != null)
                popularListaDeCidades(cidades, $('#tipo_status_chamado').val());
        });
    });

    function popularListaDeCidades(cidades, idCidade) {
        var options = '<option value="">Selecione um Status</option>';
        if (cidades != null) {
            $.each(cidades, function(index, cidade) {
                if ('0' === index)
                    options += '<option selected="selected" value="' + index + '">' + cidade + '</option>';
                else
                    options += '<option value="' + index + '">' + cidade + '</option>';
            });
            $('#tipo_status_chamado').html(options);
        }
    }

    function delChamado(Chamado_id, name) {
        $.sModal({
            image: '<?php echo $this->webroot; ?>img/icons/error.png',
            content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + name + '</b>?',
            animate: 'fadeDown',
            buttons: [{
                text: ' <?php echo __('Delete'); ?> ',
                addClass: 'btn-danger',
                click: function(id, data) {
                    $.post('<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'delete')); ?>/' + Chamado_id, {}, function(o) {
                        $('#container').load('<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Chamados', 'action' => 'index')); ?>', function() {
                            $.sModal('close', id);
                            $('#tab_user_manager').find('a').each(function() {
                                $(this).click(function() {
                                    removeUserSearchCookie();
                                });
                            });
                        });
                    }, 'json');
                }
            }, {
                text: ' <?php echo __('Cancel'); ?> ',
                click: function(id, data) {
                    $.sModal('close', id);
                }
            }]
        });
    }

    $(document).ready(function() {
        $('.pagination > ul > li').each(function() {
            if ($(this).children('a').length <= 0) {
                var tmp = $(this).html();
                if ($(this).hasClass('prev')) {
                    $(this).addClass('disabled');
                } else if ($(this).hasClass('next')) {
                    $(this).addClass('disabled');
                } else {
                    $(this).addClass('active');
                }
                $(this).html($('<a></a>').append(tmp));
            }
        });
    });

    function selEquip() {
        total = document.form_sel_id.sel_equip.length;
        fals = 0;
        for (i = 0; i < total; i++) {

            if (document.form_sel_id.sel_equip[i].checked == true) {
                alert(document.form_sel_id.sel_equip[i].value)
            } else {
                fals++;
            }
        }
        if (fals == total) {
            content = 'Por Favor Selecione um Chamado para a Abrir um Chamado.';
            $.sModal({
                image: '<?php echo $this->webroot; ?>img/icons/error.png',
                content: '<b>' + content + '</b>',
                animate: 'fadeDown',
                buttons: [{
                    text: ' <?php echo __('Ok'); ?> ',
                    click: function(id, data) {
                        $.sModal('close', id);
                    }
                }]
            });
            //   		$(this).click(function(){
            // 			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:0px; top:45px; display: none;">'
            // 				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
            +
            '<strong><?php echo __('Success!'); ?></strong> <?php echo __('Por Favor Selecione um Chamado na Listagem.'); ?>' + '</div>';
            // 			var alertSuccess = $(strAlertSuccess).appendTo('body');
            // 			alertSuccess.show();
            // 			setTimeout(function() {
            // 				alertSuccess.remove();
            // 			}, 10000);
            // 			$("#container  table").unmask();
            // 		});
        }
    }

    function msg(content) {
        $.sModal({
            image: '<?php echo $this->webroot; ?>img/icons/alert.png',
            content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + content + '</b>?',
            animate: 'fadeDown',
            buttons: [{
                text: ' <?php echo __('Cancel'); ?> ',
                click: function(id, data) {
                    $.sModal('close', id);
                }
            }]
        });
    }
</script>