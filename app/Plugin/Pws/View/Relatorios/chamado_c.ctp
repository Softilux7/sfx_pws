<div class="span12" xmlns="http://www.w3.org/1999/html">
    <div class="row-fluid">
        <div class="span12">
            <p>
            <h1 class="page-header"><i class="fa fa-file-text-o fa-lg"></i> <?php echo __('Relatórios'); ?></h1></p>
        </div>
    </div>
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="javascript:window.history.go(-1)">Voltar</a>
                </li>
                <ul>
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
        <div class="span12">
            <div class="row-fluid show-grid">
                <div class="span5 offset4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3><i class="fa fa-check-square-o" aria-hidden="true"></i>
                                Relatório Opções</h3>
                        </div>
                        <div class="panel-body">
                            <form id="relatorioChamado" class="form-horizontal" accept-charset="utf-8" method="post"
                                  action="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'relatorios', 'action' => 'chamado_c_result')); ?>">

                                <?php if ($auth_user_group['id'] != '3') { ?>
                                    <div class="control-group" id="clienteBox">
                                        <label for="inputEmail"
                                               class="control-label"><?php echo __('Cliente:'); ?> </label>

                                        <div class="controls">
                                            <select id="Cliente" class="select2_category form-control"
                                                    name="data[Cliente]">
                                            </select>
                                        </div>
                                        <div class="listaDados"></div>
                                    </div>
                                <?php } else { ?>
                                    <div class="control-group" id="clienteBox">

                                        <div class="controls">
                                            <input type="hidden" name="data[Cliente]" value="<?php echo $auth_user['User']['cliente_id']; ?>" >

                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="control-group" id="equipamentoBox">
                                    <label for="inputEmail"
                                           class="control-label"><?php echo __('Série do Equipamento:'); ?> </label>

                                    <div class="controls">
                                        <?php echo $this->Form->input('SERIE', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false)); ?>
                                    </div>
                                    <div class="listaDados"></div>
                                </div>

                                <?php if ($auth_user_group['id'] == '6' || $auth_user_group['id'] == 1) { ?>
                                    <div class="control-group" id="tecnicoBox">
                                        <label for="inputTecnico"
                                            class="control-label"><?php echo __('Técnico:'); ?><span
                                                style="color: red;"></span> </label>
                                        <div class="controls">
                                            <?php echo $this->Form->select('NMSUPORTET', $arrTecnicos, array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall', 'empty' => 'Todos')); ?>
                                        </div>
                                    </div>
                                <?php }?>

                                <div class="control-group" id="periodoIniBox">
                                    <label for="inputPeriodoIni"
                                           class="control-label"><?php echo __('Período Inicial:'); ?><span
                                            style="color: red;">*</span> </label>

                                    <div class="controls">
                                        <?php echo $this->Form->input('PERIODOINI', array('type' => 'text', 'div' => false, 'autocomplete'=>'off', 'required', 'label' => false, 'error' => false)); ?>
                                    </div>
                                </div>
                                <div class="control-group" id="periodoFimBox">
                                    <label for="inputPeriodoFim"
                                           class="control-label"><?php echo __('Período Final:'); ?><span
                                            style="color: red;">*</span> </label>

                                    <div class="controls">
                                        <?php echo $this->Form->input('PERIODOFIM', array('type' => 'text', 'div' => false, 'autocomplete'=>'off', 'required', 'label' => false, 'error' => false)); ?>
                                    </div>
                                </div>
                                <p>&nbsp; </p>
                        </div>
                        <div class="panel-footer">
                            <p class="text-center">
                                <button type="submit"
                                        class="btn btn-large btn-success "><i class="fa fa-refresh"
                                                                              aria-hidden="true"></i>
                                    &nbsp;Gerar
                                </button>
                            </p>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo $this->webroot; ?>datetimepicker/js/jquery.datetimepicker.js"></script>
<link href="<?php echo $this->webroot; ?>datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet">
<script>
    $("#Cliente").select2({
        placeholder: "Selecionar Cliente",
        language : "pt-BR",
        minimumInputLength: 2,
        ajax: {
            url: "<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'listar_clientes_json')); ?>",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items
                }
            },
            cache: true
        }

    });

    $(document).ready(function () {

        $('#PERIODOINI').datetimepicker({
            lang: 'pt',
            mask: false,
            timepicker: false,
            format: 'd-m-Y'
        });

        $('#PERIODOFIM').datetimepicker({
            lang: 'pt',
            mask: false,
            timepicker: false,
            format: 'd-m-Y'
        });

    });

</script>