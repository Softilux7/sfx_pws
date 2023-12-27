<div class="span12">
    <div class="row-fluid">
        <div class="span12">
          <p> <h1 class="page-header"><i class="fa fa-file-text-o fa-lg"></i> <?php echo __('Relatórios'); ?></h1></p>
        </div>
    </div>
    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
        <ul class="nav nav-pills">
                <li>
                    <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>
                        <?php echo $this->Html->link(__('Equipamentos Com Contrato'), array('controller' => 'ContratoItens', 'action' => 'index')); ?>
                    <?php }?>
                </li>
                <li>
                    <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>     
                        <?php echo $this->Html->link(__('Equipamentos Sem Contrato'), array('controller' => 'Equipamentos', 'action' => 'index')); ?>
                    <?php }?>
                </li>
                <li>
                    <?php echo $this->Html->link(__('Chamados'), array('controller' => 'Chamados', 'action' => 'index')); ?>
                </li>
            </ul>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
            <br/>
        </div>
    <?php } ?>
    <div class="row-fluid show-grid">
        <div class="span12">
            <div class="row-fluid show-grid">
                <div class="span12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3><i class="fa fa-check-square-o" aria-hidden="true"></i>
                                Lista de relatórios</h3>
                        </div>
                        <div class="panel-body">
                            <div class="btn-group btn-group-vertical">
                                <p><a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'relatorios', 'action' => 'chamado_periodo')); ?>" class="btn btn-large btn-default "><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        &nbsp;Chamados por Período</a>
                                </p>
                                <p>
                                    <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'relatorios', 'action' => 'chamado_at')); ?>" class="btn btn-large btn-default "><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        &nbsp;Chamados Atendimento</a>
                                </p>
                                <p>
                                    <a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'relatorios', 'action' => 'chamado_c')); ?>" class="btn btn-large btn-default "><i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        &nbsp;Chamados Concluídos</a>
                                </p>
                            </div>
                            <p>&nbsp;</p>
                            <p>&nbsp; </p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                        </div>
                        <div class="panel-footer">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>