<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i class="fa fa-tasks fa-lg"></i> <?php echo __('Lista de Equipamentos'); ?></h1>
        </div>
    </div>
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li >
                    <?php echo $this->Html->link(__('Equipamentos Grupo Contrato'), array('controller' => 'ContratoItens', 'action' => 'index')); ?>
                </li>
                <li class="active">
                    <?php echo $this->Html->link(__('Equipamentos'), array('controller' => 'ContratoItens', 'action' => 'equipamentos')); ?>
                </li>
                <li>
                    <?php echo $this->Html->link(__('Chamados'), array('controller' => 'Chamados', 'action' => 'index')); ?>
                </li>

            </ul>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
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
                                    'Equipamento.cdequipamento' => __('Equipamento', true),
                                    'Equipamento.serie' => __('Serie', true),
                                    'Equipamento.contrato' => __('Contrato', true)
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
                                    'placeholder' => "Localizar Equipamento"
                                ));
                                ?>
                                <button class="btn" type="submit">
                                    <?php echo __('Search'); ?>
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
    <?php echo $this->Form->create('Equipamento', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
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
                        <a class="btn  btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Ordenação')?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php //echo $this->Paginator->sort('id','ID'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('cdequipamento', 'Equipamento'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('contrato', 'Contrato'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('serie', 'Serie'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('Produto.produto_nome', 'Produto'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('cidade', 'Cidade'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('departamento', 'Departamento'); ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <?php
            $attr = 0;
            //print_r($Equipamentos);
            foreach ($Equipamentos as $Equipamento) :
                ?>
                <div  class="row-fluid show-grid">
                    <div class="span12 well">
                        <div class="span3">
                            <div><strong>Série:</strong>&nbsp;<?php echo h($Equipamento['Equipamento']['SERIE']); ?></div>
                            <div><strong>Patrimônio:</strong>&nbsp;<?php echo h($Equipamento['Equipamento']['PATRIMONIO']); ?></div>
                        </div>
                        <div class="span3">
                            <div><strong>Descrição: </strong>&nbsp;<?php echo h($Equipamento['Produto']['NMPRODUTO']); ?></div>
                            <div><strong>Contrato: </strong>&nbsp;<?php echo h($Equipamento['Contrato']['NRCONTRATO']); ?></div>
                        </div>
                        <div class="span3">
                            <div><strong>Cidade: </strong>&nbsp;<?php echo h($Equipamento['Equipamento']['CIDADE']); ?>&nbsp;</div>
                            <div>

                                <strong>Departamento: </strong><?php echo h($Equipamento['Equipamento']['DEPARTAMENTO']); ?>

                            </div>
                        </div>
                        <div class="span3 text-right">&nbsp;
                            <?php
                            echo $this->Acl->link('<i class="fa fa-plus"></i>&nbsp;Chamado', array(
                                'controller' => 'Chamados',
                                'action' => 'add',
                                $Equipamento ['Equipamento'] ['id']
                            ), array(
                                'class' => 'btn btn-large btn-info',
                                'title'=> 'Abrir Chamado Técnico',
                                'escape' => false
                            ));
                            ?>
                            &nbsp;
                            <?php
                            echo $this->Acl->link('<i class="fa fa-plus"></i>&nbsp;Suprimento', array(
                                'controller' => 'Solicitacao',
                                'action' => 'add',
                                $Equipamento ['Equipamento'] ['id']
                            ), array(
                                'class' => 'btn btn-large btn-warning',
                                'title'=> 'Solicitar Suprimento',
                                'escape' => false
                            ));
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
        window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Equipamentos','action' => 'index')); ?>';
    }
    function showAddEquipamentoPage() {
        window.location = "<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Equipamentos','action' => 'aberturaOs',$Equipamento['Equipamento']['id'])); ?>";
    }
    function delEquipamento(Equipamento_id, name) {
        $.sModal({
            image: '<?php echo $this->webroot; ?>img/icons/error.png',
            content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + name + '</b>?',
            animate: 'fadeDown',
            buttons: [{
                text: ' <?php echo __('Delete'); ?> ',
                addClass: 'btn-danger',
                click: function (id, data) {
                    $.post('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Equipamentos','action' => 'delete')); ?>/' + Equipamento_id, {}, function (o) {
                        $('#container').load('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Equipamentos','action' => 'index')); ?>', function () {
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
            content = 'Por Favor Selecione um Equipamento para a Abrir um Chamado.';
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
            +'<strong><?php echo __('Success!'); ?></strong> <?php echo __('Por Favor Selecione um Equipamento na Listagem.'); ?>' + '</div>';
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
