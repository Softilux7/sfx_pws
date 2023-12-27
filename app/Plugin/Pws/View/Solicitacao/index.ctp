<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i class="fa fa-tasks fa-lg"></i> <?php echo __('Solicitações de Suprimentos'); ?>
            </h1>
        </div>
    </div>
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li>
                    <?php echo $this->Html->link(__('Equipamentos Com Contrato'), array('controller' => 'ContratoItens', 'action' => 'index')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link(__('Equipamentos Sem Contrato'), array('controller' => 'Equipamentos', 'action' => 'index')); ?>
                </li>
                <?php if (EmpresaPermissionComponent::verifiquePermissaoModuloContrato($auth_user['User']['empresa_id'], $auth_user_group['id'])) { ?>
                    <li>
                        <?php echo $this->Html->link(__('Contratos'), array('controller' => 'Contratos', 'action' => 'index')); ?>
                    </li>
                <?php } ?>
                <li>
                    <?php echo $this->Html->link(__('Chamados'), array('controller' => 'Chamados', 'action' => 'index')); ?>
                </li>
                <li class="active">
                    <?php echo $this->Html->link(__('Solicitações'), array('controller' => 'Solicitacao', 'action' => 'index')); ?>
                </li>
            </ul>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <?php echo($this->Session->flash()); ?>
            <br/>
        </div>
    <?php } ?>
    <button type="button" class="btn btn-large btn-search" data-toggle="collapse"
            data-target="#search">
        <i class="icon-filter"></i> Filtrar Resultados
    </button>
    <div id="search" class="collapse">
        <div class="row-fluid show-grid">
            <div class="span10">
                <?php echo $this->Search->create('', array('class' => 'form-inline')); ?>
                <fieldset>
                    <legend>Filtro</legend>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Coluna:'); ?> </label>

                            <div class="controls">
                                <?php

                                echo $this->Search->selectFields('filter1', array(
                                    'Solicitacao.id' => __('Nº Solicitacao WEB', true),
                                    'Solicitacao.contrato_id' => __('Seq Contrato', true),
                                    'Equipamento.SERIE' => __('Serie', true),
                                    'Equipamento.PATRIMONIO' => __('Patrimônio', true),
                                    'Equipamento.DEPARATMANETO' => __('Departamento', true),
                                    'Solicitacao.departamento' => __('Depto Solicitação', true)
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
                                    'placeholder' => "Localizar Solicitacao"
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
    <?php echo $this->Form->create('Solicitacao', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
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
                            <?php echo __('Status do Solicitacao') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->Html->link(__('Concluídas'), array('controller' => 'Solicitacao', 'action' => 'index', 'O')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Pendentes'), array('controller' => 'Solicitacao', 'action' => 'index', 'P')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Cancelados/Rejeitados'), array('controller' => 'Solicitacao', 'action' => 'index', 'C')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Em Trânsito'), array('controller' => 'Solicitacao', 'action' => 'index', 'T')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Em Análise'), array('controller' => 'Solicitacao', 'action' => 'index', 'E')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Todos'), array('controller' => 'Solicitacao', 'action' => 'index')); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn  btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Ordenar por:') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Paginator->sort('id', 'Nº Solicitacao'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('contrato_id', 'Seq. Contrato'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('created', 'Data da Solicitacao'); ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <?php
            $attr = 0;
            //print_r($Solicitacoes);
            foreach ($Solicitacoes as $Solicitacao) :
                ?>
                <div class="row-fluid show-grid" style="margin-top: 10px;">
                    <div class="span12 well">
                        <div class="span2">
                            <?php if (!empty($Solicitacao['Solicitacao']['contrato_id'])) { ?>
                                <div class="text-warning"><strong>Tipo: MODELO / CONTRATO</strong></div>
                                <div><strong>Solicitacao
                                    Nº:</strong>&nbsp;<?php echo h($Solicitacao['Solicitacao']['id']); ?></div>
                            <?php } else { ?>
                                <div class="text-info"><strong>Tipo: EQUIPAMENTO / SÉRIE</strong></div>
                            <div><strong>Solicitacao
                                    Nº:</strong>&nbsp;<?php echo h($Solicitacao['Solicitacao']['id']); ?></div>


                                <div><strong>Série:</strong>&nbsp;<?php echo h($Solicitacao['Equipamento']['SERIE']); ?>
                                </div>
                            <?php } ?>

                            <?php if (!empty($Solicitacao['Solicitacao']['contrato_id'])) { ?>
                                <div>
                                    <strong>Contrato:</strong>&nbsp;<?php echo h($Solicitacao['Solicitacao']['contrato_id']); ?>
                                </div>
                            <?php } else { ?>
                                <div>
                                    <strong>Contrato:</strong>&nbsp;<?php echo h($Solicitacao['Equipamento']['SEQCONTRATO']); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (!empty($Solicitacao['Solicitacao']['contrato_id'])) { ?>
                        <div class="span3">
                            <div>
                                <strong>Modelo:</strong>&nbsp;<?php echo h($Solicitacao['Solicitacao']['modelo']); ?>
                            </div>
                            <div>
                                <strong>Departamento: </strong><?php echo h($Solicitacao['Solicitacao']['departamento']); ?>
                            </div>
                            <div><strong>Local de
                                    Instalação: </strong><?php echo h($Solicitacao['Solicitacao']['localinstal']); ?>
                            </div>
                        </div>
                        <?php } else { ?>
                            <div class="span3">
                                <div>
                                    <strong>Patrimônio:</strong>&nbsp;<?php echo h($Solicitacao['Equipamento']['PATRIMONIO']); ?>
                                </div>
                                <div>
                                    <strong>Departamento: </strong><?php echo h($Solicitacao['Equipamento']['DEPARTAMENTO']); ?>
                                </div>
                                <div><strong>Local de
                                        Instalação: </strong><?php echo h($Solicitacao['Equipamento']['LOCALINSTAL']); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="span3">

                            <?php if (!empty($Solicitacao['Solicitacao']['contrato_id'])) { ?>
                                <div>
                                    <strong>Contato:</strong>&nbsp;<?php echo h($Solicitacao['Solicitacao']['contato']); ?>
                                </div>
                                <div><strong>Cliente: </strong>&nbsp;<?php echo h($Solicitacao['Cliente']['NMCLIENTE']); ?>
                                </div>
                                <div><strong>Cidade: </strong>&nbsp;<?php echo h($Solicitacao['Solicitacao']['cidade']); ?>
                                &nbsp;</div>
                            <?php } else { ?>
                                <div><strong>Cliente: </strong>&nbsp;<?php echo h($Solicitacao['Cliente']['NMCLIENTE']); ?>
                                </div>
                                <div><strong>Cidade: </strong>&nbsp;<?php echo h($Solicitacao['Equipamento']['CIDADE']); ?>
                                    &nbsp;</div>
                            <?php } ?>
                        </div>

                        <div class="span2">
                            <div><strong>Status: </strong>&nbsp;<?php
                                switch ($Solicitacao['Solicitacao']['status']) {
                                    case 'P':
                                        echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                        break;
                                    case 'T':
                                        echo "<span class='label label-warning'style='font-size: 14px'>Em Trânsito</span>";
                                        break;
                                    case 'C':
                                        echo "<span class='label label-danger'style='font-size: 14px'>Cancelada/Rejeitada</span>";
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
                                ?>&nbsp;</div>
                            <div><strong>Data
                                    Solicitacao: </strong>&nbsp;<?php echo date('d/m/Y H:i', strtotime($Solicitacao['Solicitacao']['created'])); ?>
                            </div>
                        </div>

                        <div class="span2 text-right">&nbsp;
                            <?php
                            echo $this->Acl->link('<i class="fa fa-eye"></i>', array(
                                'controller' => 'Solicitacao',
                                'action' => 'view',
                                $Solicitacao ['Solicitacao'] ['id']
                            ), array(
                                'class' => 'btn btn-large btn-default',
                                'escape' => false
                            ));
                            ?>
                            &nbsp;
                            <?php

                            if ($Solicitacao ['Solicitacao'] ['status'] != 'O' && $Solicitacao ['Solicitacao'] ['status'] != 'C') {
                                echo $this->Acl->link('<i class="fa fa-edit"></i>', array(
                                    'controller' => 'Solicitacao',
                                    'action' => 'edit',
                                    $Solicitacao ['Solicitacao'] ['id']
                                ), array(
                                    'class' => 'btn btn-large btn-info',
                                    'escape' => false
                                ));
                            }
                            ?>

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
                    echo $this->Paginator->prev('&larr; ' . __('Anterior'), array(
                        'tag' => 'li',
                        'escape' => false
                    ));
                    echo $this->Paginator->numbers(array(
                        'separator' => '',
                        'tag' => 'li'
                    ));
                    echo $this->Paginator->next(__('Proximo') . ' &rarr;', array(
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
    function cancelSearch() {
        removeUserSearchCookie();
        window.location = '<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Solicitacao', 'action' => 'index')); ?>';
    }
    function showAddSolicitacaoPage() {
        window.location = "<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Solicitacao', 'action' => 'aberturaOs', $Solicitacao['Solicitacao']['id'])); ?>";
    }
    function delSolicitacao(Solicitacao_id, name) {
        $.sModal({
            image: '<?php echo $this->webroot; ?>img/icons/error.png',
            content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + name + '</b>?',
            animate: 'fadeDown',
            buttons: [{
                text: ' <?php echo __('Delete'); ?> ',
                addClass: 'btn-danger',
                click: function (id, data) {
                    $.post('<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Solicitacao', 'action' => 'delete')); ?>/' + Solicitacao_id, {}, function (o) {
                        $('#container').load('<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Solicitacao', 'action' => 'index')); ?>', function () {
                            $.sModal('close', id);
                            $('#tab_user_manager').find('a').each(function () {
                                $(this).click(function () {
                                    removeUserSearchCookie();
                                });
                            });
                        });
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
    $(document).ready(function () {
        $('.pagination > ul > li').each(function () {
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
            content = 'Por Favor Selecione um Solicitacao para a Abrir um Solicitacao.';
            $.sModal({
                image: '<?php echo $this->webroot; ?>img/icons/error.png',
                content: '<b>' + content + '</b>',
                animate: 'fadeDown',
                buttons: [{
                    text: ' <?php echo __('Ok'); ?> ',
                    click: function (id, data) {
                        $.sModal('close', id);
                    }
                }]
            });
//   		$(this).click(function(){
// 			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:0px; top:45px; display: none;">'
// 				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
            +'<strong><?php echo __('Success!'); ?></strong> <?php echo __('Por Favor Selecione um Solicitacao na Listagem.'); ?>' + '</div>';
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
                click: function (id, data) {
                    $.sModal('close', id);
                }
            }]
        });
    }


</script>
