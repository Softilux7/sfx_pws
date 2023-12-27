<div class="span12">
    <h2>
        <?php echo __('Solicitar suprimento por equipamento'); ?>
    </h2>

    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'solicitacao', 'action' => 'index')); ?>">Voltar</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row-fluid show-grid" id="container">
        <div class="span12">
            <?php if (count($errors) > 0) { ?>
                <div class="alert alert-error">
                    <button data-dismiss="alert" class="close" type="button">Ã—</button>
                    <?php foreach ($errors as $error) { ?>
                        <?php foreach ($error as $er) { ?>
                            <strong><?php echo __('Error!'); ?> </strong>
                            <?php echo h(($er)); ?>
                            <br/>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php echo $this->Form->create('Solicitacao', array('class' => 'form-horizontal')); ?>

            <div class="row-fluid show-grid">
                <legend>Dados do Equipamento</legend>
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Cliente: ')); ?></strong>
                            <?php echo h($cliente[0]['Cliente']['NMCLIENTE']); ?></label>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"> <strong><?php echo(__('Série: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['SERIE']); ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"> <strong><?php echo(__('Modelo: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['MODELO']); ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"> <strong><?php echo(__('Fabricante: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['FABRICANTE']); ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"> <strong><?php echo(__('Produto: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['CDPRODUTO']); ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"> <strong><?php echo(__('Departamento: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['DEPARTAMENTO']); ?></label>
                    </div>
                </div>


                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Endereço: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['ENDERECO'] . ',' . $equip['Equipamento']['NUM']); ?>
                        </label>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Complemento: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['COMPLEMENTO']); ?></label>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Bairro: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['BAIRRO']); ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Cidade: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['CIDADE']); ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Local de Instalação: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['LOCALINSTAL']); ?></label>
                    </div>
                </div>

            </div>
            <div class="row-fluid show-grid">
                <legend><?php echo(__('Dados do Solicitante: ')); ?></legend>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Nome:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('contato', array('div' => false, 'id' => 'contato', 'required', 'label' => false, 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Email:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('email', array('div' => false, 'id' => 'email', 'label' => false, 'required', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>

                <div class="span6">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Fone:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('fone', array('div' => false, 'id' => 'fone', 'label' => false, 'required', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid show-grid">
                <legend><?php echo(__('Dados da Solicitação: ')); ?></legend>
                <div class="span8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <h3><?php echo('Tipo de Suprimento') ?></h3>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Quantidade</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($suprimentos as $key => $suprimento) { ?>
                            <?php if ($suprimento['SuprimentoTipo']['servico'] != 1) { ?>
                                <tr>
                                    <td> <?php echo $this->Form->input("suprimento_tipo_id", array('value' => $suprimento['SuprimentoTipo']['id'], 'id' => "SolicitacaoSuprimentoSuprimentoTipoId$key", 'type' => 'checkbox', 'div' => false, 'label' => false, 'hiddenfield' => false, 'error' => false, 'onClick' => "countChecks($key,this.id)")); ?></td>
                                    <td><?php echo $suprimento['SuprimentoTipo']['nome_tipo']; ?></td>
                                    <td><?php echo $this->Form->input("quantidade", array('div' => false, 'type' => 'number', 'id' => "SolicitacaoSuprimentoQuantidade$key", 'label' => false, 'disabled', 'error' => false)); ?>
                                        <?php echo $this->Form->input("ID_BASE", array('type' => 'hidden', 'div' => false, 'id' => "SolicitacaoSuprimentoID_BASE$key", 'value' => $id_base, 'label' => false, 'error' => false)); ?>
                                    </td>
                                    
                                </tr>
                                <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                        </div>
                        <!--                        <table id="mytablecc" border="0" style="width: 350px" cellpadding="0" cellspacing="0">-->
                        <!--                            <tr id="cc0" style="display:none;">-->
                        <!--                                <td width="65%">--><?php
                        //                                    echo $this->Form->input('unused.suprimento_tipo_id', array('type' => 'select', 'label' => 'Suprimento', 'options' => $suprimentos)); ?><!--</td>-->
                        <!--                                <td>-->
                        <?php //echo $this->Form->input('unused.quantidade', array('type' => 'number', 'label' => 'Valor')); ?><!--</td>-->
                        <!--                                <td><br/>-->
                        <?php //echo $this->Html->image('icons/denied.png', array('alt' => 'Remover')) ?><!--</td>-->
                        <!--                            </tr>-->
                        <!--                            <tr id="trAddcc">-->
                        <!--                                <td colspan="2">-->
                        <!--                                    --><?php //echo $this->Form->button('Adicionar Valor',array('type'=>'button','title'=>'Adicionar Valor','onclick'=>'addCC()'));?>
                        <!--                                </td>-->
                        <!--                            </tr>-->
                        <!--                        </table>-->
                    </div>
                </div>
                <div class="span8">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Observação:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('obs', array('type' => 'textarea', 'div' => false, 'class' => 'span6', 'label' => false, 'rows' => '6', 'cols' => '30', 'required', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>

                <div class="row-fluid show-grid" id="mask">
                    <div class="span6">
                        <input type="submit" class="btn btn-primary"
                               value="<?php echo __('Salvar'); ?>"
                               onclick="add_solicitacao();"/>
                        <input type="button"
                               class="btn"
                               value="<?php echo __('Cancelar'); ?>"
                               onclick="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'solicitacao', 'action' => 'index')); ?>"/>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script>

    function add_solicitacao() {

        $('#SolicitacaoAddForm').submit(function () {
            $("#container").loadMask("Aguarde...");

        });

    }

    function cancel_add() {
        window.location = '<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Solicitacao', 'action' => 'index')); ?>';
    }

    function countChecks(key, id) {
        if (document.getElementById(id).checked == true) {
            $("#SolicitacaoSuprimentoSuprimentoTipoId" + key).attr('name', 'data[SolicitacaoSuprimento][' + key + '][suprimento_tipo_id]');
            $("#SolicitacaoSuprimentoID_BASE" + key).attr('name', 'data[SolicitacaoSuprimento][' + key + '][ID_BASE]');
            $("#SolicitacaoSuprimentoQuantidade" + key).attr('name', 'data[SolicitacaoSuprimento][' + key + '][quantidade]').attr('required', 'true').removeAttr('disabled');
            //alert(key);
        } else {
            $("#SolicitacaoSuprimentoSuprimentoTipoId" + key).attr('name', 'data[Solicitacao][ID_BASE]');
            $("#SolicitacaoSuprimentoID_BASE" + key).attr('name', 'data[Solicitacao][suprimento_tipo_id]');
            $("#SolicitacaoSuprimentoQuantidade" + key).attr('name', 'data[Solicitacao][quantidade]').attr('required', 'false').attr('disabled', 'true');
        }
    }

    //
    //
    //    var lastRowcc=0;
    //    var lastRowpc = 0;
    //
    //        function addCC() {
    //
    //        $("#cc0").clone(true).attr('id','cc'+lastRowcc).removeAttr('style').insertBefore("#trAddcc");
    //        $("#cc"+lastRowcc+" img").attr('onclick','removeCC('+lastRowcc+')');
    //        $("#cc"+lastRowcc+" select").attr('name','data[SolicitacaoSuprimento]['+lastRowcc+'][suprimento_tipo_id]').attr('id','SolicitacaoSuprimentoSuprimentoTipoId'+lastRowcc);
    //        $("#cc"+lastRowcc+" input").attr('name','data[SolicitacaoSuprimento]['+lastRowcc+'][quantidade]').attr('id','SolicitacaoSuprimentoQuantidade'+lastRowcc);
    //
    //        lastRowcc++;
    //
    //    }
    //
    //    function removeCC(id){
    //
    //        $('#cc'+id).remove();
    //        lastRowcc=lastRowcc-1;
    //    }
</script>
