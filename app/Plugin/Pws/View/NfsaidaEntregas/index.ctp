<div class="span12">
    <script src="<?php echo $this->webroot; ?>datetimepicker/js/jquery.datetimepicker.js"></script>
    <link href="<?php echo $this->webroot; ?>datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i class="fa fa-tasks fa-lg"></i> <?php echo __('Lista de Entregas Pendentes'); ?>
            </h1>
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
    <div id="search" class="in collapse">
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
                                    'Nfe.NRNFSAIDA' => __('Nº NFe', true),
                                    'Nfe.NMCLIENTE' => __('Cliente', true),
                                    'NfsaidaEntrega.NR_OBJETO' => __('Numero Objeto', true)
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
    <hr>
    <?php echo $this->Form->create('NfsaidaEntrega', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
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
                            <?php echo __('Ordenar por:') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Paginator->sort('Nfe.NRNFSAIDA', 'Nº NFe'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('Nfe.NMCLIENTE', 'Cliente'); ?>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <?php
            $attr = 0;
            //print_r($Chamados);
            foreach ($NfsaidaEntrega as $NfsaidaEntrega) :
                ?>
                <div class="row-fluid show-grid" style="margin-top: 10px;">
                    <div class="span12 well">
                        <div class="span3">
                            <div>
                                <strong>Nº NF.:</strong>&nbsp;<?php echo h($NfsaidaEntrega['Nfe']['NRNFSAIDA']); ?>
                            </div>
                            <div>
                                <strong>Data de Emissão:</strong>&nbsp;<?php echo date('d/m/Y', strtotime($NfsaidaEntrega['Nfe']['DTEMISSAONFS'])); ?>
                            </div>
                        </div>

                        <div class="span3">
                            <div>
                                <strong>Nº do
                                    Objeto:</strong>&nbsp;<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['NR_OBJETO']); ?>
                            </div>
                            <div><strong>Situação: </strong>&nbsp;<?php
                                if ($NfsaidaEntrega['NfsaidaEntrega']['SITUACAO_ENTREGA'] == 'T') {
                                    echo 'Em Transito';
                                }
                                // echo h($NfsaidaEntrega['NfsaidaEntrega']['SITUACAO_ENTREGA']);

                                ?>&nbsp;
                            </div>
                        </div>

                        <div class="span3">
                            <div><strong>Cliente: </strong>&nbsp;<?php echo h($NfsaidaEntrega['Nfe']['NMCLIENTE']); ?>
                            </div>
                        </div>

                        <div class="span2">
                            <div><strong>Data da Entrega: </strong>&nbsp;
                                <?php
                                    if (!($NfsaidaEntrega['NfsaidaEntrega']['DATAHORA'] == 0)) {
                                        echo date('d-m-Y H:i', strtotime($NfsaidaEntrega['NfsaidaEntrega']['DATAHORA']));
                                    }

                                ?>
                            </div>
                        </div>

                        <div class="span2 text-right">&nbsp;
                            <?php
                            //                            echo $this->Acl->link('<i class="fa fa-check-circle"></i>&nbsp;Entregar', array(
                            //                                'controller' => 'NfsaidaEntregas',
                            //                                'action' => 'index'
                            //                            ), array(
                            //                                'class' => 'btn btn-large btn-success',
                            //                                'escape' => false
                            //                            ));
                            ?>
                            &nbsp;
                        </div>
                        <div class="row-fluid ">
                            <div class="span12">
                                <div class="accordion"
                                     id="accordion<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>">
                                    <div class="accordion-group">
                                        <div class="accordion-heading text-right">
                                            <button type="button" class="btn btn-large btn-info" data-toggle="collapse"
                                                    data-parent="#accordion<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>"
                                                    data-target="#collapse<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>">
                                                <i class="fa fa-check-circle"></i>&nbsp;Marcar Como Entregue
                                            </button>
                                        </div>
                                        <div id="collapse<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>"
                                             class="accordion-body collapse in">
                                            <div class="accordion-inner">
                                                Dados do Recebimento: &nbsp;&nbsp;&nbsp;Entregue para:
                                                <input type="hidden" name="data[NfsaidaEntrega][id]"
                                                       value="<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>"/>
                                                <input type="hidden" name="data[NfsaidaEntrega][SITUACAO_ENTREGA]"
                                                       value="E"/>
                                                <input type="TEXT" class="span2" id="nm_recebedor<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>" required
                                                       name="data[NfsaidaEntrega][NM_RECEBEDOR]"
                                                       value="<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['NM_RECEBEDOR']); ?>"/>
                                                &nbsp;&nbsp;&nbsp;Data da Entrega:
                                                <input
                                                    id="dt_entrega<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>"
                                                    type="TEXT" class="span2" required
                                                    name="data[NfsaidaEntrega][DATAHORA]"
                                                    value="<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['DATAHORA']); ?>"/>
                                                &nbsp;&nbsp;&nbsp;
                                                <a href="#"
                                                   id="confirmar<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>"
                                                   class="btn btn-large btn-success"
                                                   onclick="confirmaRecebimento(<?php echo "'".h($NfsaidaEntrega['NfsaidaEntrega']['id'])?>',$('#nm_recebedor<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>').val(),$('#dt_entrega<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>').val());return false;">
                                                    <i class="fa fa-check-circle"></i>&nbsp;Confirmar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                        $('#dt_entrega<?php echo h($NfsaidaEntrega['NfsaidaEntrega']['id']); ?>').datetimepicker({
                            lang: 'pt',
                            timepicker: true,
                            // format:'d-m-Y'
                            mask: true,
                            format: 'Y-m-d H:i'

                        });
                    </script>
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
        window.location = '<?php echo Router::url(array('plugin' => 'pws','controller' => 'NfsaidaEntregas','action' => 'index')); ?>';
    }
    //    function showAddChamadoPage() {
    //        window.location = "<?php //echo Router::url(array('plugin' => 'Pws','controller' => 'NfsaidaEntregas','action' => 'aberturaOs',$Chamado['Chamado']['id'])); ?>//";
    //    }

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

    $(".collapse").collapse();

    function confirmaRecebimento(id, nmrecebedor, datahora) {

        if (nmrecebedor == ''){
            alert('Nome do Recebedor deve Ser Preenchido');
            return false;
        }
        if (datahora == '0000-00-00 00:00:00'){
            alert('Data Hora deve Ser Preenchido');
            return false;
        }

        $.post('<?php echo Router::url(array('plugin' => 'pws','controller' => 'NfsaidaEntregas','action' => 'edit')); ?>/' + id, {
                id: id,
                nmrecebedor: nmrecebedor,
                datahora: datahora
        }, function (o) {
            document.location.reload();
        });
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
