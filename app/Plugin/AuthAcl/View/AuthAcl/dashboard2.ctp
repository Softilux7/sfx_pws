<div class="span12">
    <div class="row-fluid">
        <div class="span12">
        <div id="contentLoading" style="position: absolute; background: #0182c2; border-radius: 5px; padding: 1px 10px; left: 50%; color: #fff;font-size:12px;display:none">atualizando...</div>
            <div class="page-header">
                <div style="display:flex;justify-content: space-between;align-items: center;">
                    <div>
                        <h1 style="margin-left:50px;color:#666"><i class="fa fa-home fa-lg"></i> Dashboard de monitoração </h1>
                        <?php if ($auth_user_group['id'] == 3) { ?>
                            <div class="text-left">
                                <i class="fa fa-info-circle fa-lg"></i> Bem vindo <strong><?php echo strtoupper($clienteSelected['Cliente']['FANTASIA']) ?></strong>
                            </div>
                        <?php } ?>
                    </div>
                    <div>
                    <div style="text-align:right;color:#666;margin-right:50px"><em>atualizado em <strong><?php echo date('d/m/Y H:i')?></strong></em></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
            <br/>
        </div>
    <?php } ?>
    
    <div class="row-fluid hidden-phone hidden-tablet hidden-sm" >
        <div class="span6" style="margin-left:0px;width:100%">
            <div class="panel panel-primary" style="border-color:#81d5ff">
                <div class="panel-heading" style="padding:1px 15px;background:#81d5ff;border-color:#81d5ff;text-align:center">
                    <!-- <h3 style="color:#0177b1"><i class="fa fa-check-square-o" aria-hidden="true" ></i> Últimos 
                    <select name="paginatioon" required="required" id="idPagination" style="width:60px" onchange="changeFilter(this)">
                        <option value="20" <?php echo $pagination == 20 ? 'selected' : ''; ?>>20</option>
                        <option value="30" <?php echo $pagination == 30 ? 'selected' : ''; ?>>30</option>
                        <option value="50" <?php echo $pagination == 50 ? 'selected' : ''; ?>>50</option>
                    </select> 
                    Chamados</h3> -->
                </div>
                <div style="text-align:center;background:#e1e1e1;"><strong>Filtrar por:</strong></div>
                <div style="background:#e1e1e1;padding-left:50px;padding-right:50px;text-align:center">
                    
                    <div>
                        Estado: <select name="uf" required="required" id="idUf" style="width:140px">
                        <option value="" <?php echo $uf == '' ? 'selected' : ''; ?>>Todas</option>
                        <option value="AC" <?php echo $uf == "AC" ? 'selected' : ''; ?>>Acre</option>
                        <option value="AL" <?php echo $uf == "AL" ? 'selected' : ''; ?>>Alagoas</option>
                        <option value="AP" <?php echo $uf == "AP" ? 'selected' : ''; ?>>Amapá</option>
                        <option value="AM" <?php echo $uf == "AM" ? 'selected' : ''; ?>>Amazonas</option>
                        <option value="BA" <?php echo $uf == "BA" ? 'selected' : ''; ?>>Bahia</option>
                        <option value="CE" <?php echo $uf == "CE" ? 'selected' : ''; ?>>Ceará</option>
                        <option value="DF" <?php echo $uf == "DF" ? 'selected' : ''; ?>>Distrito Federal</option>
                        <option value="ES" <?php echo $uf == "ES" ? 'selected' : ''; ?>>Espirito Santo</option>
                        <option value="GO" <?php echo $uf == "GO" ? 'selected' : ''; ?>>Goiás</option>
                        <option value="MA" <?php echo $uf == "MA" ? 'selected' : ''; ?>>Maranhão</option>
                        <option value="MS" <?php echo $uf == "MS" ? 'selected' : ''; ?>>Mato Grosso do Sul</option>
                        <option value="MT" <?php echo $uf == "MT" ? 'selected' : ''; ?>>Mato Grosso</option>
                        <option value="MG" <?php echo $uf == "MG" ? 'selected' : ''; ?>>Minas Gerais</option>
                        <option value="PA" <?php echo $uf == "PA" ? 'selected' : ''; ?>>Pará</option>
                        <option value="PB" <?php echo $uf == "PB" ? 'selected' : ''; ?>>Paraíba</option>
                        <option value="PR" <?php echo $uf == "PR" ? 'selected' : ''; ?>>Paraná</option>
                        <option value="PE" <?php echo $uf == "PE" ? 'selected' : ''; ?>>Pernambuco</option>
                        <option value="PI" <?php echo $uf == "PI" ? 'selected' : ''; ?>>Piauí</option>
                        <option value="RJ" <?php echo $uf == "RJ" ? 'selected' : ''; ?>>Rio de Janeiro</option>
                        <option value="RN" <?php echo $uf == "RN" ? 'selected' : ''; ?>>Rio Grande do Norte</option>
                        <option value="RS" <?php echo $uf == "RS" ? 'selected' : ''; ?>>Rio Grande do Sul</option>
                        <option value="RO" <?php echo $uf == "RO" ? 'selected' : ''; ?>>Rondônia</option>
                        <option value="RR" <?php echo $uf == "RR" ? 'selected' : ''; ?>>Roraima</option>
                        <option value="SC" <?php echo $uf == "SC" ? 'selected' : ''; ?>>Santa Catarina</option>
                        <option value="SP" <?php echo $uf == "SP" ? 'selected' : ''; ?>>São Paulo</option>
                        <option value="SE" <?php echo $uf == "SE" ? 'selected' : ''; ?>>Sergipe</option>
                        <option value="TO" <?php echo $uf == "TO" ? 'selected' : ''; ?>>Tocantins</option>
                        </select>
                        Total de chamados: <select name="paginatioon" required="required" id="idPagination" style="width:60px">
                            <option value="20" <?php echo $pagination == 20 ? 'selected' : ''; ?>>20</option>
                            <option value="30" <?php echo $pagination == 30 ? 'selected' : ''; ?>>30</option>
                            <option value="50" <?php echo $pagination == 50 ? 'selected' : ''; ?>>50</option>
                        </select> 
                    </div>
                </div>
                <div class="panel-body text-center" style="min-height: 200px;padding:0px">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>0.S</th>
                                <th>Técnico</th>
                                <th>Série</th>
                                <th>Modelo</th>
                                <th>Cliente</th>
                                <th>Cidade/Estado</th>
                                <th>Data Abertura</th>
                                <th>Previsão de atendimento</th>
                                <th>Primeiro atendimento</th>
                                <th>Prazo</th>
                                
                                <th>Status</th>
                                <!-- <th>Ações</th> -->
                            </tr>
                            </thead>
                            <tbody style="font-size:12px">
                            <?php foreach ($Chamados as $chamado): ?>
                                <?php if($chamado['Chamado']['STATUS'] != 'O'):?>
                                <tr>
                                    <td>
                                        <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'view', $chamado['Chamado']['id'])); ?>"><?php echo h($chamado['Chamado']['SEQOS']); ?></a>
                                    </td>
                                    <td><?php echo $chamado['Chamado']['NMSUPORTET']; ?></td>
                                    <td><?php echo h($chamado['Equipamento']['SERIE']); ?></td>
                                    <td><?php echo h($chamado['Equipamento']['MODELO']); ?></td>
                                    <td><?php echo h($chamado['Chamado']['NMCLIENTE']); ?></td>
                                    <td><?php echo $chamado['Chamado']['CIDADE']?> / <?php echo $chamado['Chamado']['UF']?></td>
                                    <td><?php echo h(date('d-m-Y', strtotime($chamado['Chamado']['DTINCLUSAO']))) . ' ' . h(date('H:i', strtotime($chamado['Chamado']['HRINCLUSAO']))); ?></td>
                                    <?php 
                                        $prevAtend = TempoComponent::calcularSLA($chamado, isset($preAtendimento[$chamado['Chamado']['id']]) ? $preAtendimento[$chamado['Chamado']['id']] : null); 
                                    ?>
                                    <td><?php echo $prevAtend; ?></td>
                                    <td>
                                    <?php
                                    
                                        $strDtAtendimento = $primeiroAtendimento[$chamado['Chamado']['id']] != null ? $primeiroAtendimento[$chamado['Chamado']['id']]['DTATENDIMENTO'] . ' ' . $primeiroAtendimento[$chamado['Chamado']['id']]['HRATENDIMENTO'] : null;
                                        
                                        if($strDtAtendimento != null){
                                            
                                            echo date('d/m/Y H:i', strtotime($strDtAtendimento)); 
                                        }

                                        // recria a data de previsão de atendimento
                                        $year = substr($prevAtend, 6, 4);
                                        $month = substr($prevAtend, 3, 2);
                                        $day = substr($prevAtend, 0, 2);
                                        $hour = substr($prevAtend, 11, 2);
                                        $sec = substr($prevAtend, 14, 2);
                                        
                                        // monta a data 
                                        $datePrevAtendimento = "{$year}/{$month}/${day} ${hour}:{$sec}:00";
                                        
                                    ?>
                                    </td>
                                    <td>
                                        <?php
                                            // converte a data de previsão
                                            $r = date('d/m/Y H:i:s', strtotime($datePrevAtendimento));

                                            if($strDtAtendimento != null){
                                                if(strtotime($strDtAtendimento) > strtotime($datePrevAtendimento)){
                                                    // _tst(strtotime($strDtAtendimento));
                                                    // _tst(strtotime($datePrevAtendimento));
                                                    echo "<span class='label label-warning'style='font-size: 12px;background:#b70c00'>Fora</span>";
                                                }else{
                                                    echo "<span class='label label-success'style='font-size: 12px'>Dentro</span>";
                                                }
                                            }else if($chamado['Chamado']['STATUS'] != 'O'){
                                                // _tst(strtotime($datePrevAtendimento));
                                                // _tst(strtotime(date('Y-m-d H:i:s')));
                                                if(strtotime($datePrevAtendimento) < strtotime(date('Y/m/d H:i:s'))){
                                                    // _tst($datePrevAtendimento);
                                                    // _tst(date('Y/m/d H:i:s'));
                                                    echo "<span class='label label-warning'style='font-size: 12px;background:#b70c00'>Fora</span>";
                                                }else{
                                                    echo "<span class='label label-success'style='font-size: 12px'>Dentro</span>";
                                                }
                                            }
                                        ?>
                                        
                                    </td>
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
                                                case 'A':
                                                    echo "<span class='label label-info-bootstrap4'style='font-size: 12px'>Abertura</span>";
                                                    break;

                                                case 'E':
                                                    echo "<span class='label label-primary-bootstrap4' style='font-size: 12px;'>Despachado</span>";
                                                    break;

                                                case 'P':
                                                    echo "<span class='label label-info'style='font-size: 12px'>Pendente</span>";
                                                    break;

                                                case 'S':
                                                    echo "<span class='label label-info'style='font-size: 12px'>Pendente</span>";
                                                    break;

                                                case 'L':
                                                    echo "<span class='label label-info'style='font-size: 12px'>Pendente</span>";
                                                    break;

                                                case 'R':
                                                    echo "<span class='label label-default' style='font-size: 12px'>Retorno</span>";
                                                    break;

                                                case 'M':
                                                    echo "<span class='label label-warning'style='font-size: 12px'>Em Manutenção</span>";
                                                    break;

                                                case 'C':
                                                    echo "<span class='label label-important'style='font-size: 12px'>Cancelado</span>";
                                                    break;

                                                case 'O':
                                                    echo "<span class='label label-success'style='font-size: 12px'>Concluído</span>";
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
                                    <!-- <td>
                                        <?php if($chamado['Chamado']['STATUS'] == 'E' &&  $auth_user_group['id'] != 3 && ($auth_user_group['id'] != 4 and $auth_user_group['id'] != 12)): ?>
                                            <button href="javascript;;" class="btn btn-small btn-info" id="btn_update_chamado_manutencao" title="Começar Manutenção" onclick="modalUpdateStatusChamado(<?php echo $chamado['Chamado']['id']; ?>);">
                                                <i class="fa fa-check-square-o"></i>
                                            </button>&nbsp;
                                        <?php endif; ?>
                                    </td> -->

                                </tr>
                                <?php endif; ?>
                            <?php endforeach;?>
                            <!--  -->
                            <?php foreach ($Chamados as $chamado): ?>
                                <?php if($chamado['Chamado']['STATUS'] == 'O'):?>
                                <tr>
                                    <td>
                                        <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'view', $chamado['Chamado']['id'])); ?>"><?php echo h($chamado['Chamado']['SEQOS']); ?></a>
                                    </td>
                                    <td><?php echo $chamado['Chamado']['NMSUPORTET']; ?></td>
                                    <td><?php echo h($chamado['Equipamento']['SERIE']); ?></td>
                                    <td><?php echo h($chamado['Equipamento']['MODELO']); ?></td>
                                    <td><?php echo h($chamado['Chamado']['NMCLIENTE']); ?></td>
                                    <td><?php echo $chamado['Chamado']['CIDADE']?> / <?php echo $chamado['Chamado']['UF']?></td>
                                    <td><?php echo h(date('d-m-Y', strtotime($chamado['Chamado']['DTINCLUSAO']))) . ' ' . h(date('H:i', strtotime($chamado['Chamado']['HRINCLUSAO']))); ?></td>
                                    <?php 
                                        $prevAtend = TempoComponent::calcularSLA($chamado, isset($preAtendimento[$chamado['Chamado']['id']]) ? $preAtendimento[$chamado['Chamado']['id']] : null); 
                                    ?>
                                    <td><?php echo $prevAtend; ?></td>
                                    <td>
                                    <?php
                                    
                                        $strDtAtendimento = $primeiroAtendimento[$chamado['Chamado']['id']] != null ? $primeiroAtendimento[$chamado['Chamado']['id']]['DTATENDIMENTO'] . ' ' . $primeiroAtendimento[$chamado['Chamado']['id']]['HRATENDIMENTO'] : null;
                                        
                                        if($strDtAtendimento != null){
                                            
                                            echo date('d/m/Y H:i', strtotime($strDtAtendimento)); 
                                        }

                                        // recria a data de previsão de atendimento
                                        $year = substr($prevAtend, 6, 4);
                                        $month = substr($prevAtend, 3, 2);
                                        $day = substr($prevAtend, 0, 2);
                                        $hour = substr($prevAtend, 11, 2);
                                        $sec = substr($prevAtend, 14, 2);
                                        
                                        // monta a data 
                                        $datePrevAtendimento = "{$year}/{$month}/${day} ${hour}:{$sec}:00";
                                        
                                    ?>
                                    </td>
                                    <td>
                                        <?php
                                            // converte a data de previsão
                                            $r = date('d/m/Y H:i:s', strtotime($datePrevAtendimento));

                                            if($strDtAtendimento != null){
                                                if(strtotime($strDtAtendimento) > strtotime($datePrevAtendimento)){
                                                    // _tst(strtotime($strDtAtendimento));
                                                    // _tst(strtotime($datePrevAtendimento));
                                                    echo "<span class='label label-warning'style='font-size: 12px;background:#b70c00'>Fora</span>";
                                                }else{
                                                    echo "<span class='label label-success'style='font-size: 12px'>Dentro</span>";
                                                }
                                            }else if($chamado['Chamado']['STATUS'] != 'O'){
                                                // _tst(strtotime($datePrevAtendimento));
                                                // _tst(strtotime(date('Y-m-d H:i:s')));
                                                if(strtotime($datePrevAtendimento) < strtotime(date('Y/m/d H:i:s'))){
                                                    // _tst($datePrevAtendimento);
                                                    // _tst(date('Y/m/d H:i:s'));
                                                    echo "<span class='label label-warning'style='font-size: 12px;background:#b70c00'>Fora</span>";
                                                }else{
                                                    echo "<span class='label label-success'style='font-size: 12px'>Dentro</span>";
                                                }
                                            }
                                        ?>
                                        
                                    </td>
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
                                                case 'A':
                                                    echo "<span class='label label-info-bootstrap4'style='font-size: 12px'>Abertura</span>";
                                                    break;

                                                case 'E':
                                                    echo "<span class='label label-primary-bootstrap4' style='font-size: 12px;'>Despachado</span>";
                                                    break;

                                                case 'P':
                                                    echo "<span class='label label-info'style='font-size: 12px'>Pendente</span>";
                                                    break;

                                                case 'S':
                                                    echo "<span class='label label-info'style='font-size: 12px'>Pendente</span>";
                                                    break;

                                                case 'L':
                                                    echo "<span class='label label-info'style='font-size: 12px'>Pendente</span>";
                                                    break;

                                                case 'R':
                                                    echo "<span class='label label-default' style='font-size: 12px'>Retorno</span>";
                                                    break;

                                                case 'M':
                                                    echo "<span class='label label-warning'style='font-size: 12px'>Em Manutenção</span>";
                                                    break;

                                                case 'C':
                                                    echo "<span class='label label-important'style='font-size: 12px'>Cancelado</span>";
                                                    break;

                                                case 'O':
                                                    echo "<span class='label label-success'style='font-size: 12px'>Concluído</span>";
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
                                    <!-- <td>
                                        <?php if($chamado['Chamado']['STATUS'] == 'E' &&  $auth_user_group['id'] != 3 && ($auth_user_group['id'] != 4 and $auth_user_group['id'] != 12)): ?>
                                            <button href="javascript;;" class="btn btn-small btn-info" id="btn_update_chamado_manutencao" title="Começar Manutenção" onclick="modalUpdateStatusChamado(<?php echo $chamado['Chamado']['id']; ?>);">
                                                <i class="fa fa-check-square-o"></i>
                                            </button>&nbsp;
                                        <?php endif; ?>
                                    </td> -->

                                </tr>
                                <?php endif; ?>
                            <?php endforeach;?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <?php if(in_array($auth_user_group['id'],  array(1,3,6,7,9,12))){?>
            <div class="span6 hidden-phone hidden-tablet" style="margin-left:0px;width:100%">
                <div class="panel panel-primary" style="border-color:#81d5ff">
                    <div class="panel-heading" style="padding:1px 15px;background:#81d5ff;border-color:#81d5ff;text-align:center">
                        <h3 style="color:#0177b1"><i class="fa fa-check-square-o" aria-hidden="true" ></i> Últimos 20 Pré atendimentos</h3>
                    </div>
                    <div class="panel-body text-center" style="min-height: 200px;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID Web</th>
                                    <th>ID Ilux</th>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($PreAtendimento as $preatendimento): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'view', $preatendimento['m']['chamadoId'])); ?>#pre-atendimento"><?php echo h($preatendimento['m']['chamadoId']); ?></a>
                                        </td>
                                        <td><?php echo h($preatendimento['c']['SEQOS']); ?></td>
                                        <td><?php echo h($preatendimento['m']['dateTime']); ?></td>
                                        <td><?php echo strip_tags(mb_strimwidth($preatendimento['m']['message'], 0, 35, "...")); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</div>

<script>

    $(function() {
        setTimeout(function(){ 
            $("#contentLoading").css('display', 'block');
            location.reload();
        }, 60000);
    })

    $("#idUf").on("change", function() {
        console.log(123);
        changeFilter();
    });

    function changeFilter(){

        var url = "<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'authAcl','action' => 'dashboard2')); ?>";
        
        $("#contentLoading").css('display', 'block'); 
        
        const uf = $("#idUf option:selected").val();
        const pagination= $("#idPagination option:selected").val();
        
        window.location = url + '/' + pagination + '/' + uf;
    }



    function modalUpdateStatusChamado(Chamado_id) {
        $.sModal({
            header:'<?php echo __('Atualizar chamado para Em Manutenção') ; ?>',
            animate: 'fadeDown',
            width: 450,
            content: '<div id="group_error"></div><br> <form style="margin: 0px;"><div class="control-group"><label class="control-label" for="tipo_status_chamado" style="font-weight: bold;">Tipo do Status</label><div class="controls"><select id="tipo_status_chamado" name="tipo_status_chamado" style="width:100%;"></select></div></div></form>',
            buttons: [{
                text: ' <?php echo __('Atualizar'); ?> ',
                addClass: 'btn-primary',
                click: function (id, data) {
                    var btnSubmit = $('#'+id).children('.modal-footer').children().first();
                    var modal = $('#'+id).children('.modal-footer').children('a');
                    modal.attr({disabled:'disabled'});
                    btnSubmit.text('<?php echo __('Carregando...'); ?>');
                    $.post('<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'updateChamadoStatus')); ?>/' + Chamado_id, {data:{Status:{tipo_status:$('#'+id).find('#tipo_status_chamado').val()}}}, function (o) {
                        if (o.error == 0) {
                            $.sModal('close', id);
                            window.location = '<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'AuthAcl', 'action' => 'index')); ?>';
                        } else {
                            modal.removeAttr('disabled');
                            btnSubmit.text('<?php echo __('Atualizar'); ?>');
                            var str_error = '<div class="alert alert-error">'+
                                '<button data-dismiss="alert" class="close" type="button">×</button>'+
                                '<strong><?php echo __('Erro! '); ?></strong> '+o.error_message+
                                '</div>'
                            $('#group_error').html(str_error);
                        }
                    }, 'json');
                }
            }, {
                text: ' <?php echo __('Cancel'); ?> ',
                click: function (id, data) {
                    $.sModal('close', id);
                }
            }]
        });
    }

    $('#btn_update_chamado_manutencao').live('click', function () {
        $.getJSON("<?php echo Router::url(array('plugin' => 'pws','controller' => 'chamados','action' => 'listar_status_json')); ?>", {
            estadoId: 'M'
        }, function (cidades) {
            if (cidades != null)
                popularListaDeCidades(cidades, $('#tipo_status_chamado').val());
        });
    });

    function popularListaDeCidades(cidades, idCidade) {
        var options = '<option value="">Selecione um Status</option>';
        if (cidades != null) {
            $.each(cidades, function (index, cidade) {
                if ('0' === index)
                    options += '<option selected="selected" value="' + index + '">' + cidade + '</option>';
                else
                    options += '<option value="' + index + '">' + cidade + '</option>';
            });
            $('#tipo_status_chamado').html(options);
        }
    }
</script>