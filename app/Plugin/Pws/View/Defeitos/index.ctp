<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i class="fa fa-tasks fa-lg"></i> <?php echo __('Lista de Tipo de Defeitos'); ?>
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
                <li>
                    <?php echo $this->Html->link(__('Contratos'), array('controller' => 'Contratos', 'action' => 'index')); ?>
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

    <div class="alert alert-info" role="alert"><i class="fa fa-info" aria-hidden="true"></i> info: Selecione os tipos de defeitos que o cliente poderá visualizar no portal.</div>

    <?php echo $this->Form->create('Defeito', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
    <?php echo $this->Form->end(); ?>
    <div class="row-fluid show-grid">
        <div class="span12">
            <div class="row-fluid show-grid">
                <div class="span12">
                    <div class="btn-group">
                        <a class="btn  btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Ordenação') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Paginator->sort('id','ID'); ?>
                            </li>
                            <li><?php echo $this->Paginator->sort('NMDEFEITO', 'Defeito'); ?>
                            </li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row-fluid show-grid" style="margin-top: 10px;">
                <div class="span12 well">
                    <div class="table-responsive">
                       <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo $this->Paginator->sort('id', '#'); ?></th>
                                    <th><?php echo $this->Paginator->sort('NMDEFEITO', 'Defeito'); ?></th>
                                    <th>Listar no portal</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($defeitos as $defeito): ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'defeito', 'action' => 'view', $defeito['Defeito']['id'])); ?>"><?php echo h($defeito['Defeito']['CDDEFEITO']); ?></a>
                                    </td>
                                    <td><?php echo h($defeito['Defeito']['NMDEFEITO']); ?></td>
                                    <td>
                                        <a href="#"
                                           onclick="changeStatus(this,'<?php echo h($defeito['Defeito']['id']); ?>',0); return false;"
                                           id="status_allowed_<?php echo h($defeito['Defeito']['id']); ?>" <?php if ($defeito['Defeito']['listar'] == 0) { ?> style="display: none;" <?php } ?>>
                                            <img src="<?php echo $this->webroot; ?>img/icons/allowed.png"/>
                                        </a>

                                        <a href="#"
                                           onclick="changeStatus(this,'<?php echo h($defeito['Defeito']['id']); ?>',1); return false;"
                                           id="status_denied_<?php echo h($defeito['Defeito']['id']); ?>" <?php if ($defeito['Defeito']['listar'] == 1) { ?> style="display: none;" <?php } ?>>
                                            <img src="<?php echo $this->webroot; ?>img/icons/denied.png"/>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
        window.location = '<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'defeitos', 'action' => 'index')); ?>';
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

    function changeStatus(obj, user_id, status) {
       // $("#container  table").mask("Aguarde...");
        if (status == undefined) {
            status = 0;
        }
        $.post('<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'defeitos', 'action' => 'changeStatus')); ?>', {
            data: {
                Defeito: {
                    id: user_id,
                    listar: status
                }
            }
        }, function (o) {
            if (status == 0) {
                $('#status_allowed_' + user_id).hide();
                $('#status_denied_' + user_id).show();
            } else {
                $('#status_allowed_' + user_id).show();
                $('#status_denied_' + user_id).hide();
            }
            var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:50px; display: none;">'
                + '<button data-dismiss="alert" class="close" type="button">×</button>'
                + '<strong><?php echo __('Success!'); ?></strong> <?php echo __('Status Alterado com Sucesso'); ?>' + '</div>';
            var alertSuccess = $(strAlertSuccess).appendTo('body');
            alertSuccess.show();

            setTimeout(function () {
                alertSuccess.remove();
            }, 2000);
           // document.location.reload();
        }, 'json');
    }
</script>