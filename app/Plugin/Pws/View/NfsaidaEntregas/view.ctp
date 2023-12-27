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
                    <h1>Chamado Técnico                        <small class="text-right">Chamado Nº # <?php if ($chamado['Chamado']['SEQOSORIGEM'] == 0) {
                                echo h($chamado['Chamado']['id']).' / '.h($chamado['Chamado']['SEQOS']);
                            } else {
                                echo h($chamado['Chamado']['SEQOSORIGEM']).' / '.h($chamado['Chamado']['SEQOS']);
                            } ?></small></h1>
                </div>
                <div class="panel-body">

                    <ul class="nav nav-tabs" id="chamados">
                        <li class="active"><a href="#dadosChamado">Dados do Chamado</a></li>
                        <li><a href="#historicos">Históricos</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="dadosChamado">
                            <div class="row-fluid">
                                <div class="span12">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseChamado"  aria-controls="collapseChamado" > Dados do Chamado</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseChamado">
                                            <div class="panel-body">
                                                <p>
                                                    <strong>Técnico:</strong> <?php echo h($chamado['Chamado']['NMSUPORTET']); ?><br>
                                                    <strong>Data de
                                                        Abertura:</strong> <?php echo h(date('d-m-Y', strtotime($chamado['Chamado']['DTINCLUSAO']))); ?>
                                                    <strong>Hora</strong> <?php echo h($chamado['Chamado']['HRINCLUSAO']); ?>
                                                    <br>
                                                    <strong> Status:</strong>
                                                    <?php
                                                    switch ($chamado['Chamado']['STATUS']){
                                                        case 'P':
                                                            echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                            break;
                                                        case 'M':
                                                            echo "<span class='label label-warning'style='font-size: 14px'>Em Manutenção</span>";
                                                            break;
                                                        case 'C':
                                                            echo "<span class='label label-danger'style='font-size: 14px'>Cancelada</span>";
                                                            break;
                                                        case 'O':
                                                            echo "<span class='label label-success'style='font-size: 14px'>Concluída</span>";
                                                            break;
                                                    }
                                                    ?><br>
                                                    <strong>Tipo de Chamado:</strong> <?php echo h($chamado['ChamadoTipo']['NMOSTP']); ?> <br>
                                                    <strong>Defeito:</strong> <?php echo h($chamado['Defeito']['NMDEFEITO']); ?><br>
                                                    <strong>Defeito Relatado pelo Cliente:</strong> <?php echo h($chamado['Chamado']['OBSDEFEITOCLI']); ?><br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseCliente"  aria-controls="collapseCliente" > Dados do Cliente</a></h4>
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
                                                    <strong>CEP:</strong> <?php echo h($chamado['Chamado']['CEP']); ?> <br>
                                                    <strong>Cidade:</strong> <?php echo h($chamado['Chamado']['CIDADE']); ?>
                                                    <strong>UF:</strong> <?php echo h($chamado['Chamado']['UF']); ?> <br>
                                                    <strong>Contato:</strong> <?php echo h($chamado['Chamado']['CONTATO']); ?>
                                                    <strong>Fone:</strong> <?php echo h($chamado['Chamado']['DDD']); ?> <?php echo h($chamado['Chamado']['FONE']); ?>
                                                    <br>
                                                    <strong>Email:</strong> <?php echo h($chamado['Chamado']['EMAIL']); ?><br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 offset0">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <h4><a data-toggle="collapse" href="#collapseEquipamento"  aria-controls="collapseEquipamento" > Dados do Equipamento</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseEquipamento">
                                            <div class="panel-body">
                                                <p>
                                                    <strong>Série:</strong> <?php echo h($chamado['Equipamento']['SERIE']); ?><br>
                                                    <strong>Patrimônio:</strong> <?php echo h($chamado['Equipamento']['PATRIMONIO']); ?>
                                                    <br>
                                                    <strong>Modelo:</strong> <?php echo h($chamado['Equipamento']['MODELO']); ?><br>
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
                                            <h4><a data-toggle="collapse" href="#collapseAtendimentos"  aria-controls="collapseAtendimentos" > Histórico de Atendimentos</a></h4>
                                        </div>
                                        <div class="collapse in" id="collapseAtendimentos">
                                            <div class="panel-body">
                                                <?php foreach ($atendimentos as $atendimento): ?>

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
                    </div>


                </div>
                <div class="panel-footer">
                    <a class="btn " onclick="cancel_add();"><?php echo __('Voltar'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
        <script>
            function cancel_add() {
                window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Chamados','action' => 'index')); ?>';
            }
            $('#chamados a').click(function (e) {
                e.preventDefault();
                $(this).tab('show');
            })
        </script>