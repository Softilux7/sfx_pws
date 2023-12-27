

<div class="span12">
    <h2>
        <?php echo __('Chamado Técnico'); ?>
    </h2>

    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">
                    <a href="<?php echo Router::url(array('plugin' => 'pws','controller' => 'Chamados','action' => 'index')); ?>">Voltar</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row-fluid">
        <?php if (count($errors) > 0) { ?>
            <div class="alert alert-error">
                <button data-dismiss="alert" class="close" type="button">X</button>
                <?php foreach ($errors as $key => $error) { ?>
                    <strong><?php echo __('Erro!: ') . $error; ?> </strong>
                        <br/>
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
                        <small class="text-right">Chamado Nº # <?php
                                echo h($chamado['Chamado']['id']) . ' / ' . h($chamado['Chamado']['SEQOS']);
                            ?></small>
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
                    <?php echo $this->Html->link((__('Imprimir O.S')), array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'printPdf', $chamado['Chamado']['id'],Security::hash($chamado['Chamado']['id'].$_SESSION['Auth']['User']['empresa_id']))); ?>
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
                                                    <p>
                                                        <strong>Visita: </strong>
                                                        <?php echo $this->Form->checkbox('TFVISITA', array('div' => false, 'checked' =>'checked', 'disabled' => 'disabled',  'label' => false, 'error' => false,  'class' => 'span2')); ?>
                                                    </p>
                                                    <strong>Técnico:</strong> <?php echo h($chamado['Chamado']['NMSUPORTET']); ?>
                                                    <br>
                                                    <strong>Data de
                                                        <?php echo $this->Form->input('id', array('type' => 'hidden', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                        <?php echo $this->Form->input('ATUALIZADO', array('type' => 'hidden','value'=>'2', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                        <?php echo $this->Form->input('Atendimento.SEQOS', array('value' => h($chamado['Chamado']['SEQOS']), 'type' => 'hidden', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                        Abertura:</strong> <?php echo h(date('d-m-Y', strtotime($chamado['Chamado']['DTINCLUSAO']))); ?>
                                                    <strong>Hora</strong> <?php echo h($chamado['Chamado']['HRINCLUSAO']); ?>
                                                    <?php if (isset($chamado['Chamado']['TIPO_OS']) && $chamado['Chamado']['TIPO_OS'] !== '') { ?>
                                                        <br><strong>Modalidade:</strong>
                                                        <?php
                                                            switch ($chamado['Chamado']['TIPO_OS']) {
                                                                case '0':
                                                                    echo "Suprimento";
                                                                    break;
                                                                case '1':
                                                                    echo "Assistência/Chamado Técnico";
                                                                    break;
                                                                case '2':
                                                                    echo "Solicitação (Retirada/Instalação/Outros)";
                                                                    break;
                                                            }
                                                        ?>
                                                    <?php } ?>
                                                    <br><strong>Tipo de Chamado:</strong> <?php echo h($chamado['ChamadoTipo']['NMOSTP']); ?>
                                                    <br><strong>Defeito:</strong> <?php echo h($chamado['Defeito']['NMDEFEITO']); ?>
                                                    <br>
                                                    <strong>Defeito Relatado pelo
                                                        Cliente:</strong> <?php echo h($chamado['Chamado']['OBSDEFEITOCLI']); ?>
                                                    <br>
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
                                                    <div>
                                                        <p>
                                                            <label class="control-label">
                                                                <strong>Status:<span style="color: red;">*</span></strong>
                                                            </label>
                                                            <div class="controls">
                                                                 <?php echo $this->Form->select('STATUS', $chamado_status, array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false)); ?>
                                                            </div>
                                                        </p>
                                                    </div>
                                                    <p>
                                                        <label class="control-label">
                                                            <strong>Tipo do Status:<span style="color: red;">*</span></strong> 
                                                        </label>
                                                        <div class="controls">
                                                            <?php echo $this->Form->select('CDSTATUS', $status, array('div' => false, 'label' => false, 'error' => false, 'required'=>true, 'class' => 'span8', 'empty' => false)); ?>
                                                        </div>
                                                    </p>
                                                    <p>
                                                        <label class="control-label">
                                                            <strong>Follow-up do Técnico:</strong>
                                                        </label>
                                                        <div class="controls">
                                                            <?php echo $this->Form->input('OBSDEFEITOATS_OLD', array('value'=> $chamado['Chamado']['OBSDEFEITOATS'], 'type' => 'textarea', 'div' => false, 'label' => false, 'required', 'error' => false, 'rows' => '3', 'cols' => '50', 'disabled' => true)); ?>
                                                            <?php echo $this->Form->input('OBSDEFEITOATS', array('type' => 'hidden', 'div' => false, 'label' => false, 'required', 'error' => false)); ?>
                                                        </div>
                                                    </p>
                                                    <p>
                                                        <label class="control-label">
                                                            <strong>Follow-up do Técnico:<span style="color: red;">*</span> </strong>
                                                        </label>
                                                        <div class="controls">
                                                            <?php echo $this->Form->input('OBSDEFEITOATS_NEW', array('type' => 'textarea', 'div' => false, 'label' => false, 'required', 'error' => false, 'rows' => '3', 'cols' => '50')); ?>
                                                        </div>
                                                    </p>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputDTATENDIMENTO"> <strong>Data de fechamento</strong></label>
                                                    <div class="controls" style="color:#666">
                                                        <?php echo date("d/m/Y") ?>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputDTATENDIMENTO"> <strong>Data
                                                            Atendimento:<span
                                                                style="color: red;">*</span> </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.DTATENDIMENTO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span3')); ?>
                                                        <?php echo $this->Form->input('Atendimento.ATUALIZADO', array('type' => 'hidden','value'=>'1', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputHRATENDIMENTO"> <strong>Hora
                                                            Inicial:<span
                                                                style="color: red;">*</span> </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.HRATENDIMENTO', array('div' => false, 'label' => false, 'type'=>'text','error' => false, 'required', 'class' => 'span2')); ?>
                                                        <?php echo $this->Form->input('Atendimento.TEMPOATENDIMENTO', array('type'=>'hidden','div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span2')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputHRATENDIMENTO"> <strong>Hora
                                                            Final:<span
                                                                style="color: red;">*</span> </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.HRATENDIMENTOFIN', array('div' => false, 'type'=>'text','label' => false, 'error' => false, 'required', 'class' => 'span2')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputSINTOMA">
                                                        <strong>Sintoma:<span
                                                                style="color: red;">*</span> </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.SINTOMA', array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span6')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputCAUSA">
                                                        <strong>CAUSA:<span
                                                                style="color: red;">*</span> </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.CAUSA', array('div' => false, 'label' => false, 'error' => false, 'required', 'class' => 'span6')); ?>
                                                    </div>

                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputACAO">
                                                        <strong>ACAO:<span
                                                                style="color: red;">*</span> </strong></label>

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
                                                <div class="control-group">

                                                    <label class="control-label" for="inputCDMDIDOR"> <strong>Medidor: <span
                                                                style="color: red;">*</span> </strong></strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->select('Atendimento.CDMEDIDOR', $medidores, array('div' => false, 'label' => false, 'error' => false, 'class' => 'input-xxsmall','empty' => '(Selecione o Medidor)')); ?>
                                                    </div>


                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputMEDIDOR"> <strong>Valor Medidor: <span
                                                                style="color: red;">*</span> </strong></strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.MEDIDOR', array('type' => 'text', 'div' => false, 'label' => false, 'value'=>'0', 'error' => false, 'class' => 'input-xxsmall')); ?>
                                                    </div>


                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputMEDIDORDESC"> <strong>Cópias Descontadas: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Atendimento.MEDIDORDESC', array('type' => 'text', 'div' => false,'value'=>'0','label' => false, 'error' => false, 'class' => 'input-xxsmall')); ?>
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

                                                <?php if($auth_user['User']['tecnico_terceirizado'] == true){ ?>

                                                    <div class="control-group">
                                                        <label class="control-label" for="inputVALATENDIMENTO">
                                                            <strong>Valor Atendimento: </strong></label>

                                                        <div class="controls" >
                                                            <?php echo $this->Form->input('Atendimento.VALATENDIMENTO', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span2')); ?>
                                                            <?php if(count($detailLastService) > 0){?>
                                                                <div style="color:#666;height:10px">
                                                                    <em>(R$ <b><?php echo number_format($detailLastService['VALATENDIMENTO'],  2, ',', '.'); ?></b> *valor do último atendimento)</em>
                                                                </div>
                                                            <?php }?>
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label" for="inputVALKM">
                                                            <strong>Valor Deslocamento: </strong></label>
                                                        <div class="controls">
                                                            <?php echo $this->Form->input('Atendimento.VALKM', array('type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'class' => 'span2')); ?>
                                                            <?php if(count($detailLastService) > 0){?>
                                                                <div style="color:#666;height:10px">
                                                                    <em>(R$ <b><?php echo number_format($detailLastService['VALKM'],  2, ',', '.');  ?> </b>*valor do último deslocamento)</em>
                                                                </div>
                                                            <?php }?>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <div class="control-group">
                                                    <label class="control-label" for="inputVALESTACIONAMENTO">
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
                            <div class="row-fluid" id="formularioPecas">
                                <div class="span6">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <div class="row-fluid">
                                                <div class="span6">
                                                    <h4> Solicitação de Peça </h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="collapseSolicitarPeca">
                                            <div class="panel-body">
                                                <div class="control-group">
                                                    <label class="control-label" for="ftecit"> <strong>Produto Ficha Técnica: </strong></label>
                                                    <div class="controls">
                                                        <select id="ftecit" class="span6" name="data[Peca][CDPRODUTO]">
                                                            <option value=''> Selecione um produto</option>
                                                            <?php

                                                            foreach ($produto_ftecIt as $mod) {
                                                                echo "<option value='" . $mod['f']['CDPRODUTO'] . "'>" . $mod[0]['NMPRODUTO'] . "</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputCDPRODUTO2">
                                                        <strong>Produto: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Peca.CDPRODUTO2', array('div' => false, 'label' => false, 'error' => false,  'class' => 'span6')); ?>
                                                    </div>
                                                </div>

                                                <div class="control-group ">
                                                    <label class="control-label" for="inputQUANTIDADE"> <strong>Quantidade: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->input('Peca.QUANTIDADE', array('div' => false, 'label' => false, 'error' => false, 'class' => 'span6')); ?>
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
                                                        <?php echo $this->Form->checkbox('Peca.CRITICA', array('div' => false, 'label' => false, 'error' => false,  'class' => 'span2')); ?>
                                                    </div>

                                                </div>
                                                <div class="control-group">

                                                    <label class="control-label" for="inputDEVOLUCAO">
                                                        <strong>Necessita Devolução: </strong></label>

                                                    <div class="controls">
                                                        <?php echo $this->Form->checkbox('Atendimento.DEVOLUCAO', array('div' => false, 'label' => false, 'error' => false, 'class' => 'span2')); ?>
                                                    </div>
                                                </div>
                                                <div class="control-group text-right" id="btn_control_pecas">
                                                    <button type="button" class="btn btn-warning btn-lg" onclick="adicionarMaisPecas();"><i class="fa fa-plus-circle"></i> Adicionar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6" id="colocaAqui">
                                </div>
                            </div>
                            <div class="row-fluid hide" id="tabela">
                                <div class="span6">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped" id="tabelaAqui">
                                            <thead>
                                                <tr>
                                                    <th>Produto Ficha Técnica</th>
                                                    <th>Produto</th>
                                                    <th>Quantidade</th>
                                                    <th>Status</th>
                                                    <th>Peça Critica</th>
                                                    <th>Necessita Devolução</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div>
                        <div style="float: left;padding-right:5px">
                            <input id="buttonSubmit" type="submit" class="btn btn-primary" value="<?php echo __('Salvar'); ?>"/>
                        </div>
                        <div style="float: left">
                            <input onclick="window.history.go(-1)" class="btn" value="<?php echo __('Voltar'); ?>"/>
                        </div>
                        <div style="clear:both"></div>
                    </div>
                    <?php
                    if($chamado['Chamado']['STATUS'] == 'E' or $chamado['Chamado']['STATUS'] == 'A'){
                        echo $this->Form->input('cancelChamado', array('type' => 'hidden','value'=>'0', 'div' => false, 'label' => false, 'error' => false));
                        array_unshift($statusCancelamento, '--- SELECIONE ---');
                    ?>
                        
                        <input class="btn" id="buttonCancelChamado" value="<?php echo __('Cancelar chamado'); ?>"/>
                    <?php
                    }
                    ?>
                    
                </div>
                <div id="divStatusCancelamento" style="padding:10px 5px 5px 15px; display: none">
                    <p>
                        <strong>Status cancelamento:<span style="color: red;">*</span> <?php echo $this->Form->select('formStatusCancelamento', $statusCancelamento, array('div' => false, 'label' => false, 'error' => false, 'required'=>true, 'class' => 'span8', 'empty' => false)); ?></strong>
                    </p>
                    <p style="padding:0px 0px 0px 160px;">
                        <input class="btn btn-primary" id="buttonCancelChamadoButton" value="<?php echo __('Confirmar cancelamento'); ?>"/>
                        <input class="btn" id="buttonCancelDivCancel" value="<?php echo __('Não quero mais cancelar'); ?>"/>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="hide" id="numPecas">0</div>

<script src="<?php echo $this->webroot; ?>datetimepicker/js/jquery.datetimepicker.js"></script>
<link href="<?php echo $this->webroot; ?>datetimepicker/css/jquery.datetimepicker.css" rel="stylesheet">
<script>
    
    
    function cancelChamado(){
        
        $('#buttonCancelChamado').click(function(){
            
            $('#divStatusCancelamento').css('display', 'block');
            $('#buttonSubmit').css('display', 'none');
            
            $('#ChamadoCancelChamado').val(1);
            
        });
        
        $("#buttonCancelDivCancel").on('click', function(e){
            
            $('#divStatusCancelamento').css('display', 'none');
            $('#buttonSubmit').css('display', 'block');
            
            $('#ChamadoCancelChamado').val(0);
            
        });
        
        $('#buttonCancelChamadoButton').click(function(){
           
            if(confirm('Confirmar o cancelamento do chamado?') == true){
                
                var idStatus = $('#ChamadoFormStatusCancelamento').val();
                
                if(idStatus != 0){
                    
                    $.ajax({
                        
                        type  : "post",
                        url     : '<?php echo Router::url(array('plugin' => 'pws','controller' => 'Chamados','action' => 'edit')); ?>/<?php echo $chamado['Chamado']['id']; ?>',
                        data    : { idChamado: '<?php echo $chamado['Chamado']['id']; ?>', idCancelamento: idStatus }
                
                    }).done(function(result){
                        
                        window.location = '<?php echo Router::url(array('plugin' => 'pws','controller' => 'Chamados','action' => 'index')); ?>';
                        
                    })
                    
                    
                }else{
                    
                    alert('Selecione o status do cancelamento');
                    
                }
                
            }
            
        })
         
    }
    
    cancelChamado();
    
    
    
    function cancel_add() {
        window.location = '<?php echo Router::url(array('plugin' => 'pws','controller' => 'Chamados','action' => 'index')); ?>';
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

        // $('#AtendimentoDTVIAGEMINI').datetimepicker({
        //     lang: 'pt',
        //     mask: true,
        //     format: 'Y-m-d H:i'
        // });

        // $('#AtendimentoDTVIAGEMFIN').datetimepicker({
        //          lang: 'pt',
        //          mask: true,
        //          format: 'Y-m-d H:i'
        // });

        // $('#AtendimentoDTVIAGEMFIN').inputmask("datetime",{
        //     mask: "y-1-2 h:s",
        //     placeholder: "yyyy-mm-dd hh:mm",
        //     leapday: "-02-29",
        //     separator: "-",
        //     alias: "yyyy/mm/dd"
        // });

        // $('#AtendimentoDTVIAGEMFIN').mask('0000-00-00 00:00', {'translation':{
        //         9: {pattern: /[0-9]/},
        //         1: {pattern: /[0-1]/},
        //         2: {pattern: /[0-2]/},
        //         a: {pattern: /[A-Za-z]/},
        //         "*": {pattern: /[A-Za-z0-9]/}
        //     }
        // });

        $('#AtendimentoDTVIAGEMINI').inputmask("datetime",{
            mask: "1/2/y h:s",
            // placeholder: "yyyy-mm-dd hh:mm",
            placeholder: "dd/mm/yyyy hh:mm",
            leapday: "/29/02",
            separator: "/",
            // alias: "yyyy/mm/dd"
            alias:"dd/mm/yyyy"
        });

        $('#AtendimentoDTVIAGEMFIN').inputmask("datetime",{
            mask: "1/2/y h:s",
            // placeholder: "yyyy-mm-dd hh:mm",
            placeholder: "dd/mm/yyyy hh:mm",
            leapday: "/29/02",
            separator: "/",
            // alias: "yyyy/mm/dd"
            alias:"dd/mm/yyyy"
        });

        // $('#AtendimentoDTVIAGEMINI').datetimepicker({
        //     lang: 'pt',
        //     mask: true,
        //     format: 'Y-m-d H:i'
        // });

        // $('#AtendimentoDTVIAGEMFIN').datetimepicker({
        //     lang: 'pt',
        //     mask: true,
        //     format: 'Y-m-d H:i'
        //
        // });

        // $('#AtendimentoHRATENDIMENTO').datetimepicker({
        //     lang: 'pt',
        //     datepicker: false,
        //     timepicker: true,
        //     mask: true,
        //     format: 'H:i',
        // });

        let maskBehavior = function (val) {
            val = val.split(":");
            return (parseInt(val[0]) > 19)? "HZ:M0" : "H0:M0";
        };

        let spOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(maskBehavior.apply({}, arguments), options);
            },
            translation: {
                'H': {pattern: /[0-2]/, optional: false},
                'Z': {pattern: /[0-3]/, optional: false},
                'M': {pattern: /[0-5]/, optional: false}
            }
        };
        //
        $('#AtendimentoHRATENDIMENTO').mask(maskBehavior, spOptions);

        $('#AtendimentoHRATENDIMENTOFIN').mask(maskBehavior, spOptions);

        $("#ChamadoEditForm").on("submit", function(){
            finalizarPecas();
            $(this).submit();
        })

    });

    $("#AtendimentoPLACAVEICULO").mask("AAA-AAAA");

    $(function () {
        $("#AtendimentoVALESTACIONAMENTO").maskMoney({thousands: '', decimal: ','});
        $("#AtendimentoKMINICIAL").maskMoney({thousands: '', decimal: ''});
        $("#AtendimentoKMFINAL").maskMoney({thousands: '', decimal: ''});
        $("#AtendimentoVALPEDAGIO").maskMoney({thousands: '', decimal: ','});
        $("#AtendimentoVALOUTRASDESP").maskMoney({thousands: '', decimal: ','});
        $("#AtendimentoVALATENDIMENTO").maskMoney({thousands: '', decimal: ','});
        $("#AtendimentoVALKM").maskMoney({thousands: '', decimal: ','});
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
        var options = '<option value="">Selecione um Status</option>';
        if (cidades != null) {
            $.each(cidades, function (index, cidade) {
                if (idCidade == index)
                    options += '<option selected="selected" value="' + index + '">' + cidade + '</option>';
                else
                    options += '<option value="' + index + '">' + cidade + '</option>';
            });
            $('#ChamadoCDSTATUS').html(options);
        }

    }

    function adicionarPecaNaTabela() {
        var numPecas = $('#numPecas').text();
        var cdProduto = $('#ftecit').val();
        var cdProduto2 = $('#PecaCDPRODUTO2').val();
        var quantidade = $('#PecaQUANTIDADE').val();
        var status = $('#PecaSTATUS').find('option:selected').text();
        var pecaCritica = $('#PecaCRITICA').is(":checked") === true ? "Sim" : "Não";
        var necessitaDevolucao = $('#AtendimentoDEVOLUCAO').is(":checked") === true ? "Sim" : "Não";

        var checkStatusAtendido = <?php echo $checkStatusAtendito == true ? 1 : 0; ?>

        if ((cdProduto || cdProduto2) && quantidade) {
            $("#tabela").show();

            $('#tabelaAqui > tbody:last-child').append('<tr><td>'+cdProduto+'</td><td>'+cdProduto2+'</td><td>'+quantidade+'</td><td>'+status+'</td><td>'+pecaCritica+'</td><td>'+necessitaDevolucao+'</td></tr>');

            $('<input>').attr({
                type: 'hidden',
                name: 'data[Peca][' + numPecas + '][CDPRODUTO]',
                value: cdProduto
            }).appendTo('#colocaAqui');

            $('<input>').attr({
                type: 'hidden',
                name: 'data[Peca][' + numPecas + '][CDPRODUTO2]',
                value: cdProduto2
            }).appendTo('#colocaAqui');

            $('<input>').attr({
                type: 'hidden',
                name: 'data[Peca][' + numPecas + '][QUANTIDADE]',
                value: quantidade
            }).appendTo('#colocaAqui');

            numPecas = parseInt(numPecas) + 1;
            $('#numPecas').html(numPecas);

            // verificação para o status de atendido
            if(checkStatusAtendido == 1){

                var status = false;

                // verifica se já foi setado o status
                $('#ChamadoSTATUS option').each((index, data) => {
                    if(data.attributes.value.value == 'T'){
                        status = true;
                    }
                })

                if(status == false){
                    // remove o status (O - concluído)
                    $("#ChamadoSTATUS option[value='O']").remove();

                    // adiciona o status (T - atendido)
                    $('#ChamadoSTATUS').append(`<option value='T'>Atendido</option>`);

                    // remove os itens do substatus
                    $("#ChamadoCDSTATUS option").remove();
                }

            }

        }
    }

    function limparFormPecas() {
        var cdProduto = $('#ftecit').val();
        var cdProduto2 = $('#PecaCDPRODUTO2').val();
        var quantidade = $('#PecaQUANTIDADE').val();

        if ((cdProduto || cdProduto2) && quantidade) {
            $('#ftecit').val('');
            $('#PecaCDPRODUTO2').val('');
            $('#PecaQUANTIDADE').val('');
            $('#PecaSTATUS').val('');
            $('#PecaCRITICA').attr('checked', false);
            $('#AtendimentoDEVOLUCAO').attr('checked', false);
        }

    }

    function adicionarMaisPecas() {
        adicionarPecaNaTabela();
        limparFormPecas();
    }

    function finalizarPecas() {
        adicionarPecaNaTabela();
        limparFormPecas();
        $('#formularioPecas').remove();
    }

</script>
