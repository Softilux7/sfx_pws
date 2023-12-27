<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i
                    class="fa fa-tasks fa-lg"></i> <?php echo __('Solicitação de Suprimento / Serviço por Contratos'); ?></h1>
        </div>
    </div>
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li >
                    <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>
                        <?php echo $this->Html->link(__('Equipamentos Com Contrato'), array('controller' => 'ContratoItens', 'action' => 'index')); ?>
                    <?php }?>
                </li>
                <li>
                    <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>     
                        <?php echo $this->Html->link(__('Equipamentos Sem Contrato'), array('controller' => 'Equipamentos', 'action' => 'index')); ?>
                    <?php }?>
                </li>
                <?php if (EmpresaPermissionComponent::verifiquePermissaoModuloContrato($auth_user['User']['empresa_id'], $auth_user_group['id'])) { ?>
                    <li class="active">
                        <?php echo $this->Html->link(__('Contratos'), array('controller' => 'Contratos', 'action' => 'index')); ?>
                    </li>
                <?php } ?>
                <li >
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
                                    'Contrato.NRCONTRATO' => __('Contrato', true),
                                    'Cliente.FANTASIA' => __('Cliente', true)
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
                                    'placeholder' => "Localizar Contrato"
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
    <?php echo $this->Form->create('Contrato', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
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
                            <?php echo __('Ordenação') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php //echo $this->Paginator->sort('id','ID'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('Contrato.NRCONTRATO', 'Contrato'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('Cliente.FANTASIA', 'Cliente'); ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <?php
            $attr = 0;
            //print_r($Equipamentos);
            foreach ($contratos as $contrato) :
                ?>
                <div class="row-fluid show-grid" style="margin-top: 10px;">
                    <div class="span12 well">
                        <div class="span3">
                            <div><strong>Contrato:</strong>&nbsp;<?php echo h($contrato['Contrato']['NRCONTRATO']); ?>
                            </div>
                            <div><strong>Tipo de Contrato:&nbsp;</strong>
                                <?php switch ($contrato['Contrato']['TIPOCONTRATO']) {
                                    case 'L':
                                        echo "Locação";
                                        break;
                                    case 'A':
                                        echo "Assitência Técnica ";
                                        break; ?>
                                    <?php } ?>
                            </div>
                        </div>
                        <div class="span3">
                            <div><strong>Cliente: </strong>&nbsp;<?php echo h($contrato['Cliente']['FANTASIA']); ?>
                            </div>
                            <div><strong>Data
                                    Início: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($contrato['Contrato']['DTCONTRATOINI'])); ?>
                            </div>
                        </div>
                        <div class="span3">
                            <div><strong>Data
                                    Fim: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($contrato['Contrato']['DTCONTRATOFIN'])); ?>&nbsp;
                            </div>
                            <div>
                                <strong>Data Próximo
                                    Reajuste: </strong><?php echo date('d/m/Y', strtotime($contrato['Contrato']['DTREAJUSTEPREV'])); ?>
                            </div>
                        </div>
                        <div class="span3 text-right">&nbsp;

                            &nbsp;
                            <?php
                            echo $this->Acl->link('<i class="fa fa-plus"></i>&nbsp;Solicitação', array(
                                'controller' => 'Solicitacao',
                                'action' => 'modelo',
                                $contrato ['Contrato'] ['SEQCONTRATO']
                            ), array(
                                'class' => 'btn btn-large btn-warning',
                                'title' => 'Add Solicitação',
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
        window.location = '<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Contratos', 'action' => 'index')); ?>';
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


</script>
