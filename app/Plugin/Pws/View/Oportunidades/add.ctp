<div class="span12">
    <h2>
        <?php echo __('Opotunidade Comercial'); ?>
    </h2>

    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="javascript:window.history.go(-1)">Voltar</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row-fluid show-grid">
        <div class="span12">
            <?php if (count($errors) > 0) { ?>
                <div class="alert alert-error">
                    <button data-dismiss="alert" class="close" type="button">X</button>
                    <?php foreach ($errors as $error) { ?>
                        <?php //foreach ($error as $er) { ?>
                            <strong><?php echo __('Error!'); ?> </strong>
                            <?php echo h(($error)); ?>
                            <br/>
                        <?php// } ?>
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
            <?php echo $this->Form->create('Oportunidade', array('class' => 'form-horizontal')); ?>

            <div class="row-fluid show-grid">
                <legend><?php echo(__('Dados do Solicitante: ')); ?></legend>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Cliente:'); ?> </label>

                        <div class="controls">
                            <?php echo $chamado['Chamado']['NMCLIENTE']; ?>
                            <?php echo $this->Form->input('NMCLIENTE', array('type'=>'hidden','div' => false,'value'=>$chamado['Chamado']['NMCLIENTE'], 'id' => 'nmcliente', '', 'label' => false, 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Técnico:'); ?> </label>

                        <div class="controls">
                            <?php echo $chamado['Chamado']['NMSUPORTET']; ?>
                            <?php echo $this->Form->input('NMSUPORTE', array('type'=>'hidden','div' => false, 'id' => 'contato', '', 'label' => false,'value'=>$chamado['Chamado']['NMSUPORTET'], 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Contato do Cliente:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('CONTATO', array('div' => false, 'id' => 'contato', '', 'label' => false, 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Fone do Cliente:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">

                            <?php echo $this->Form->input('TELEFONE', array('div' => false, 'id' => 'fone', 'label' => false, '', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>
                <div class="span6">

                </div>
            </div>
            <div class="row-fluid show-grid">
                <legend><?php echo(__('Dados da O.S: ')); ?></legend>
                   <div class="span8">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Descrição.:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('DSOPORTUNIDADE', array('type' => 'textarea', 'div' => false, 'label' => false, '', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>

                <div class="row-fluid show-grid">
                    <div class="span6">
                        <input type="submit" class="btn btn-primary"
                               value="<?php echo __('Salvar'); ?>"/> <input type="button"
                                                                                class="btn"
                                                                                value="<?php echo __('Cancelar'); ?>"
                                                                                onclick="javascript:window.history.go(-1)"/>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<script>
    function cancel_add() {
        window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Chamados','action' => 'index')); ?>';
    }
</script>