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
                    <?php if (empty($solicitacao['Solicitacao']['contrato_id'])) { ?>
                    <h1>Solicitação de Suprimento</h1>
                    <?php  } else { ?>
                        <h1>Solicitação de Suprimento por Contrato / Modelo</h1>
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <div class="row-fluid">
                        <div class="span2">
                            <h1>
                                <small>Nº # <?php echo h($solicitacao['Solicitacao']['id']); ?></small>
                            </h1>
                        </div>
                        <div class="span4 offset6">

                            <strong>Data da
                                Solicitação:</strong> <?php echo h(date('d-m-Y', strtotime($solicitacao['Solicitacao']['created']))); ?>
                            <strong>Hora</strong> <?php echo h(date('H:i', strtotime($solicitacao['Solicitacao']['created']))); ?>
                            <br>
                            <strong> Status:</strong>

                            <?php
                            switch ($solicitacao['Solicitacao']['status']) {
                                case 'P':
                                    echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                    break;
                                case 'T':
                                    echo "<span class='label label-warning'style='font-size: 14px'>Em Trânsito</span>";
                                    break;
                                case 'C':
                                    echo "<span class='label label-danger'style='font-size: 14px'>Cancelada</span>";
                                    break;
                                case 'O':
                                    echo "<span class='label label-success'style='font-size: 14px'>Concluída</span>";
                                    break;
                                case 'E':
                                    echo "<span class='label label-primary-bootstrap4' style='font-size: 14px'>Em Análise</span>";
                                    break;
                                case 'L':
                                    echo "<span class='label label-default' style='font-size: 14px'>Liberada</span>";
                                    break;
                            }
                            ?>

                        </div>

                    </div>

                    <div class="row-fluid">
                        <div class="span3">

                            <strong>Transportadora:</strong> <?php echo h($solicitacao['Solicitacao']['transportadora']); ?>

                        </div>
                        <div class="span4 offset5">
                            <strong> Nr Nota Fiscal: </strong> <?php echo h($solicitacao['Solicitacao']['NRNFSAIDA']); ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">
                            <strong>Código de Rastreio:</strong> <?php echo h($solicitacao['Solicitacao']['cdrastreio']); ?>
                        </div>
                        <div class="span4 offset5">
                            <strong> Data Emissão NF:</strong> <?php
                            if ($solicitacao['Solicitacao']['DTEMISSAONFS']!='0000-00-00' && $solicitacao['Solicitacao']['DTEMISSAONFS']!='') {
                                echo h(date('d-m-Y', strtotime($solicitacao['Solicitacao']['DTEMISSAONFS'])));
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <strong> Situação:</strong>
                            <?php
                            switch ($solicitacao['Solicitacao']['situacao']) {
                                case 'R':
                                    echo "<span class='label label-info'style='font-size: 14px'>Recebido</span>";
                                    break;
                                case 'E':
                                    echo "<span class='label label-info'style='font-size: 14px'>Em Andamento</span>";
                                    break;
                                case 'P':
                                    echo "<span class='label label-info'style='font-size: 14px'>Entregue Parcial</span>";
                                    break;
                                case 'T':
                                    echo "<span class='label label-info'style='font-size: 14px'>Entregue Total</span>";
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="span4">
                            <div class="control-group">
                                <label for="SolicitacaoOBSADMINREVENDA" class="control-label"><strong style="font-size: 14px;"><?php echo __('Observação:'); ?></strong></label>
                                <textarea name="data[OBSADMINREVENDA]" maxlength="80" class="span8" rows="6" disabled="disabled" cols="30" id="OBSADMINREVENDA"><?php echo h($solicitacao['Solicitacao']['OBSADMINREVENDA']); ?></textarea>
                            </div>
                        </div>
                    </div>
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
                                        <?php if (empty($solicitacao['Solicitacao']['contrato_id'])) { ?>
                                            <strong>Endereço:</strong> <?php echo h($solicitacao['Equipamento']['ENDERECO']); ?>
                                            , <?php echo h($solicitacao['Equipamento']['NUM']); ?><?php echo h($solicitacao['Equipamento']['COMPLEMENTO']); ?>
                                            <br>
                                            <strong>Bairro:</strong> <?php echo h($solicitacao['Equipamento']['BAIRRO']); ?>
                                            <strong>CEP:</strong> <?php echo h($solicitacao['Equipamento']['CEP']); ?>
                                            <br>

                                            <strong>Cidade:</strong> <?php echo h($solicitacao['Equipamento']['CIDADE']); ?>

                                            <strong>UF:</strong> <?php echo h($solicitacao['Equipamento']['UF']); ?>
                                            <br>
                                        <?php } else { ?>
                                            <strong>Cidade:</strong> <?php echo h($solicitacao['Solicitacao']['cidade']); ?>
                                        <?php } ?>
                                        <strong>Contato:</strong> <?php echo h($solicitacao['Solicitacao']['contato']); ?>
                                        <strong>Fone:</strong> <?php echo h($solicitacao['Solicitacao']['fone']); ?>
                                        <br>
                                        <strong>Email:</strong> <?php echo h($solicitacao['Solicitacao']['email']); ?>
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
                                        <?php if (empty($solicitacao['Solicitacao']['contrato_id'])) { ?>
                                            <strong>Série:</strong> <?php echo h($solicitacao['Equipamento']['SERIE']); ?>
                                            <br>
                                            <strong>Patrimônio:</strong> <?php echo h($solicitacao['Equipamento']['PATRIMONIO']); ?>
                                            <br>
                                            <strong>Modelo:</strong> <?php echo h($solicitacao['Equipamento']['MODELO']); ?>
                                            <br>
                                            <strong>Departamento:</strong> <?php echo h($solicitacao['Equipamento']['DEPARTAMENTO']); ?>
                                            <br>
                                            <strong>Local de
                                                Instalação:</strong> <?php echo h($solicitacao['Equipamento']['LOCALINSTAL']); ?>
                                            <br>
                                        <?php } else { ?>

                                            <strong>Contrato:</strong> <?php echo h($solicitacao['Solicitacao']['contrato_id']); ?>
                                            <br>
                                            <strong>Modelo:</strong> <?php echo h($solicitacao['Solicitacao']['modelo']); ?>
                                            <br>
                                            <strong>Departamento:</strong> <?php echo h($solicitacao['Solicitacao']['departamento']); ?>
                                            <br>
                                            <strong>Local de
                                                Instalação:</strong> <?php echo h($solicitacao['Solicitacao']['localinstal']); ?>
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
                                    <?php foreach ($suprimentos as $suprimentos): ?>

                                        <div class="row-fluid show-grid">
                                            <div class="span12 well">
                                                <div class="row-fluid">
                                                    <div class="span3">
                                                        <div><strong>Suprimento:</strong>&nbsp;
                                                            <?php echo $suprimentos['SuprimentoTipo']['nome_tipo']; ?>
                                                        </div>

                                                    </div>

                                                    <div class="span3">
                                                        <div>
                                                            <strong>Quantidade:</strong>&nbsp; <?php echo $suprimentos['SolicitacaoSuprimento']['quantidade']; ?>
                                                        </div>

                                                    </div>
                                                    <? if($empresa_id == 42){?>
                                                    <div class="span3">
                                                        <div>
                                                            <strong>Contador:</strong>&nbsp; <?php echo $suprimentos['SolicitacaoSuprimento']['contador']; ?>
                                                        </div>
                                                    </div>
                                                    <? } ?>
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
                    <a class="btn" href="<?php echo Router::url(array('plugin' => 'pws','controller' => 'solicitacao','action' => 'index')); ?>">
                        <?php echo __('Voltar'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function cancel() {
        window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'solicitacao', 'action' => 'index')); ?>';
    }
</script>