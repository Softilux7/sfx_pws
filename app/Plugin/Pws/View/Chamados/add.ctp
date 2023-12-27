<div class="span12">
    <h2>
        <?php echo __('Abertura de Chamado Técnico'); ?>
    </h2>

    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-pills">
                <li class="active">
                    <a  href="javascript:window.history.go(-1)">Voltar</a>
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
                        <?php foreach ($error as $er) { ?>
                            <strong><?php echo __('Erro!'); ?> </strong>
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

            <?php echo $this->Form->create('Chamado', array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data')); ?>

        </div>
        <!--  INICIO DO NOVO LAYOUT      -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1>NOVO CHAMADO</h1>
            </div>
            <div class="panel-body">

                <ul class="nav nav-tabs" id="chamados">
                    <li class="active"><a href="#dadosChamado">Dados do Chamado</a></li>
                    <?php if(EmpresaPermissionComponent::verifiqueClienteDataVoice($auth_user_group['id'], $auth_user['User']['empresa_id']) == false and $auth_user_group['id'] != 12){?>
                        <li><a href="#historicos">Históricos de O.S</a></li>
                    <?php }?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="dadosChamado">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="panel panel-warning">
                                    <div class="panel-heading">
                                        <h4><a data-toggle="collapse" href="#collapseChamado"
                                               aria-controls="collapseChamado">Dados do Equipamento</a></h4>
                                    </div>
                                    <div class="collapse in" id="collapseChamado">
                                        <div class="panel-body">
                                            <p>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label
                                                        class="control-label"><strong><?php echo(__('Cliente: ')); ?></strong>
                                                        <?php echo h($cliente[0]['Cliente']['NMCLIENTE']); ?></label>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Código equipamento: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['CDEQUIPAMENTO']); ?></label>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Série: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['SERIE']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Modelo: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['MODELO']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Fabricante: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['FABRICANTE']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Patrimônio: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['PATRIMONIO']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Produto: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['CDPRODUTO']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Departamento: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['DEPARTAMENTO']); ?></label>
                                                </div>
                                            </div>


                                            <div class="span4">
                                                <div class="control-group">
                                                    <label
                                                        class="control-label"><strong><?php echo(__('Endereço: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['ENDERECO'] . ',' . $equip['Equipamento']['NUM']); ?>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label
                                                        class="control-label"><strong><?php echo(__('Complemento: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['COMPLEMENTO']); ?></label>
                                                </div>
                                            </div>
                                            <div class="span4">
                                                <div class="control-group">
                                                    <label
                                                        class="control-label"><strong><?php echo(__('Bairro: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['BAIRRO']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label
                                                        class="control-label"><strong><?php echo(__('Cidade: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['CIDADE']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label
                                                        class="control-label"><strong><?php echo(__('Locação de Instalação: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['LOCALINSTAL']); ?></label>
                                                </div>
                                            </div>

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label
                                                        class="control-label"><strong><?php echo(__('Prioridade Atendimento: ')); ?></strong>
                                                        <?php echo h($equip['Equipamento']['TEMPOATENDIMENTO']) . ' Horas'; ?>
                                                    </label>
                                                </div>
                                            </div>

<!--                                            <div class="span4">-->
<!--                                                <div class="control-group">-->
<!--                                                    <label-->
<!--                                                        class="control-label"><strong>--><?php //echo(__('Considera Dias Úteis: ')); ?><!--</strong>-->
<!--                                                        --><?php //if ($equip ['Equipamento'] ['TFDIASUTEIS'] == 'S') {
//                                                            echo 'SIM';
//                                                        } else {
//                                                            echo(__('NÃO'));
//                                                        } ?><!--</label>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                            <div class="span4">-->
<!--                                                <div class="control-group">-->
<!--                                                    <label-->
<!--                                                        class="control-label"><strong>--><?php //echo(__('Considera Horas Úteis: ')); ?><!--</strong>-->
<!--                                                        --><?php
//
//                                                        if ($equip ['Equipamento'] ['TFHORASUTEIS'] == 'S') {
//                                                            echo 'SIM';
//                                                        } else {
//                                                            echo(__('NÃO'));
//                                                        }
//                                                        ?><!--</label>-->
<!--                                                </div>-->
<!--                                            </div>-->

                                            <div class="span4">
                                                <div class="control-group">
                                                    <label class="control-label">
                                                        <strong><?php echo(__('Previsão Atendimento: ')); ?></strong>

                                                        <span class="text-info">
                                                            <strong>
                                                                <?php
                                                                echo date('d-m-Y', strtotime($this->request->data('Chamado.DTPREVENTREGA'))) . ' - ' . $this->request->data('Chamado.HRPREVENTREGA');
                                                                ?>
                                                            </strong>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                                </div>


                        </div>
                        <div class="row-fluid show-grid">
                            <legend><?php echo(__('Dados do Solicitante: ')); ?></legend>
                            <div class="span8">
                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Nome:'); ?><span
                                            style="color: red;">*</span> </label>

                                    <div class="controls">
                                        <?php echo $this->Form->input('CONTATO', array('div' => false, 'value' => $this->request->data['Chamado']['CONTATO'] != '' ? ($this->request->data['Chamado']['CONTATO']) : '', 'id' => 'contato', 'required', 'label' => false, 'disabled' => false, 'error' => false,'placeholder'=>'Digite seu nome para contato')); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="span8">
                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Email Cliente:'); ?><span
                                            style="color: red;">*</span> </label>

                                    <div class="controls">
                                        <?php echo $this->Form->input('EMAIL', array('div' => false, 'value' => $auth_user['User']['user_email'], 'id' => 'email', 'label' => false, 'required', 'disabled' => false, 'error' => false,'placeholder'=>'DigiteSeuEmail@email.com')); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="span8">
                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Fone:'); ?><span
                                            style="color: red;">*</span> </label>

                                    <div class="controls">
                                    
                                        <!-- <?php echo $this->Form->input('DDD', array('div' => false, 'id' => 'ddd', 'label' => false, 'class' => 'span1', 'maxlength'=>'3','required', 'disabled' => false, 'error' => false, 'placeholder'=>'(ddd)')); ?> -->
                                        <?php echo $this->Form->input('FONE', array('div' => false, 'maxlength'=>'15', 'value' => $this->request->data['Chamado']['DDD'] != '' ? ($this->request->data['Chamado']['DDD'].' '. $this->request->data['Chamado']['FONE']) : '', 'id' => 'fone', 'label' => false, 'required', 'disabled' => false, 'error' => false, 'placeholder'=>'Digite seu telefone')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row-fluid show-grid">
                            <legend><?php echo(__('Dados da O.S: ')); ?></legend>
                            <div class="span8">
                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Modalidade da O.S:'); ?><span
                                                style="color: red;">*</span> </label>

                                    <div class="controls">
                                        <?php echo $this->Form->select('TIPO_OS', $modalidadesOrdemDeServico, array(
                                                'empty' => '(Selecione)',
                                                'required',
                                                'label' => false)); ?>
                                    </div>
                                </div>
                            </div>
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
                                    <label class="control-label"><?php echo __('Descrição do Defeito.:'); ?><span
                                            style="color: red;">*</span> </label>

                                    <div class="controls">
                                        <?php echo $this->Form->input('OBSDEFEITOCLI', array(
                                            'type' => 'textarea',
                                            'div' => false,
                                            'class'=>"span4",
                                            'label' => false,
                                            'required', 'disabled' => false,
                                            'error' => false)); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="span8">
                                <div class="control-group">
                                    <label class="control-label"><?php echo __('Anexar arquivos:'); ?></label>
                                    <label class="control-label"><em style="color:#999"><?php echo __('arquivos permitidos: jpeg, png, pdf, txt, doc, docx'); ?></em></label>
                                    <div class="controls">
                                        <div>
                                            <input type="file" id="file1" name="file1">
                                        </div>
                                        <div>
                                            <input type="file" id="file2" name="file2">
                                        </div>
                                        <div>
                                            <input type="file" id="file3" name="file3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row-fluid show-grid">
                                <div class="span6">

                                </div>
                            </div>

                        </div>

                    </div>
                    <?php if(EmpresaPermissionComponent::verifiqueClienteDataVoice($auth_user_group['id'], $auth_user['User']['empresa_id']) == false){?>
                    <div class="tab-pane" id="historicos">
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4><a data-toggle="collapse" href="#collapseAtendimentos"
                                               aria-controls="collapseAtendimentos"> Histórico de Chamados</a></h4>
                                    </div>
                                    <div class="collapse in" id="collapseAtendimentos">
                                        <div class="panel-body">
                                            <?php foreach ($chamados as $chamadoH): ?>
                                                <div class="row-fluid show-grid">
                                                    <div class="span12 well">
                                                        <div class="row-fluid">
                                                            <div class="span2">
                                                                <div><strong>Chamado Nº:</strong>&nbsp;<a href="<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'chamados', 'action' => 'view', $chamadoH['Chamado']['id'])); ?>"><?php echo h($chamadoH['Chamado']['id']); ?>
                                                                    / <?php echo h($chamadoH['Chamado']['SEQOS']); ?></a></div>
                                                            </div>
                                                            <div class="span2">
                                                                <div><strong>Data da Inclusão:</strong>&nbsp;
                                                                    <?php echo date('d/m/Y',strtotime($chamadoH['Chamado']['DTINCLUSAO'])); ?>
                                                                </div>

                                                            </div>

                                                            <div class="span2">
                                                                <div>
                                                                    <strong>Hora
                                                                        Inclusão:</strong>&nbsp; <?php echo $chamadoH['Chamado']['HRINCLUSAO']; ?>
                                                                </div>

                                                            </div>

                                                            <div class="span3">
                                                                <div>
                                                                    <strong>Contato
                                                                        :</strong>&nbsp; <?php echo $chamadoH['Chamado']['CONTATO']; ?>
                                                                </div>
                                                            </div>
                                                            <div class="span3">
                                                                <div><strong>Status: </strong>&nbsp;<?php
                                                                    switch ($chamadoH['Chamado']['STATUS']) {
                                                                        case 'P':
                                                                            echo "<span class='label label-info'style='font-size: 14px'>Pendente</span>";
                                                                            break;
                                                                        case 'M':
                                                                            echo "<span class='label label-warning'style='font-size: 14px'>Em Manutenção</span>";
                                                                            break;
                                                                        case 'C':
                                                                            echo "<span class='label label-danger'style='font-size: 14px'>Cancelado</span>";
                                                                            break;
                                                                        case 'O':
                                                                            echo "<span class='label label-success'style='font-size: 14px'>Concluído</span>";
                                                                            break;
                                                                        case 'A':
                                                                            echo "<span class='label label-info-bootstrap4'style='font-size: 14px'>Abertura</span>";
                                                                            break;
                                                                        case 'T':
                                                                            echo "<span class='label label-default'style='font-size: 14px'>Atendido</span>";
                                                                            break;
                                                                        case 'E':
                                                                            echo "<span class='label label-primary-bootstrap4'style='font-size: 14px'>Despachado</span>";
                                                                            break;
                                                                    }
                                                                    ?>&nbsp;</div>
                                                            </div>
                                                            <?php if ($chamadoH['Chamado']['STATUS'] != 'O') { ?>
                                                                <div><strong>Data
                                                                        Prevista
                                                                        Atendimento: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($chamadoH['Chamado']['DTPREVENTREGA'])) . ' ' . date('H:i', strtotime($chamadoH['Chamado']['HRPREVENTREGA'])); ?>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div><strong>Data
                                                                        Conclusão: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($chamadoH['Chamado']['DTATENDIMENTO'])) . ' ' . date('H:i', strtotime($chamadoH['Chamado']['HRATENDIMENTO'])); ?>
                                                                </div>
                                                            <?php } ?>
                                                            <?php if ($chamadoH['Chamado']['DTATENDIMENTO1'] != '0000-00-00 00:00:00') { ?>
                                                                <div><strong>Data
                                                                        Atendimento: </strong>&nbsp;<?php echo date('d/m/Y', strtotime($chamadoH['Chamado']['DTATENDIMENTO1'])) . ' ' . date('H:i', strtotime($chamadoH['Chamado']['HRATENDIMENTO1'])); ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                                <div>
                                                                    <strong>Defeito Relatado:</strong>&nbsp; <?php echo $chamadoH['Defeito']['NMDEFEITO']; ?>
                                                                </div>
                                                                <div>
                                                                    <strong>Descrição do
                                                                        Chamado:</strong>&nbsp; <?php echo $chamadoH['Chamado']['OBSDEFEITOCLI']; ?>
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
                    <?php }?>
                </div>


            </div>
            <div class="panel-footer">
                <input id="btnSave" data-loading-text="Aguarde..." type="submit" class="btn btn-primary"
                       value="<?php echo __('Salvar'); ?>"/>
                <input type="button" class="btn" value="<?php echo __('Cancelar'); ?>" onclick="javascript:window.history.go(-1)"/>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<script>

    $('#fone').keyup(function(){
        const element = $(this);
        const result = Telefone(element.val());
        element.val(result);
    })

    function Telefone(v) {

        v = v.replace(/\D/g, "");
        v = v.replace(/^(\d\d)(\d)/g, "($1) $2");
        
        if (v.length <= 13) {
            v = v.replace(/(\d{4})(\d)/, "$1-$2");
        } else {
            v = v.replace(/(\d{5})(\d)/, "$1-$2");
        }   

        return v;
    }

    $('#btnSave').on('click', function (){

        var $btn = $(this).button('loading');
        // business logic...

         //$btn.button('reset')

    });

    function cancel_add() {
        window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'ContratoItens', 'action' => 'index')); ?>';
    }
    $('#chamados a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })



</script>