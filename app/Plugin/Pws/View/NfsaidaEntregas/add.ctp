<div class="span12">
    <h2>
        <?php echo __('Entregas Pendentes'); ?>
    </h2>

    <div class="row-fluid show-grid">
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
            <?php echo $this->Form->create('Chamado', array('class' => 'form-horizontal')); ?>

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
                        <label class="control-label"><strong><?php echo(__('Locação de Instalação: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['LOCALINSTAL']); ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Prioridade Atendimento: ')); ?></strong>
                            <?php echo h($equip['Equipamento']['TEMPOATENDIMENTO']) . ' Horas'; ?></label>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Considera Dias Úteis: ')); ?></strong>
                            <?php if ($equip ['Equipamento'] ['TFDIASUTEIS'] == 'S') {
                                echo 'SIM';
                            } else {
                                echo(__('NÃO'));
                            } ?></label>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <label class="control-label"><strong><?php echo(__('Considera Horas Úteis: ')); ?></strong>
                            <?php

                            if ($equip ['Equipamento'] ['TFHORASUTEIS'] == 'S') {
                                echo 'SIM';
                            } else {
                                echo(__('NÃO'));
                            }
                            ?></label>
                    </div>
                </div>

                <div class="span4">
                    <div class="control-group">
                        <label
                            class="control-label"><strong><?php echo(__('Previsão Atendimento: ')); ?></strong></label><label
                            class="control-label"><span class="text-info">
				<strong>
                    <?php
                    echo date('d-m-Y', strtotime($this->request->data('Chamado.DTPREVENTREGA'))) . ' - ' . $this->request->data('Chamado.HRPREVENTREGA');

                    ?>
                </strong>
				</span>
                        </label>
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
                            <?php echo $this->Form->input('CONTATO', array('div' => false, 'id' => 'contato', 'required', 'label' => false, 'disabled' => false, 'error' => false)); ?>
                            <?php echo $this->Form->input('OPCAOWEB', array('type' => 'hidden','value'=>'I', 'div' => false, 'label' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>
                <div class="span5">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Email:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('EMAIL', array('div' => false, 'id' => 'email', 'label' => false, 'required', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>

                <div class="span6">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Fone:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('DDD', array('div' => false, 'id' => 'ddd', 'label' => false, 'required', 'disabled' => false, 'error' => false, 'class' => 'input-small')); ?>
                            <?php echo $this->Form->input('FONE', array('div' => false, 'id' => 'fone', 'label' => false, 'required', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid show-grid">
                <legend><?php echo(__('Dados da O.S: ')); ?></legend>
                <div class="span8">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Tipo de Defeito:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php
                            // echo $this->Form->input('cddefeito',array('div' => false,'id'=>'cep','label'=>false,'disabled'=>false,'error'=>false));
                            echo $this->Form->select('CDDEFEITO', $defeitos, array(
                                'empty' => '(Selecione)',
                                'required',
                                'label' => false
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="span8">
                    <div class="control-group">
                        <label class="control-label"><?php echo __('Obs.:'); ?><span
                                style="color: red;">*</span> </label>

                        <div class="controls">
                            <?php echo $this->Form->input('OBSDEFEITOCLI', array('type' => 'textarea', 'div' => false, 'label' => false, 'required', 'disabled' => false, 'error' => false)); ?>
                        </div>
                    </div>
                </div>

                <div class="row-fluid show-grid">
                    <div class="span6">
                        <input type="submit" class="btn btn-primary"
                               value="<?php echo __('Salvar'); ?>"/> <input type="button"
                                                                                class="btn"
                                                                                value="<?php echo __('Cancelar'); ?>"
                                                                                onclick="cancel_add();"/>
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