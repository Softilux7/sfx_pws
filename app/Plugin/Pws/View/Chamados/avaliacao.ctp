<div class="span12">
    <h2>
        <?php echo __('Avaliação'); ?>
    </h2>
    <div class="row-fluid">
        <div class="row-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Chamado Técnico
                        <small class="text-right">Chamado Nº # <?php
                                echo h($idOS.'/'.$chamado['Chamado']['SEQOS']);
                            ?></small>
                    </h1>
                </div>
                <div class="panel-body">
                    <?php if ($error == ''): ?>
                    <?php echo $this->Form->create('Chamado', array('class' => 'form-horizontal')); ?>
                    <ul class="nav nav-tabs" id="tabAvaliacao">
                        <li class="active"><a href="#avaliacao">Avaliação</a></li>
                        <li><a href="#infoChamado">Informações do chamado</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="avaliacao">

                            <?php echo $this->Form->create('avaliacao', array('class' => 'form-horizontal')); ?>
                            <?php echo $this->Form->input('idOS', array('type' => 'hidden', 'div' => false, 'label' => false, 'required', 'error' => false, value => $idOS)); ?>
                            <?php echo $this->Form->input('idClient', array('type' => 'hidden', 'div' => false, 'label' => false, 'required', 'error' => false, value => $idClient)); ?>

                            <div>
                                    Prezado cliente, sua avaliação é muito importante para melhorarmos a prestação de nossos serviços. Contamos com a sua contribuição. Obrigado
                                </div>
                                    <div class="text-center">
                                    <div><h3>Seu problema foi resolvido?</h3></div>
                                    <p>
                                        <span style="color: red;">*</span>
                                        <?php echo $this->Form->select('idResolvido', array(0 => '-- SELECIONE --', 1 => 'Sim', 2 => 'Parcial',  3 => 'Não'), array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false));?>
                                    </p>
                                </div>

                                <div class="text-center" id="resolvidoStatus" style="display:none">
                                    <div><h3>Motivo:</h3></div>
                                    <div><?php echo $this->Form->input('motivoResolvido', array('type' => 'textarea', 'div' => false, 'label' => false, 'required', 'error' => false, 'rows' => '4', 'cols' => '100')); ?></div>
                                </div>

                                <div style="margin-top:60px;position:relative" id="content-score">
                                    <div class="mask-score"></div>
                                    <div class="text-center"><h2>Qual a sua avaliação para o atendimento:</h2></div>
                                    <div class="tac">
                                        <ul class="rate-avaliacao" style="clear:both" id="statusAvaliacao">
                                            <li class="bg-avaliacao-score0" id="0">0</li>
                                            <li class="bg-avaliacao-score1" id="1">1</li>
                                            <li class="bg-avaliacao-score2" id="2">2</li>
                                            <li class="bg-avaliacao-score3" id="3">3</li>
                                            <li class="bg-avaliacao-score4" id="4">4</li>
                                            <li class="bg-avaliacao-score5" id="5">5</li>
                                            <li class="bg-avaliacao-score6" id="6">6</li>
                                            <li class="bg-avaliacao-score7" id="7">7</li>
                                            <li class="bg-avaliacao-score8" id="8">8</li>
                                            <li class="bg-avaliacao-score9" id="9">9</li>
                                            <li class="bg-avaliacao-score10" id="10">10</li>
                                        </ul>
                                        <div style="clear:both"></div>

                                    </div>

                                    <div class="text-center" id="motivoStatus" style="margin-top:25px">
                                        <div><em>Em poucas palavras, descreva o que motivou sua nota sobre a avaliação:</em></div>
                                        <div><?php echo $this->Form->input('motivoNota', array('type' => 'textarea', 'div' => false, 'label' => false, 'required', 'error' => false, 'rows' => '4', 'cols' => '100')); ?></div>
                                    </div>

                                    <div><?php echo $this->Form->input('score', array('type' => 'hidden', 'div' => false, 'label' => false, 'required', 'error' => false, value => '')); ?></div>
                                </div>

                            </form>

                        </div>
                        <div class="tab-pane" id="infoChamado">

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
                                                    <?php echo $this->Form->input('ATUALIZADO', array('type' => 'hidden','value'=>'2', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                    <?php echo $this->Form->input('Atendimento.SEQOS', array('value' => h($chamado['Chamado']['SEQOS']), 'type' => 'hidden', 'div' => false, 'label' => false, 'error' => false)); ?>
                                                    Abertura:</strong> <?php echo h(date('d-m-Y', strtotime($chamado['Chamado']['DTINCLUSAO']))); ?>
                                                <strong>Hora</strong> <?php echo h($chamado['Chamado']['HRINCLUSAO']); ?>
                                                <br><strong>Tipo de
                                                    Chamado:</strong> <?php echo h($chamado['ChamadoTipo']['NMOSTP']); ?>
                                                <br>
                                                <strong>Defeito:</strong> <?php echo h($chamado['Defeito']['NMDEFEITO']); ?>
                                                <br>

                                            </div>
                                            <div class="span5 offset1">
                                                <strong>
                                                 Status:</strong> Concluído
                                                 </strong>
                                                <br>
                                                 <strong>Follow-up do Técnico:</strong> <?php echo h($chamado['Chamado']['OBSDEFEITOATS']); ?>
                                                 <br>
                                            </div>
                                        </div>
                                    </div>


                        </div>
                    </div>
                    <?php else: ?>

                        <h2><?php echo $error ?></h2>

                    <?php endif; ?>
                </div>
                <?php if ($error == ''): ?>
                <div class="panel-footer">
                    <input id="submitForm" type="submit" class="btn btn-primary"
                           value="<?php echo __('Salvar'); ?>"/>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
// instancia javascript referente a classe
new init().__construct('<?php echo __('chamado'); ?>');
</script>