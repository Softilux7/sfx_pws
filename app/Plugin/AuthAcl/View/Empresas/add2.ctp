<!-- Novo layout user add-->
<div class="span12">
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <p><a class="btn btn-large " title="Voltar"
                  href="<?php echo Router::url(array('controller' => 'empresas', 'action' => 'index')); ?>"><i
                        class="fa fa-arrow-circle-left"></i> Voltar</a>
            </p>
        </div>
    </div>
    <div class="row-fluid">
        <?php if (count($errors) > 0) { ?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close" type="button">×</button>
                <?php foreach ($errors as $error) { ?>
                    <?php foreach ($error as $er) { ?>
                        <strong><?php echo __('Error!'); ?>
                        </strong>
                        <?php echo h($er); ?>
                        <br/>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="row-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Adicionar Empresa </h1>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('Empresa', array('class' => 'form-horizontal')); ?>
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active"><a href="#dados">Dados da Empresa</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dados">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel-body">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h4>Dados da Empresa</h4>
                                            </div>
                                            <div class="panel-body">
                                                <div
                                                    class="control-group <?php if (array_key_exists('user_email', $errors)) {
                                                        echo 'error';
                                                    } ?>">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Email'); ?><span
                                                            style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('user_email', array('div' => false, 'label' => false, 'error' => false)); ?>
                                                    </div>
                                                </div>
                                                <div
                                                    class="control-group <?php if (array_key_exists('user_password', $errors)) {
                                                        echo 'error';
                                                    } ?>">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Password'); ?><span
                                                            style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->password('user_password', array('div' => false, 'label' => false, 'error' => false)); ?>
                                                    </div>
                                                </div>
                                                <div
                                                    class="control-group <?php if (array_key_exists('user_confirm_password', $errors)) {
                                                        echo 'error';
                                                    } ?>">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Confirm Password'); ?>
                                                        <span
                                                            style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->password('user_confirm_password', array('div' => false, 'label' => false, 'error' => false)); ?>
                                                    </div>
                                                </div>

                                                <div
                                                    class="control-group <?php if (array_key_exists('user_name', $errors)) {
                                                        echo 'error';
                                                    } ?>">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Name'); ?><span
                                                            style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('user_name', array('div' => false, 'label' => false, 'class' => 'input-xlarge', 'error' => false)); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Tipo de Usuário'); ?>
                                                    </label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Group', array('div' => false, 'multiple' => false, 'id' => 'group', 'label' => false, 'onChange' => 'PegarValor()')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group" id="clienteBox">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Cliente'); ?><span
                                                            style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <?php //echo $this->Form->input('Cliente', array('div' => false, 'label' => false, 'empty' => ' ')); ?>
                                                        <select id="Cliente" class="js-example-data-array"
                                                                name="data[Cliente][Cliente][]">
                                                        </select>
                                                    </div>
                                                    <div class="listaDados"></div>
                                                </div>

                                                <div class="control-group" id="tecnicoBox">
                                                    <label for="inputEmail" class="control-label"><?php echo __('Técnico'); ?></label>
                                                    <div class="controls">
                                                        <?php
                                                        echo $this->Form->input ( 'tecnico_id', array (
                                                            'empty' => 'Selecione o Técnico',
                                                            'options' => $tecnicos,
                                                            'id' => 'tecnicos',
                                                            'label' => false,
                                                            'class' => 'select2_category form-control'
                                                        ) );
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="control-group" id="entregadorBox">
                                                    <label for="inputEmail" class="control-label"><?php echo __('Entregadores'); ?></label>
                                                    <div class="controls">
                                                        <?php
                                                        echo $this->Form->input ( 'entregador_id', array (
                                                            'empty' => 'Selecione o Entregador',
                                                            'options' => $entregadores,
                                                            'id' => 'entregador',
                                                            'label' => false,
                                                            'class' => 'select2_category form-control'
                                                        ) );
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php if ($auth_user_group['id']==1){ ?>
                                                    <div class="control-group">
                                                        <label for="inputEmail"
                                                               class="control-label"><?php echo __('Empresa Matriz'); ?><span
                                                                style="color: red;">*</span>
                                                        </label>
                                                        <div class="controls">
                                                            <select id="Empresa" required class="select2_category form-control"
                                                                    name="data[User][empresa_id]">
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } else {

                                                    echo $this->Form->input('empresa_id', array(
                                                        'type' => 'hidden',
                                                        'value' => $auth_user['User']['empresa_id'],
                                                        'id' => 'entregador'
                                                    ));
                                                }
                                                ?>

                                                <div class="control-group">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Empresas Filiais'); ?><span
                                                            style="color: red;">*</span> </label>

                                                    <div class="controls">
                                                        <select id="Filiais" required class="js-example-data-array"
                                                                name="data[Empresa][Empresa][]">
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="control-group">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Ativo'); ?>
                                                    </label>
                                                    <div class="controls">
                                                        <?php echo $this->Form->checkbox('user_status', array('div' => false, 'label' => false,'checked')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group" id="inputEmail" style="display:block;">
                                                    <label for="inputEmail"
                                                           class="control-label"><?php echo __('Recebe email de:'); ?>
                                                    </label>
                                                    <div class="controls">
                                                        <?php echo $this->Form->select('Tpemail', $tpemail, array('multiple' => 'checkbox')); ?>
                                                    </div>
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
                    <input type="submit" class="btn btn-large btn-primary"
                           value="<?php echo __('Salvar Usuário'); ?>"/> <input type="button"
                                                                                class="btn btn-large"
                                                                                value="<?php echo __('Cancelar'); ?>"
                                                                                onclick="cancel_add_user();"/>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    //var data = [{ id: 0, text: 'enhancement' }, { id: 1, text: 'bug' }, { id: 2, text: 'duplicate' }, { id: 3, text: 'invalid' }, { id: 4, text: 'wontfix' }];

    $("#Cliente").select2({
        placeholder: "Selecionar Cliente",
        minimumInputLength: 2,
        multiple: true,
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
                    //alert(data.items)
                    results: data.items
                }
            },
            cache: true
        }

    });

    $("#Empresa").select2({
        placeholder: "Selecionar empresa matriz",
        minimumInputLength: 2,
        // multiple: true,
        ajax: {
            url: "<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'listar_empresas_json')); ?>",
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
                    //alert(data.items)
                    results: data.items
                }
            },
            cache: true
        }

    });

    $("#Filiais").select2({
        placeholder: "Selecionar demais empresas",
        minimumInputLength: 2,
        multiple: true,
        ajax: {
            url: "<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'listar_empresas_json')); ?>",
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
                    //alert(data.items)
                    results: data.items
                }
            },
            cache: true
        }

    });

    $('#Cliente').on("select2:unselect", function (e) {
        var id = e.params.data.id;
        $("#Cliente option[value='" + id + "']").remove();
    }).trigger('change');

    $('#Empresa').on("select2:unselect", function (e) {
        var id = e.params.data.id;
        $("#Empresa option[value='" + id + "']").remove();
    }).trigger('change');


    function cancel_add_user() {
        window.location = '<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'index')); ?>';
    }
    $(document).ready(function () {
        $('#myTab a').click(function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
        PegarValor();
    });
    function PegarValor() {
        if (document.getElementById('group').value == "1") { // Admin
            document.getElementById('entregadorBox').style.display = "block";
            document.getElementById('clienteBox').style.display = "block";
            document.getElementById('tecnicoBox').style.display = "block";
            document.getElementById('inputEmail').style.display = "block";
        }
        if (document.getElementById('group').value == "2") { // Tecnico
            document.getElementById('entregadorBox').style.display = "none";
            document.getElementById('clienteBox').style.display = "block";
            document.getElementById('tecnicoBox').style.display = "block";
            document.getElementById('inputEmail').style.display = "block";
        }
        if (document.getElementById('group').value == "3") { // Cliente
            document.getElementById('entregadorBox').style.display = "none";
            document.getElementById('clienteBox').style.display = "block";
            document.getElementById('tecnicoBox').style.display = "block";
            document.getElementById('inputEmail').style.display = "none";
        }
        if (document.getElementById('group').value == "4") { // operador suprimentos
            document.getElementById('entregadorBox').style.display = "none";
            document.getElementById('clienteBox').style.display = "block";
            document.getElementById('tecnicoBox').style.display = "block";
            document.getElementById('inputEmail').style.display = "block";
        }
        if (document.getElementById('group').value == "5") { // Entregadores
            document.getElementById('entregadorBox').style.display = "block";
            document.getElementById('clienteBox').style.display = "none";
            document.getElementById('tecnicoBox').style.display = "none";
            document.getElementById('inputEmail').style.display = "none";
        }
    }

</script>
