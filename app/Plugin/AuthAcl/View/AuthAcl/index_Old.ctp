<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <div class="page-header">
                <h1><i class="fa fa-home fa-lg"></i> Dashboard </h1>
                <?php if ($auth_user_group['id'] == 3) { ?>
                    <div class="text-left">
                        <i class="fa fa-info-circle fa-lg"></i>
                        Bem vindo <strong><?php echo strtoupper($clienteSelected['Cliente']['FANTASIA']) ?></strong>
                        <?php// print_r($auth_user['Cliente']) ?>
                    </div>
                <?php } else { ?>
                    <!-- <div class="text-left">
                        <i class="fa fa-info-circle fa-lg"></i>
                        Bem vindo <strong><?php echo strtoupper($login_user['user_name']); ?></strong>
                    </div> -->
                <?php } ?>
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
    <div class="row-fluid">
       <?php if($auth_user_group['id'] != 12){?>
        <div class="span6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3><i class="fa fa-check-square-o" aria-hidden="true"></i>
                        Atalhos</h3>
                </div>
                <div class="panel-body" style="min-height: 200px;">
                    <div class="tac">
                        <?php if ($this->Acl->check('ContratoItens', 'index', 'Pws') == true  && ($auth_user_group['id'] != 4 && $auth_user_group['id'] != 10)) { ?>
                            <?php if (($auth_user_group['id'] == 2 && $auth_user['User']['tecnico_terceirizado'] == false) || (in_array($auth_user_group['id'], array(1, 3, 5, 6, 7, 8, 9, 10)))) {?>
                                <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'ContratoItens', 'action' => 'index')); ?>"
                                class="quick-btn">
                                    <i class="fa fa-wrench fa-2x"></i>
                                    <span>Abrir Chamado</span>
                                </a>
                            <?php }?>
                        <?php } ?>

                        <?php if ($this->Acl->check('ContratoItens', 'index', 'Pws') == true && ($auth_user_group['id'] != 2 && $auth_user_group['id'] != 9 && $auth_user_group['id'] != 10)) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'ContratoItens', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-cubes fa-2x"></i>
                                <span>Solicitar Suprimentos</span>
                            </a>
                        <?php } ?>

                        <?php if ($this->Acl->check('Chamados', 'index', 'Pws') == true) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-clipboard fa-2x"></i>
                                <span>Acompanhar Chamados</span>
                            </a>
                        <?php } ?>
                        
                        <?php if ($this->Acl->check('DFaturamentos', 'index', 'Pws') == true) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'DFaturamentos', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-inbox fa-2x"></i>
                                <span>Faturamento</span>
                            </a>
                        <?php } ?>
                        
                        <?php if ($this->Acl->check('AcompanharAtendimento', 'index', 'Pws') == true && ($auth_user_group['id'] != 10)) { ?>
                        <?php
                        // _tst($auth_user)
                        // echo date('Y-m-d H:i:s').'.'.md5('psfx' . date('Y-m-d H:i:s') . 'xfsp').'.'.$auth_user['User']['user_password'].'.'.$auth_user['User']['id'].'.'.$auth_user['User']['empresa_id'];
                            
                        ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'AcompanharAtendimento', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-street-view fa-2x"></i>
                                <span>Acompanhar Atendimento</span>
                            </a>
                        <?php } ?>
                        
                        <!-- <?php if ($this->Acl->check('Chamados', 'listarAvaliacao', 'Pws') == true) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'listarAvaliacao')); ?>"
                               class="quick-btn">
                                <i class="fa fa-pie-chart fa-2x"></i>
                                <span>Avaliação NPS</span>
                            </a>
                        <?php } ?> -->

                        <?php if ($this->Acl->check('Solicitacao', 'index', 'Pws') == true) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Solicitacao', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-tasks fa-2x"></i>
                                <span>Acompanhar Solicitação</span>
                            </a>
                        <?php } ?>
                        <?php if ($this->Acl->check('Chamados', 'edit', 'Pws') == true && ($auth_user_group['id'] != 10)) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-cogs fa-2x"></i>
                                <span>Atendimento Técnico</span>
                            </a>
                        <?php } ?>

                        <?php if ($this->Acl->check('NfsaidaEntregas', 'index', 'Pws') == true) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'NfsaidaEntregas', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-truck fa-2x"></i>
                                <span>Transportador</span>
                            </a>
                        <?php } ?>

                        <?php if ($this->Acl->check('Contato', 'index', 'Pws') == true) { ?>
                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'contato', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-envelope-o fa-2x"></i>
                                <span>Contato</span>
                            </a>
                        <?php } ?>

                        <?php if ($this->Acl->check('Relatorios', 'index', 'Pws') == true) { ?>

                            <!-- AJUSTES EMPRESA DATA VOICE - CLIENTES NÃO PODE VER CHAMADOS CONCLUÍDOS   -->
                            <?php if($auth_user_group['id'] == 3 and $auth_user['User']['empresa_id'] == 15){ }else{ ?>

                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Relatorios', 'action' => 'index')); ?>"
                               class="quick-btn">
                                <i class="fa fa-file-text-o fa-2x"></i>
                                <span>Relatórios</span>
                            </a>
                            <?php } ?>

                        <?php } ?>

                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <?php if($auth_user_group['id'] == 12) {?>

        <div style="text-align:center">
            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'ContratoItens', 'action' => 'index')); ?>" class="quick-btn">
                <i class="fa fa-wrench fa-2x"></i>
                <span>Abrir Chamado</span>
            </a>
            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?>" class="quick-btn">
                <i class="fa fa-clipboard fa-2x"></i>
                <span>Acompanhar Chamados</span>
            </a>
        </div>

        <?php }?>

        <?php if(in_array($auth_user_group['id'],  array(1,3,6,7,9,12))){?>
            <div class="span6 hidden-phone hidden-tablet" style="<?php if($auth_user_group['id'] == 12) echo 'margin-left:0px;width:100%'?>">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3><i class="fa fa-check-square-o" aria-hidden="true"></i> Últimos 10 Pré-atendimentos
                        </h3>
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


    <div class="row-fluid hidden-phone hidden-tablet hidden-sm" >
        <div class="span6" style="<?php if($auth_user_group['id'] == 12) echo 'margin-left:0px;width:100%'?>">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3><i class="fa fa-check-square-o" aria-hidden="true"></i> Últimos 10 Chamados</h3>
                </div>
                <div class="panel-body text-center" style="min-height: 200px;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Série</th>
                                <th>Modelo</th>
                                <th>Data Abertura</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($Chamados as $chamado): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'view', $chamado['Chamado']['id'])); ?>"><?php echo h($chamado['Chamado']['SEQOS']); ?></a>
                                    </td>
                                    <td><?php echo h($chamado['Equipamento']['SERIE']); ?></td>
                                    <td><?php echo h($chamado['Equipamento']['MODELO']); ?></td>
                                    <td><?php echo h(date('d-m-Y', strtotime($chamado['Chamado']['DTINCLUSAO']))) . ' ' . h(date('H:i', strtotime($chamado['Chamado']['HRINCLUSAO']))); ?></td>
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
                                                case 'A':
                                                    echo "<span class='label label-info-bootstrap4'style='font-size: 14px'>Abertura</span>";
                                                    break;
                                                case 'T':
                                                    echo "<span class='label label-default'style='font-size: 14px'>Atendido</span>";
                                                    break;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($chamado['Chamado']['STATUS'] == 'E' &&  $auth_user_group['id'] != 3 && ($auth_user_group['id'] != 4 and $auth_user_group['id'] != 12)): ?>
                                            <button href="javascript;;" class="btn btn-small btn-info" id="btn_update_chamado_manutencao" title="Começar Manutenção" onclick="modalUpdateStatusChamado(<?php echo $chamado['Chamado']['id']; ?>);">
                                                <i class="fa fa-check-square-o"></i>
                                            </button>&nbsp;
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <?php if($auth_user_group['id'] != 9 and $auth_user_group['id'] != 12){?>
            <div class="span6 hidden-phone hidden-tablet">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3><i class="fa fa-check-square-o" aria-hidden="true"></i> Últimas 10 Solicitações de Suprimentos
                        </h3>
                    </div>
                    <div class="panel-body text-center" style="min-height: 200px;">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Série</th>
                                    <th>Modelo</th>
                                    <th>Data da Solicitação</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($Solicitacoes as $solicitacao): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'solicitacao', 'action' => 'view', $solicitacao['Solicitacao']['id'])); ?>"><?php echo h($solicitacao['Solicitacao']['id']); ?></a>
                                        </td>
                                        <?php if (empty($solicitacao['Solicitacao']['contrato_id'])): ?>
                                            <td><?php echo h($solicitacao['Equipamento']['SERIE']); ?></td>
                                            <td><?php echo h($solicitacao['Equipamento']['MODELO']); ?></td>
                                        <?php else: ?>
                                            <td> N/a</td>
                                            <td><?php echo h($solicitacao['Solicitacao']['modelo']); ?></td>
                                        <?php endif; ?>

                                        <td><?php echo h(date('d-m-Y H:i', strtotime($solicitacao['Solicitacao']['created']))); ?></td>
                                        <td><?php
                                            switch ($solicitacao['Solicitacao']['status']) {
                                                case 'P':
                                                    echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                    break;
                                                case 'T':
                                                    echo "<span class='label label-warning'style='font-size: 14px'>Em Trânsito</span>";
                                                    break;
                                                case 'C':
                                                    echo "<span class='label label-danger'style='font-size: 14px'>Cancelada</span>";
                                                    break;
                                                case 'O':
                                                    echo "<span class='label label-success'style='font-size: 14px'>Concluída</span>";
                                                    break;
                                                case 'E':
                                                    echo "<span class='label label-primary-bootstrap4' style='font-size: 14px'>Em Análise</span>";
                                                    break;
                                                case 'L':
                                                    echo "<span class='label label-default' style='font-size: 14px'>Liberada</span>";
                                                    break;
                                            }
                                            ?></td>
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

    function validationLgpd(){
        let idModal = 0;
        let contentData = null;
        const action = 1;
        let countChecked = 0;
        let amountCheckBox = 0;
        let notAccept = 0;
        const message = '';
        let itens = [];
        let fields = ['politica_privacidade', 'termo_uso', 'termo_consentimento', 'email', 'motivo'];

        const setItens = (param) =>{

            itens = [];
            
            fields.forEach(response => {
                // verifi se o campo existe no json repassado pelo data
                const data = param.find(search => {
                    return search.name == response;
                });

                if(!!data){
                    // itens vindo do formulário
                    itens.push(data);
                }
            });
        }

        const countClick = (check) =>{
            countChecked = 0;

            // conta o total de checados
            $('#container_termos input[type=checkbox]:checked').each(()=>{ countChecked++; });

            // pega o total de checkbox
            amountCheckBox = $('#container_termos input[type=checkbox]').length;

            if(check != undefined){
                handleDescription(false);
                notAccept = 0;
                $('#negado').removeAttr('checked');
            }

        }

        const handleDescription = (open) =>{
            if(open){
                $('#addInfo').css('display', 'block');
                $('#motivo').focus();
            }else{
                $('#addInfo').css('display', 'none');
                $('#motivo').val("");
            }
        }

        const handleConfirm = ()=>{
            var email = $('#email').val().trim();
            var motivo = $('#motivo').val().trim();
            setMessage('');

            // valida os checkbox
            countClick();

            // verifica se os dados foram preenchidos
            if(countChecked < 1 && (email == '' || motivo == '')){
                setMessage('Preencha os campos informados !');

                $('#motivo').focus();
            }else{
                setMessage('Aguarde, validando os dados...', '#387038');

                // define se não foi aceito os termos de uso
                itens.push({name: 'negado', value: notAccept});
                
                if(!!contentData.id){
                    itens.push({name : 'id', value: contentData.id});
                }

                const modal = $('#' + idModal).children('.modal-footer').children('a');
                modal.attr({disabled:'disabled'});
                
                // envia os dados via post
                $.post('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'AuthAcl', 'action' => 'setDataLgpd')); ?>', {data:{itens}}, function (response) {
                    // 
                    console.log(response);

                    setMessage('Finalizado...', '#387038');

                    // habilita os botoes novamente
                    modal.removeAttr('disabled');

                    $.sModal('close', idModal);

                }, 'json');

            }
        }

        const handleNotAccept = () =>{

            if(notAccept == 0){
                notAccept = 1;
                // remove todos os checkbox
                $('#politica_privacidade').removeAttr('checked');
                $('#termo_uso').removeAttr('checked');
                $('#termo_consentimento').removeAttr('checked');

                handleDescription(true);
            }else{
                notAccept = 0;
                $('#politica_privacidade').attr('checked', true);
                $('#termo_uso').attr('checked', true);
                $('#termo_consentimento').attr('checked', true);

                handleDescription(false);
            }
            
        }

        const setMessage = (message, color) =>{
            $('#group_error').html(message);
            $('#group_error').css('color', color != undefined ? color : '#cc0000');
        }

        const modal = ({email, data}) =>{

            contentData = data;
            
            $.sModal({
                header:'Prezado usuário do PWS',
                animate: 'fadeDown',
                width: 700,
                content:  
                        '<div style="margin-bottom: 15px; line-height: 20px; font-size:13px">' +
                        '<div id="group_error" style="font-weight: bold;"></div>' +
                        'Em virtude da <strong>LGPD</strong> <em>(lei geral de proteção de dados)</em>, disponibilizamos os documentos explicativos referente a captura, compartilhamento e tratamento dos dados utilizados pelo <strong>PWS</strong>. ' +
                        'De maneira geral, o <strong>PWS</strong> acessa somente informações de identificação, informações de contratos necessárias para atendimento e prestação dos serviços.' +
                        ' Não tratamos dados sensíveis ou meios de pagamento.' +
                        ' Desta forma, solicitamos que confirmem, ou não, o entendimento/aceite dos documentos disponibilizados.' +
                        ' Uma vez que estes documentos tiverem confirmação, do usuário, não iremos mais solicitar, exceto se houver alterações nos termos. Entretanto, enquanto os documentos não forem confirmados, o aviso irá aparecer na tela.' +
                        ' É necessário fazer a confirmação individual, por documento.<br/><br/>' +
                        '<em><strong>- Termos e condições uso.</strong></em><br/>' +
                        '<em><strong>- Política de privacidade.</strong></em><br/>' +
                        '<em><strong>- Termo de consentimento para tratamento de dados.</strong></em><br/><br/>' +
                        '<span style="font-size:12px">Qualquer dúvida estamos à disposição. ' +
                        'Muito obrigado.</span></div>'+
                        '<form style="margin: 0px;" id="contentModalLgpd">' +
                        '<div id="container_termos">' +
                        '<div class="control-group" style="display:flex;margin:0px"><label for="politica_privacidade" style="margin:0px;padding-right:10px">Política de privacidade</label>'+ (!!data.politica_privacidade ? ' <label style="color:#5bb75b">(confirmado)</label>' : '<input type="checkbox" onClick="javascript:objValidation.countClick(true)" name="politica_privacidade" value="1" id="politica_privacidade" checked="checked">') +  '</div><div style="line-height:13px;margin-bottom: 10px;"><a target="_blank" href="<?php echo $this->webroot; ?>/files/lgpd/politica_de_privacidade.pdf">download</a></div>' +
                        '<div class="control-group" style="display:flex;margin:0px"><label for="termoUso" style="margin:0px;padding-right:10px">Termos e condições gerais de uso</label>' + (!!data.termo_uso ? '<label style="color:#5bb75b">(confirmado)</label>' : '<input type="checkbox" onClick="javascript:objValidation.countClick(true)" name="termo_uso" value="1" id="termo_uso" checked="checked">') + '</div><div style="line-height: 13px;margin-bottom: 10px;"><a target="_blank" href="<?php echo $this->webroot; ?>/files/lgpd/termos_e_condicoes_gerais_de_uso.pdf">download</a></div>' +
                        '<div class="control-group" style="display:flex;margin:0px"><label for="termoConsentimento" style="margin:0px;padding-right:10px">Termo de consentimento</label>' + (!!data.termo_consentimento ? '<label  style="color:#5bb75b">(confirmado)</label>' : '<input type="checkbox" onClick="javascript:objValidation.countClick(true)" name="termo_consentimento" value="1" id="termo_consentimento" checked="checked">') + '</div><div style="line-height: 13px;margin-bottom: 10px;"><a target="_blank" href="<?php echo $this->webroot; ?>/files/lgpd/termo_de _consentimento_para_tratamento_de_dados.pdf">download</a></div>' +
                        '<div id="addInfo" style="display:none">'+
                        '<div style="margin-top: 30px;margin-bottom: 15px;"><div>Informe seu email e o motivo por não aceitar os termos de uso.</div></div>'+
                        '<div class="control-group" style="display:flex"><label for="termoConsentimento" style="margin:0px;padding-right:10px">E-mail:</label><input type="text" name="email" value="'+email+'" id="email"></div>' +
                        '<div class="control-group" style="display:flex"><label for="termoConsentimento" style="margin:0px;padding-right:10px">Motivo:</label><input type="text" name="motivo" size="150" value="" id="motivo"></div>' +
                        '</div>'+
                        '</div>' +
                        '<div class="control-group" style="display:flex;margin:0px"><input type="checkbox" onClick="javascript:objValidation.handleNotAccept()" name="negado" value="0" id="negado" style="margin:0px"><div style="line-height: 13px;margin-bottom: 0px;margin-left:5px"><label for="termoConsentimento" style="margin:0px;padding-right:10px;color:#cc0000">Não aceito os termos de uso</label></div></div>' +
                        '</form>'
                        ,
                buttons: [{
                    text: 'Salvar',
                    addClass: 'btn-success',
                    click: function (id, data) {
                        // define o id da Modal
                        idModal = id;

                        // prepara os dados
                        setItens(data);

                        // valida e envia os dados
                        handleConfirm();
                    }
                },
                {
                    text: 'Agora não',
                    click: function (id, data) {
                        $.sModal('close', id);
                    }
                }]
            });
        }

        return {modal, countClick, handleNotAccept}
    }

    var objValidation = validationLgpd();

    const dataLgpd = <?php echo $dataLgpd?>;

    if(dataLgpd.open){
        objValidation.modal({email: '<?php echo $auth_user['User']['user_email'];?>', data : dataLgpd});
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