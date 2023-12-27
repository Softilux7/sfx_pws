<div class="span12">
    <h2>
        <?php echo __('Solicitação de Suprimento'); ?>
    </h2>

    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo Router::url(array('plugin' => 'pws','controller' => 'solicitacao','action' => 'index')); ?>">Voltar</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row-fluid">
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

        <?php if ($this->Session->check('Message.flash')) { ?>
            <div class="alert">
                <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <?php echo($this->Session->flash()); ?>
                <br/>
            </div>
        <?php } ?>
        <?php echo $this->Form->create('Solicitacao', array('class' => 'form-horizontal')); ?>
        <div class="row-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Solicitação de Suprimento</h1>
                </div>
                <div class="panel-body" id="container">
                    <div class="row-fluid">
                        <div class="span2">
                            <h1>
                                <small>Nº # <?php echo h($solicitacao['Solicitacao']['id']); ?></small>
                            </h1>
                        </div>
                        <p class="span4 offset6">

                            <strong>Data da Solicitação:</strong> <?php echo h(date('d-m-Y', strtotime($solicitacao['Solicitacao']['created']))); ?>
                            <strong>Hora:</strong> <?php echo h(date('H:i', strtotime($solicitacao['Solicitacao']['created']))); ?>
                            <?php echo $this->Form->input('created', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                            <br>
                            <strong>
                                <?php $options = array('P' => 'Pendente', 'L' => 'Liberada', 'O' => 'Concluída', 'T' => 'Em Trânsito', 'E' => 'Em Análise', 'C' => 'Cancelada/Rejeitada') ?>
                                Status:</strong> <?php echo $this->Form->select('status', $options, array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall', 'empty' => false)); ?>
                        </p>
                    </div>

                    <div class="row-fluid">
                        <p class="span3">
                            <?php echo $this->Form->input('id', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                            <strong>Transportadora:</strong> <?php echo $this->Form->input('transportadora', array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </p>
                    </div>
                    <div class="row-fluid">
                        <p class="span4">
                            <strong>Código de
                                Rastreio:</strong> <?php echo $this->Form->input('cdrastreio', array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </p>
                    </div>
                    <div class="row-fluid">
                        <p class="span4">
                            <strong> Nr Nota
                                Fiscal: </strong> <?php echo $this->Form->input('NRNFSAIDA', array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </p>
                    </div>
                    <div class="row-fluid">
                        <p class="span4 clear">

                            <strong> Data Emissão NF:</strong> <?php
                            if (!empty($solicitacao['Solicitacao']['DTEMISSAONFS'])) {
                                echo h(date('d-m-Y', strtotime($solicitacao['Solicitacao']['DTEMISSAONFS'])));
                            }
                            ?>
                            <?php echo $this->Form->input('DTEMISSAONFS', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'readonly', 'required', 'class' => 'span3')); ?>
                            <?php //echo $this->Form->input('DTEMISSAONFS', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                        </p>
                    </div>
                    <?php if ($auth_user_group['id'] == 1 || $auth_user_group['id'] == 6 || $auth_user_group['id'] == 4) { ?>
                    <div class="row-fluid">
                        <p class="span4 clear">
                            <?php $optionsSituacao = array('R' => 'Recebido', 'E' => 'Em Andamento', 'P' => 'Entregue Parcial', 'T' => 'Entregue Total') ?>
                            <strong>Situação:</strong>
                            <?php echo $this->Form->select('situacao', $optionsSituacao, array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall', 'empty' => false)); ?>
                        </p>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label for="SolicitacaoOBSADMINREVENDA" class="control-label"><strong><?php echo __('Observação:'); ?></strong></label>
                                    <?php echo $this->Form->input('OBSADMINREVENDA', array('type' => 'textarea', 'maxlength' => '80', 'div' => false, 'class' => 'span6', 'label' => false, 'rows' => '6', 'disabled' => false, 'error' => false)); ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row-fluid">
                        <div class="span5">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4>Dados do Cliente</h4>
                                </div>
                                <div class="panel-body">
                                    <p>
                                        <strong>Cliente:</strong> <?php echo h($solicitacao['Cliente']['CDCLIENTE']); ?>
                                        - <?php echo h($solicitacao['Cliente']['NMCLIENTE']); ?> <br>
                                        <?php echo $this->Form->input('Cliente.NMCLIENTE', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                        <?php if (!empty($solicitacao['Equipamento']['ENDERECO'])) { ?>
                                            <strong>Endereço:</strong> <?php echo h($solicitacao['Equipamento']['ENDERECO']); ?>
                                            , <?php echo h($solicitacao['Equipamento']['NUM']); ?><?php echo h($solicitacao['Equipamento']['COMPLEMENTO']); ?>
                                            <br>
                                            <strong>Bairro:</strong> <?php echo h($solicitacao['Equipamento']['BAIRRO']); ?>
                                            <strong>CEP:</strong> <?php echo h($solicitacao['Equipamento']['CEP']); ?>
                                            <br>
                                            <strong>Cidade:</strong> <?php echo h($solicitacao['Equipamento']['CIDADE']); ?>
                                            <strong>UF:</strong> <?php echo h($solicitacao['Equipamento']['UF']); ?>
                                            <br>
                                        <?php } ?>
                                        <strong>Cidade:</strong> <?php echo h($solicitacao['Solicitacao']['cidade']); ?>
                                        <?php echo $this->Form->input('cidade', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                        <strong>Contato:</strong> <?php echo h($solicitacao['Solicitacao']['contato']); ?>
                                        <?php echo $this->Form->input('contato', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                        <strong>Fone:</strong> <?php echo h($solicitacao['Solicitacao']['fone']); ?>
                                        <?php echo $this->Form->input('fone', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                        <br>
                                        <strong>Email:</strong> <?php echo h($solicitacao['Solicitacao']['email']); ?>
                                        <?php echo $this->Form->input('email', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                        <br>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="span5 offset2">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4>Dados do Equipamento</h4>
                                </div>
                                <div class="panel-body">
                                    <p>
                                        <?php if (!empty($solicitacao['Equipamento']['SERIE'])) { ?>
                                            <strong>Série:</strong> <?php echo h($solicitacao['Equipamento']['SERIE']); ?>
                                            <?php echo $this->Form->input('Equipamento.SERIE', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                            <strong>Patrimônio:</strong> <?php echo h($solicitacao['Equipamento']['PATRIMONIO']); ?>
                                            <?php echo $this->Form->input('Equipamento.PATRIMONIO', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                        <?php } ?>

                                        <?php if (!empty($solicitacao['Equipamento']['MODELO'])) { ?>
                                            <strong>Modelo:</strong> <?php echo h($solicitacao['Equipamento']['MODELO']); ?>
                                            <?php echo $this->Form->input('Equipamento.MODELO', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                            <strong>Departamento:</strong> <?php echo h($solicitacao['Equipamento']['DEPARTAMENTO']); ?>
                                            <?php echo $this->Form->input('Equipamento.DEPARTAMENTO', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                            <strong>Local de
                                                Instalação:</strong> <?php echo h($solicitacao['Equipamento']['LOCALINSTAL']); ?>
                                            <?php echo $this->Form->input('Equipamento.LOCALINSTAL', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                        <?php } else { ?>
                                            <strong>Contrato:</strong> <?php echo h($solicitacao['Solicitacao']['contrato_id']); ?>
                                            <?php echo $this->Form->input('Solicitacao.contrato_id', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                            <strong>Modelo:</strong> <?php echo h($solicitacao['Solicitacao']['modelo']); ?>
                                            <?php echo $this->Form->input('Solicitacao.modelo', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                            <strong>Departamento:</strong> <?php echo h($solicitacao['Solicitacao']['departamento']); ?>
                                            <?php echo $this->Form->input('Solicitacao.departamento', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                            <strong>Local de
                                                Instalação:</strong> <?php echo h($solicitacao['Solicitacao']['localinstal']); ?>
                                            <?php echo $this->Form->input('Solicitacao.localinstal', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                            <br>
                                        <?php } ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <strong>Observação Relatada pelo
                                Cliente:</strong> <?php echo h($solicitacao['Solicitacao']['obs']); ?><br>
                        </div>
                    </div>
                    <!-- / end client details section -->
                    <div class="row-fluid">
                        <div class="span12">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h4>Suprimento(s) Solicitado(s)</h4>
                                </div>
                                <div class="panel-body">
                                    <?php foreach ($suprimentos as $key => $suprimentos): ?>

                                        <div class="row-fluid show-grid">
                                            <div class="span12 well">
                                                <div class="row-fluid">
                                                    <div class="span3">
                                                        <div><strong>Suprimento:</strong>&nbsp;
                                                            <?php echo $suprimentos['SuprimentoTipo']['nome_tipo']; ?>
                                                        </div>

                                                    </div>
                                                    <?php echo $this->Form->input("SolicitacaoSuprimento.$key.id", array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                                    <?php echo $this->Form->input("SolicitacaoSuprimento.$key.solicitacao_id", array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                                    <?php echo $this->Form->input("SolicitacaoSuprimento.$key.suprimento_tipo_id", array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                                    <div class="span3">
                                                        <div>
                                                            <strong>Quantidade:</strong>&nbsp;<?php echo $this->Form->input("SolicitacaoSuprimento.$key.quantidade", array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <input type="submit" class="btn btn-primary"
                           value="<?php echo __('Salvar'); ?>"
                           onclick="add_solicitacao();"/>
                    <input type="button"
                           class="btn"
                           value="<?php echo __('Cancelar'); ?>"
                           onclick="<?php echo Router::url(array('plugin' => 'pws','controller' => 'solicitacao','action' => 'index')); ?>"/>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->webroot; ?>datetimepicker/js/jquery.datetimepicker.js"></script>
<link href="<?php echo $this->webroot; ?>datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet">
<script>
    function add_solicitacao() {

        $('#SolicitacaoAddForm').submit(function () {
            $("#container").loadMask("Aguarde...");

        });

    }
    function cancel() {
        window.location = '<?php echo Router::url(array('plugin' => 'Pws', 'controller' => 'Solicitacao', 'action' => 'index')); ?>';
    }

    $(document).ready(function () {


        $('#SolicitacaoDTEMISSAONFS').datetimepicker({
            lang: 'pt',
            mask: true,
            timepicker: false,
            format: 'Y-m-d'
        });
    });

</script>