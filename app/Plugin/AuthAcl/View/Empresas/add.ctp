<div class="span12">
    <h2>
        <?php echo __('Empresas (Add)'); ?>
    </h2>
    <div class="row-fluid show-grid" id="tab_empresa">
        <div class="span12">
            <p><a class="btn btn-large " title="Voltar"
                  href="<?php echo Router::url(array('controller' => 'empresas', 'action' => 'index')); ?>"><i
                        class="fa fa-arrow-circle-left"></i> Voltar</a>
            </p>
        </div>
    </div>

    <div class="row-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>Adicionar Empresa </h1>
            </div>
            <div class="panel-body">
                <?php if (count($errors) > 0) { ?>
                    <div class="alert alert-error">
                        <button data-dismiss="alert" class="close" type="button">×</button>
                        <?php foreach ($errors as $error) { ?>
                            <?php foreach ($error as $er) { ?>
                                <strong><?php echo __('Error!'); ?> </strong>
                                <?php echo utf8_encode($er); ?>
                                <br/>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } ?>


                <?php echo $this->Form->create('Empresa', array('class' => 'form-horizontal','enctype' => 'multipart/form-data')); ?>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo (__('Razão Social')); ?><span
                                style="color: red;">*</span> </label>
                        <div class="controls">
                            <?php echo $this->Form->input('empresa_nome', array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Fantasia'); ?><span
                                style="color: red;">*</span> </label>
                        <div class="controls">
                            <?php echo $this->Form->input('empresa_fantasia', array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('CNPJ'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('cnpj', array('div' => false, 'id' => 'cnpj', 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('IE'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('ie', array('div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Contato'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('contato', array('div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Email'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('email', array('div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>


                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Fone'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('ddd', array('div' => false, 'id' => 'ddd', 'type' => 'text', 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-small')); ?>
                            <?php echo $this->Form->input('fone', array('div' => false, 'id' => 'fone', 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>
                <div class=" "></div>
                <div class=" "></div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo (__('Endereço')); ?><span
                                style="color: red;">*</span> </label>
                        <div class="controls">
                            <?php echo $this->Form->input('endereco', array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                            <?php echo $this->Form->input('numero', array('div' => false, 'id' => 'numero', 'type' => 'text', 'label' => false, 'error' => false, 'class' => 'input-small')); ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Complemento'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('complemento', array('div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('CEP'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('cep', array('div' => false, 'id' => 'cep', 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-small')); ?>
                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Bairro'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('bairro', array('div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <?php
                            echo $this->Form->input('uf', array(
                                'empty' => 'Selecione um estado',
                                'options' => $estados,
                                'id' => 'estados',
                                'label' => false,
                                'class' => 'select2_category form-control'
                            ));
                            ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label">Cidades</label>
                        <div class="controls">
                            <?php
                            echo $this->Form->input('cidade_id', array(
                                'id' => 'cidades',
                                'label' => False,
                                // 'multiple' => "multiple",
                                'style' => "width: 200px",
                                'class' => "chosen  "
                            ));
                            ?>
                        </div>
                    </div>
                </div>

                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('ID BASE (id empresa matriz)'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('matriz_id', array('type'=>'text','div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Caminho Logo'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('logo', array('type'=>'file','div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Licença'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('ch', array('type'=>'text','div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Key'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php echo $this->Form->input('sync_key', array('type'=>'text','div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </div>
                    </div>
                </div>
                <div class=" ">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Fuso Horário'); ?><span
                                style="color: red;">*</span>
                        </label>
                        <div class="controls">
                            <?php
                            $fuso = array(
                                'America/Sao_Paulo' => 'America/Sao_Paulo',
                                'America/Bahia' => 'America/Bahia',
                                'America/Campo_Grande' => 'America/Campo_Grande',
                                'America/Cuiaba' => 'America/Cuiaba',
                                'America/Fortaleza' => 'America/Fortaleza',
                                'America/Manaus' => 'America/Manaus',
                                'America/Recife' => 'America/Recife',
                            );
                            ?>
                            <?php echo $this->Form->select('fuso_horario',$fuso, array('div' => false, 'label' => false, 'disabled' => false, 'error' => false, 'class' => 'input-xxsmall', 'empyt'=>'America/Sao_Paulo' )); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-footer">

                    <input type="submit" class="btn btn-primary"
                           value="<?php echo __('Salvar Empresa'); ?>"/>
                    <input type="button"
                                                                                class="btn"
                                                                                value="<?php echo __('Cancelar'); ?>"
                                                                                onclick="cancel_add();"/>

            </div>
        </div>


        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script>

    function cancel_add() {
        window.location = '<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'empresas', 'action' => 'index')); ?>';
    }

    function desactiva(obj) {

        nForm = document.forms['ClienteAddForm'];

        if (obj.checked) {
            nForm.elements['ClienteCpf'].disabled = false;
            nForm.elements['ClienteCnpj'].disabled = true;
        } else {
            nForm.elements['ClienteCpf'].disabled = true;
            nForm.elements['ClienteCnpj'].disabled = false;
        }
    }

    $(document).ready(function () {
        if ($('#estados').val().length != 0) {
            $.getJSON("<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'empresas', 'action' => 'listar_cidades_json')); ?>", {
                estadoId: $('#estados').val()
            }, function (cidades) {
                if (cidades != null)
                    popularListaDeCidades(cidades, $('#id-cidade').val());
            });
        }
        $('#estados').live('change', function () {
            if ($(this).val().length != 0) {
                $.getJSON("<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'empresas', 'action' => 'listar_cidades_json')); ?>", {
                    estadoId: $(this).val()
                }, function (cidades) {
                    if (cidades != null)
                        popularListaDeCidades(cidades);
                });
            } else
                popularListaDeCidades(null);
        });

        $("#cnpj").mask("99.999.999/9999-99");
        $("#ddd").mask("99");
        $("#fone").mask("9999-9999");
        $("#cep").mask("99999-999");
        $('#numero').mask('00000000000', {optional: true});

    });


    function popularListaDeCidades(cidades, idCidade) {
        var options = '<option>Selecione uma Cidade</option>';
        if (cidades != null) {
            $.each(cidades, function (index, cidade) {
                if (idCidade == index)
                    options += '<option selected="selected" value="' + index + '">' + cidade + '</option>';
                else
                    options += '<option value="' + index + '">' + cidade + '</option>';
            });
        }
        $('#cidades').html(options);
    }

</script>
