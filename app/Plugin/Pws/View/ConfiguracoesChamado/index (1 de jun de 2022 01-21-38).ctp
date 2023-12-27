<div class="span12">
    <div class="row-fluid">
        <?php if (count($errors) > 0) { ?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <?php foreach ($errors as $error) { ?>
                    <?php foreach ($error as $er) { ?>
                        <strong><?php echo __('ERRO!'); ?>
                        </strong>
                        <?php echo h($er); ?>
                        <br/>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($this->Session->check('Message.flash')) { ?>
            <div class="alert">
                <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <?php echo($this->Session->flash()); ?>
                <br/>
            </div>
        <?php } ?>

        <div class="row-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Configuração do chamado </h1>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('ConfiguracoesChamado', array('class' => 'form-horizontal')); ?>
                    <? echo $this->Form->input('reset', array('type' => 'hidden','value'=>0)); ?>
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#dados">Status padrão de abertura</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dados">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel-body">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h4>Status padrão de abertura ( <?php echo $_empresa['Empresa']['empresa_fantasia'] ?> )</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div class="control-group">
                                                    <label for="inputStatus" class="control-label"><strong><?php echo __('Status:'); ?></strong><span style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->select('status_padrao_abertura_chamado', $status_chamado, array('div' => false, 'required'=>true, 'label' => false, 'required', 'error' => false, 'class' => 'input-xlarge', 'empty' => false)); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label for="inputCdStatus" class="control-label"><strong><?php echo __('Tipo do Status:'); ?></strong><span style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->select('cd_status_abertura_chamado', $_cd_status, array('div' => false, 'required'=>true, 'label' => false, 'error' => false, 'required'=>true, 'class' => 'input-xxlarge', 'empty' => false)); ?></strong>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                <div style="margin-left:160px"><input type="button" id="reset_config" class="btn btn-large btn-danger" value="<?php echo __('voltar configuração padrão'); ?>" /></div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <input type="submit" class="btn btn-large btn-primary" value="<?php echo __('Atualizar'); ?>" />
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {

        $( "#reset_config" ).click(function() {
            if(confirm('Deseja voltar a configuração padrão?')){
                const reset = $('#ConfiguracoesChamadoReset').val();
                // seta o hidden de reset
                $('#ConfiguracoesChamadoReset').val(reset == 0 ? 1 : 0);

                $('#ConfiguracoesChamadoIndexForm').submit();
            }
        })


        if ($('#ConfiguracoesChamadoStatusPadraoAberturaChamado').val().length != 0) {
            $.getJSON("<?php echo Router::url(array('plugin' => 'pws','controller' => 'chamados','action' => 'listar_status_json')); ?>", {
                estadoId: $('#ConfiguracoesChamadoStatusPadraoAberturaChamado').val()
            }, function (cidades) {
                if (cidades != null)
                    popularStatus(cidades, $('#ConfiguracoesChamadoCdStatusAberturaChamado').val());
            });
        }

        $('#ConfiguracoesChamadoStatusPadraoAberturaChamado').live('change', function () {
            if ($(this).val().length != 0) {
                $.getJSON("<?php echo Router::url(array('plugin' => 'pws','controller' => 'chamados','action' => 'listar_status_json')); ?>", {
                    estadoId: $(this).val()
                }, function (cidades) {
                    if (cidades != null)
                        popularStatus(cidades);
                });
            } else
                popularStatus(null);
        });

        function popularStatus(cidades, idCdStatus) {
            var options = '<option value="">Selecione um Status</option>';
            if (cidades != null) {
                $.each(cidades, function (index, cdstatus) {
                    if (idCdStatus == index)
                        options += '<option selected="selected" value="' + index + '">' + cdstatus + '</option>';
                    else
                        options += '<option value="' + index + '">' + cdstatus + '</option>';
                });
                $('#ConfiguracoesChamadoCdStatusAberturaChamado').html(options);
            }
        }

    });
</script>
