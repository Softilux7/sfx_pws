<div class="span12">
    <h2>
        <?php echo __('Chamado Técnico'); ?>
    </h2>

    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">

                    <?php echo $this->Html->link(__('Voltar'), array('controller' => 'Chamados', 'action' => 'index')); ?>
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
        <div class="row-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Chamado Técnico
                        <small class="text-right">Chamado Nº # <?php if ($chamado['Chamado']['SEQOSORIGEM'] == 0) {
                                echo h($chamado['Chamado']['id']) . ' / ' . h($chamado['Chamado']['SEQOS']);
                            } else {
                                echo h($chamado['Chamado']['SEQOSORIGEM']) . ' / ' . h($chamado['Chamado']['SEQOS']);
                            } ?></small>
                    </h1>
                </div>
                <div class="panel-body">
                    <?php echo $this->Form->create('Chamado', array('class' => 'form-horizontal')); ?>
                    <ul class="nav nav-tabs" id="chamados">
                        <li class="active"><a href="#dadosChamado">Dados do Chamado</a></li>
                        <li><a href="#atendimento">Atendimento Técnico</a></li>
                        <li><a href="#solicitarPeca">Solicitar Peça</a></li>
                        <li><a href="#historicos">Históricos</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dadosChamado">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseChamado"
                                                   aria-controls="collapseChamado"> Dados do Chamado</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseChamado">
                                            <div class="panel-body">
                                                <div class="span5">
                                                    <strong>Técnico:</strong> <?php echo h($chamado['Chamado']['NMSUPORTET']); ?>
                                                    <br>
                                                    <strong>Data de
                                                        <?php echo $this->Form->input('id', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                        <?php echo $this->Form->input('OPCAOWEB', array('type' => 'hidden','value'=>'A', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                        <?php echo $this->Form->input('ATUALIZADO', array('type' => 'hidden','value'=>'1', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                        <?php echo $this->Form->input('Atendimento.SEQOS', array('value' => h($chamado['Chamado']['SEQOS']), 'type' => 'hidden', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                        Abertura:</strong> <?php echo h(date('d-m-Y', strtotime($chamado['Chamado']['DTINCLUSAO']))); ?>
                                                    <strong>Hora</strong> <?php echo h($chamado['Chamado']['HRINCLUSAO']); ?>
                                                    <br><strong>Tipo de
                                                        Chamado:</strong> <?php echo h($chamado['ChamadoTipo']['NMOSTP']); ?>
                                                    <br>
                                                    <strong>Defeito:</strong> <?php echo h($chamado['Defeito']['NMDEFEITO']); ?>
                                                    <br>
                                                    <strong>Defeito Relatado pelo
                                                        Cliente:</strong> <?php echo h($chamado['Chamado']['OBSDEFEITOCLI']); ?>
                                                    <br>
                                                </div>
                                                <div class="span5 offset1">
                                                    <?php $options = array('P' => 'Pendente', 'M' => 'Manutenção', 'O' => 'Concluído', 'C' => 'Cancelado') ?>
                                                    <p><strong>
                                                            Status:</strong> <?php echo $this->Form->select('STATUS', $options, array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false)); ?>
                                                    </p>

                                                    <p><strong>Tipo do
                                                            Status: <?php echo $this->Form->select('CDSTATUS', $status, array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'input-xxsmall', 'empty' => false)); ?></strong>
                                                    </p>

                                                    <p><strong>Follow-up do
                                                            Técnico: <?php echo $this->Form->input('OBSDEFEITOATS', array('type' => 'textarea', 'div' => false, 'label' => false, 'required', 'error' => false, 'rows' => '3', 'cols' => '50')); ?></strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseCliente"
                                                   aria-controls="collapseCliente"> Dados do Cliente</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseCliente">
                                            <div class="panel-body">
                                                <p>
                                                    <strong>Cliente:</strong> <?php echo h($chamado['Chamado']['CDCLIENTE']); ?>
                                                    - <?php echo h($chamado['Chamado']['NMCLIENTE']); ?> <br>
                                                    <strong>Endereço:</strong> <?php echo h($chamado['Chamado']['ENDERECO']); ?>
                                                    , <?php echo h($chamado['Chamado']['NUM']); ?>  <?php echo h($chamado['Chamado']['COMPLEMENTO']); ?>
                                                    <br>
                                                    <strong>Bairro:</strong> <?php echo h($chamado['Chamado']['BAIRRO']); ?>
                                                    <strong>CEP:</strong> <?php echo h($chamado['Chamado']['CEP']); ?>
                                                    <br>
                                                    <strong>Cidade:</strong> <?php echo h($chamado['Chamado']['CIDADE']); ?>
                                                    <strong>UF:</strong> <?php echo h($chamado['Chamado']['UF']); ?>
                                                    <br>
                                                    <strong>Contato:</strong> <?php echo h($chamado['Chamado']['CONTATO']); ?>
                                                    <strong>Fone:</strong> <?php echo h($chamado['Chamado']['DDD']); ?> <?php echo h($chamado['Chamado']['FONE']); ?>
                                                    <br>
                                                    <strong>Email:</strong> <?php echo h($chamado['Chamado']['EMAIL']); ?>
                                                    <br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 offset0">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseEquipamento"
                                                   aria-controls="collapseEquipamento"> Dados do Equipamento</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseEquipamento">
                                            <div class="panel-body">
                                                <p>
                                                    <strong>Série:</strong> <?php echo h($chamado['Equipamento']['SERIE']); ?>
                                                    <br>
                                                    <strong>Patrimônio:</strong> <?php echo h($chamado['Equipamento']['PATRIMONIO']); ?>
                                                    <br>
                                                    <strong>Modelo:</strong> <?php echo h($chamado['Equipamento']['MODELO']); ?>
                                                    <br>
                                                    <strong>Departamento:</strong> <?php echo h($chamado['Equipamento']['DEPARTAMENTO']); ?>
                                                    <br>
                                                    <strong>Local de
                                                        Instalação:</strong> <?php echo h($chamado['Equipamento']['LOCALINSTAL']); ?>
                                                    <br>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane" id="historicos">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseAtendimentos"
                                                   aria-controls="collapseAtendimentos"> Histórico de Atendimentos</a>
                                            </h4>
                                        </div>
                                        <div class="collapse in" id="collapseAtendimentos">
                                            <div class="panel-body">
                                                <?php foreach ($atendimentos as $atendimento): ?>
                                                    <?php // echo $atendimento['Atendimento']['DTATENDIMENTO']; ?>

                                                    <div class="row-fluid show-grid">
                                                        <div class="span12 well">
                                                            <div class="row-fluid">
                                                                <div class="span3">
                                                                    <div><strong>Data da Visita:</strong>&nbsp;
                                                                        <?php echo $atendimento['Atendimento']['DTATENDIMENTO']; ?>
                                                                    </div>

                                                                </div>

                                                                <div class="span3">
                                                                    <div>
                                                                        <strong>Hora
                                                                            Inicial:</strong>&nbsp; <?php echo $atendimento['Atendimento']['HRATENDIMENTO']; ?>
                                                                    </div>

                                                                </div>

                                                                <div class="span3">
                                                                    <div>
                                                                        <strong>Hora
                                                                            Final:</strong>&nbsp; <?php echo $atendimento['Atendimento']['HRATENDIMENTOFIN']; ?>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row-fluid">
                                                                <div class="span12">
                                                                    <div>
                                                                        <strong>Descrição da
                                                                            Visita:</strong>&nbsp; <?php echo $atendimento['Atendimento']['OBSERVACAO']; ?>
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
                        </div>
                        <div class="tab-pane" id="atendimento">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseAtendimento"
                                                   aria-controls="collapseAtendimento"> Atendimento Técnico</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseAtendimento">
                                            <div class="panel-body">
                                                <div class="control-group">
                                                    <label class="control-label" for="inputDTATENDIMENTO"> <strong>Data
                                                            Atendimento: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.DTATENDIMENTO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span3')); ?>
                                                        <?php echo $this->Form->input('Atendimento.OPCAOWEB', array('type' => 'hidden','value'=>'I', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputHRATENDIMENTO"> <strong>Hora
                                                            Inicial: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.HRATENDIMENTO', array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span2')); ?>
                                                        <?php echo $this->Form->input('Atendimento.TEMPOATENDIMENTO', array('type'=>'hidden','div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span2')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputHRATENDIMENTO"> <strong>Hora
                                                            Final: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.HRATENDIMENTOFIN', array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span2')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputSINTOMA">
                                                        <strong>Sintoma: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.SINTOMA', array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span6')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputCAUSA">
                                                        <strong>CAUSA: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.CAUSA', array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span6')); ?>
                                                    </div>

                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputACAO">
                                                        <strong>ACAO: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.ACAO', array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span6')); ?>
                                                    </div>

                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputOBSERVACAO"> <strong>OBSERVACAO: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.OBSERVACAO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span6')); ?>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseViagem"
                                                   aria-controls="collapseViagem"> Dados da Viagem</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseViagem">
                                            <div class="panel-body">
                                                <div class="control-group">
                                                    <label class="control-label" for="inputPLACAVEICULO">
                                                        <strong>Placa do Veiculo: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.PLACAVEICULO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span3')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="inputKMINICIAL">
                                                        <strong>Km Inicial: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.KMINICIAL', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span2')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="inputKMINICIAL">
                                                        <strong>Km Final: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.KMFINAL', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span2')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="inputVALATENDIMENTO">
                                                        <strong>Valor Estacionamento: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.VALESTACIONAMENTO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span2')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="inputVALPEDAGIO">
                                                        <strong>Valor Pedágio: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.VALPEDAGIO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span2', 'allowEmpty')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="inputVALOUTRASDESP">
                                                        <strong>Outros Valores: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.VALOUTRASDESP', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span2', 'empty' => true)); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="inputDTVIAGEMINI">
                                                        <strong>Data/Hora inicial da viagem: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.DTVIAGEMINI', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span4')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="inputDTVIAGEMFIN">
                                                        <strong>Data/Hora final da viagem: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.DTVIAGEMFIN', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span4', 'empty' => true)); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="solicitarPeca">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseSolicitarPeca"
                                                   aria-controls="collapseSolicitarPeca"> Solicitação de Peça</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseSolicitarPeca">
                                            <div class="panel-body">
                                                <div class="control-group">
                                                    <label class="control-label" for="inputPRODUTO"> <strong>Produto
                                                            Ficha Técnica: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Peca.CDPRODUTO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span3')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputCDPRODUTO2">
                                                        <strong>Produto: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Peca.CDPRODUTO2', array('div' => false, 'label' => false, 'error' => false,  'class' => 'span3')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputQUANTIDADE"> <strong>Quantidade: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Peca.QUANTIDADE', array('div' => false, 'label' => false, 'error' => false, 'class' => 'span2')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputSTATUS">
                                                        <strong>Status: </strong></label>

                                                    <div class="controls">
                                                        <?php $optionPeca=array('P'=>'Pendente','T'=>'Trocada') ?>
                                                        <?php echo $this->Form->select('Peca.STATUS', $optionPeca, array('div' => false, 'label' => false, 'error' => false,  'class' => 'span6')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputCRITICA">
                                                        <strong>Peça Crítica: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->checkbox('Peca.CRITICA', array('div' => false, 'label' => false, 'error' => false,  'class' => 'span6')); ?>
                                                    </div>

                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputDEVOLUCAO">
                                                        <strong>Necessita Devolução: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->checkbox('Atendimento.DEVOLUCAO', array('div' => false, 'label' => false, 'error' => false, 'class' => 'span6')); ?>
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
                    <input type="submit" class="btn btn-primary"
                           value="<?php echo __('Salvar'); ?>"/>
                    <a class="btn " onclick="cancel_add();"><?php echo __('Voltar'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $this->webroot; ?>datetimepicker/js/jquery.datetimepicker.js"></script>
<link href="<?php echo $this->webroot; ?>datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet">
<script>
    function cancel_add() {
        window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Chamados','action' => 'index')); ?>';
    }
    $('#chamados a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $(document).ready(function () {


        $('#AtendimentoDTATENDIMENTO').datetimepicker({
            lang: 'pt',
            mask: true,
            timepicker: false,
            format: 'Y-m-d'
        });

        $('#AtendimentoDTVIAGEMINI').datetimepicker({
            lang: 'pt',
            mask: true,
            format: 'Y-m-d H:i'
        });

        $('#AtendimentoDTVIAGEMFIN').datetimepicker({
            lang: 'pt',
            mask: true,
            format: 'Y-m-d H:i'


        });
        $('#AtendimentoHRATENDIMENTO').datetimepicker({
            lang: 'pt',
            datepicker: false,
            mask: true,
            format: 'H:i'
        });
        $('#AtendimentoHRATENDIMENTOFIN').datetimepicker({
            lang: 'pt',
            datepicker: false,
            mask: true,
            format: 'H:i'
        });
    });

    $("#AtendimentoPLACAVEICULO").mask("AAA-9999");

    $(function () {
        $("#AtendimentoVALESTACIONAMENTO").maskMoney({thousands: '', decimal: ','});
        $("#AtendimentoKMINICIAL").maskMoney({thousands: '', decimal: ''});
        $("#AtendimentoKMFINAL").maskMoney({thousands: '', decimal: ''});
        $("#AtendimentoVALPEDAGIO").maskMoney({thousands: '', decimal: ','});
        $("#AtendimentoVALOUTRASDESP").maskMoney({thousands: '', decimal: ','});
    });

    $(document).ready(function () {
        if ($('#ChamadoSTATUS').val().length != 0) {
            $.getJSON("<?php echo Router::url(array('plugin' => 'pws','controller' => 'chamados','action' => 'listar_status_json')); ?>", {
                estadoId: $('#ChamadoSTATUS').val()
            }, function (cidades) {
                if (cidades != null)
                    popularListaDeCidades(cidades, $('#ChamadoCDSTATUS').val());
            });
        }
        $('#ChamadoSTATUS').live('change', function () {
            if ($(this).val().length != 0) {
                $.getJSON("<?php echo Router::url(array('plugin' => 'pws','controller' => 'chamados','action' => 'listar_status_json')); ?>", {
                    estadoId: $(this).val()
                }, function (cidades) {
                    if (cidades != null)
                        popularListaDeCidades(cidades);
                });
            } else
                popularListaDeCidades(null);
        });

        $('#AtendimentoDTATENDIMENTO').blur(function () {
            if (!verificarData($(this).val())) {
                document.getElementById('AtendimentoDTATENDIMENTO').value = '';
                $(this).focus();
            }
        });
        $('#AtendimentoHRATENDIMENTOFIN').blur(function () {
            if (!Verifica_Hora($('#AtendimentoHRATENDIMENTO').val(), $(this).val())) {
                // document.getElementById('AtendimentoDTATENDIMENTO').value = '';
                $(this).focus();
                document.getElementById('AtendimentoHRATENDIMENTOFIN').value = '';
            }
        });

    });

    // Verifica data de atendimento
    function verificarData(data) {
        var data = data;
        var inicio = data;
        var fim = '<?php echo h(date('Y-m-d', strtotime($chamado['Chamado']['DTINCLUSAO']))); ?>';

        if (gerarData(fim) > gerarData(inicio)) {
            alert("A data de atendimento é menor  que a data de abertura do chamado");
            return false;
        } else {
            return true;
        }


    }

    function gerarData(str) {
        var partes = str.split("-");
        return new Date(partes[0], partes[1] - 1, partes[2]);
    }


    //verifica hora de atendimento
    function Verifica_Hora(horaIni, horaFim) {

        var h1 = horaIni.split(":");
        var h2 = horaFim.split(":");

        if (h2[0] + h2[1] <= h1[0] + h1[1]) {
            alert("A Hora inicial é maior que a Hora final");
            return false;
        } else {
            return true;
        }
    }


    function popularListaDeCidades(cidades, idCidade) {
        var options = '<option>Selecione uma Status</option>';
        if (cidades != null) {
            $.each(cidades, function (index, cidade) {
                if (idCidade == index)
                    options += '<option selected="selected" value="' + index + '">' + cidade + '</option>';
                else
                    options += '<option value="' + index + '">' + cidade + '</option>';
            });
        }
        $('#ChamadoCDSTATUS').html(options);
    }


</script>