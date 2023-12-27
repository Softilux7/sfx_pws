<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i class="fa fa-tasks fa-lg"></i> <?php echo __('Listar arquivos de faturamento'); ?></h1>
        </div>
    </div>
    <div class="row-fluid show-grid" id="tab_user_manager">
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
            <br/>
        </div>
    <?php } ?>
    <button type="button" class="btn btn-large btn-search" data-toggle="collapse" data-target="#search">
        <i class="icon-filter"></i> Filtrar Resultados
    </button>
    <?php if(in_array($auth_user_group['id'], array(1,6))){ ?>
    <button type="button" class="btn btn-large btn-search" onclick="javascript:new dfaturamento().uploadFile()">
            <i class="icon-inbox"></i> Importar arquivos
        </button>
    <?php } ?>
    <div id="search" class="collapse">
        <div class="row-fluid show-grid">
            <div class="span10">
                <?php echo $this->Search->create('', array('class' => 'form-inline')); ?>
                <fieldset>
                    <legend>Filtro</legend>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Coluna:'); ?> </label>

                            <div class="controls">
                                <?php

                                echo $this->Search->selectFields('filter1', array(
                                    'DFaturamento.id' => __('ID', true),
                                    'Cliente.FANTASIA' => __('Cliente', true),
                                    'Empresa.empresa_fantasia' => __('Revenda', true),
                                    'DFaturamento.mes' => __('Mês', true),
                                    'DFaturamento.ano' => __('Ano', true),
                                ), array(
                                    'class' => 'select-box'
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Operador:'); ?> </label>

                            <div class="controls">
                                <?php echo $this->Search->selectOperators('filter1'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Campo:'); ?> </label>

                            <div class="controls">
                                <?php
                                echo $this->Search->input('filter1', array(
                                    'placeholder' => "Localizar Chamado"
                                ));
                                ?>
                                <button class="btn" type="submit">
                                    <?php echo __('Filtrar'); ?>
                                </button>
                                <button class="btn" type="button" onclick="cancelSearch();">
                                    <i class="icon-remove-sign"></i>
                                </button>
                            </div>
                        </div>
                    </div>


                    <?php echo $this->Search->end(); ?>


                    <?php echo $this->Session->flash(); ?>
                </fieldset>
            </div>
        </div>
    </div>
    <?php echo $this->Form->create('DFaturamentos', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
    <?php echo $this->Form->end(); ?>
    <div class="row-fluid show-grid">
        <div class="span12">
            <div class="pagination pagination-small">
                <ul>
                    <?php
                    echo $this->Paginator->prev('<< ' . __(''), array(
                        'tag' => 'li',
                        'escape' => false
                    ));
                    echo $this->Paginator->numbers(array(
                        'separator' => '',
                        'tag' => 'li'
                    ));
                    echo $this->Paginator->next(__('') . ' >>', array(
                        'tag' => 'li',
                        'escape' => false
                    ));
                    ?>
                </ul>
            </div>
            <div>
              <strong>Prezado cliente,</strong> abaixo estão disponibilizados informações referente ao faturamento do seu contrato. Faça a seleção do período e o download dos arquivos.
            </div>
            <div class="row-fluid show-grid">
                <div class="span12">
                    <div class="btn-group">
                        <a class="btn  btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Ordenar por:') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Paginator->sort('id', 'ID'); ?>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>

                <table class="table" style="margin-top:10px">
                    <caption></caption>
                    <thead>
                         <tr>
                            <th>Empresa</th>
                            <th>Cliente</th>
                            <th>Período</th>
                            <th>Contrato</th>
                            <th>Observação</th>
                            <th>Data</th>
                            <th></th>
                         </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($DFaturamento as $data) : ?>
                        <tr>
                            <td scope="row"><?php echo $data['Empresa']['empresa_fantasia'];?></td>
                            <td><?php echo $data['Cliente']['FANTASIA'];?></td>
                            <td><?php echo $data['DFaturamento']['mes']."/".$data['DFaturamento']['ano'];?></td>
                            <td><?php echo $data['DFaturamento']['seqcontrato'];?></td>
                            <td><?php echo $data['DFaturamento']['observacao']?></td>
                            <td><?php echo date("d/m/Y", strtotime($data['DFaturamento']['data_upload']));?></td>
                            <?php $hash = Security::hash($data['Cliente']['id'].$data['DFaturamento']['mes'].$data['DFaturamento']['ano'].$data['DFaturamento']['seqcontrato']); ?>
                            <td><a href="javascript:new dfaturamento().viewFiles('<?php echo $data['Cliente']['id']?>', '<?php echo $data['DFaturamento']['mes']?>', '<?php echo $data['DFaturamento']['ano']?>', '<?php echo $data['DFaturamento']['seqcontrato']?>', '<?php echo $hash ?>')">Arquivos</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
               </table>

                </div>

            <p>
                <?php
                echo $this->Paginator->counter(array(
                    'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de {:count} no total, iniciando no registro {:start}, terminando em {:end}')
                ));
                ?>
            </p>

            <div class="pagination">
                <ul>
                    <?php
                    echo $this->Paginator->prev('<< ' . __('Anterior'), array(
                        'tag' => 'li',
                        'escape' => false
                    ));
                    echo $this->Paginator->numbers(array(
                        'separator' => '',
                        'tag' => 'li'
                    ));
                    echo $this->Paginator->next(__('Proximo') . ' >>', array(
                        'tag' => 'li',
                        'escape' => false
                    ));
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function cancelSearch() {
        removeUserSearchCookie();
        window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'DFaturamentos', 'action' => 'index')); ?>';
    }

    $(document).ready(function () {
        $('.pagination > ul > li').each(function () {
            if ($(this).children('a').length <= 0) {
                var tmp = $(this).html();
                if ($(this).hasClass('prev')) {
                    $(this).addClass('disabled');
                } else if ($(this).hasClass('next')) {
                    $(this).addClass('disabled');
                } else {
                    $(this).addClass('active');
                }
                $(this).html($('<a></a>').append(tmp));
            }
        });
    });

</script>
