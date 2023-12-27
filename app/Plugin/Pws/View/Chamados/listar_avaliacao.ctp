<div class="span12">
    <div class="row-fluid">
        <div class="span12">
            <h1 class="page-header"><i class="fa fa-pie-chart fa-lg"></i> <?php echo __('Avaliação NPS'); ?></h1>
        </div>
    </div>
    <?php if ($this->Session->check('Message.flash')) { ?>
        <div class="alert hidden-print">
            <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <b><?php echo($this->Session->flash()); ?></b>
            <br/>
        </div>
    <?php } ?>
    <button type="button" class="btn btn-large btn-search hidden-print" data-toggle="collapse"
            data-target="#search">
        <i class="icon-filter"></i> Filtrar Resultados
    </button>
    <div id="search" class="collapse hidden-print">
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
                                //'ChamadoAvaliacao.data_avaliacao' => __('Data', true),
                                //'Chamado.CDCLIENTE' => __('Cliente', true),
                                echo $this->Search->selectFields('filter1', array(
                                    'Cliente.FANTASIA' => __('Cliente', true),
                                    'Chamado.NMSUPORTET' => __('Técnico', true),
                                    'ChamadoAvaliacao.id_fk_chamado' => __('Nº Chamado WEB', true)
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
    <?php echo $this->Form->create('Chamado', array('action' => 'index', 'class' => ' form-signin form-horizontal')); ?>
    <?php echo $this->Form->end(); ?>
    <div class="row-fluid show-grid">
        <div class="span12">
            <div class="pagination pagination-small hidden-print">
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
            <div class="row-fluid show-grid hidden-print">
                <div class="span12">
                    <div class="btn-group">
                        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Status') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <?php echo $this->Html->link(__('Todos'), array('controller' => 'Chamados', 'action' => 'listarAvaliacao', '')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Sim resolvido'), array('controller' => 'Chamados', 'action' => 'listarAvaliacao', '1')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Resolvido parcialmente'), array('controller' => 'Chamados', 'action' => 'listarAvaliacao', '2')); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Não resolvido'), array('controller' => 'Chamados', 'action' => 'listarAvaliacao', '3')); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                            <?php echo __('Ordenar por:') ?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><?php echo $this->Paginator->sort('id_fk_chamado', 'Nº Chamado WEB'); ?></li>
                            <li><?php echo $this->Paginator->sort('FANTASIA', 'Cliente'); ?></li>
                            <li><?php echo $this->Paginator->sort('score', 'Score'); ?></li>
                            <li><?php echo $this->Paginator->sort('id_resolvido', 'Status'); ?></li>
                            <li><?php echo $this->Paginator->sort('data_avaliacao', 'Data'); ?>
                            </li>
                        </ul>
                    </div>
                    <div class="btn-group pull-right">
                        <a href="javascript:window.print()" class="btn">
                            <i class="fa fa-print" aria-hidden="true"></i> Imprimir
                        </a>
                    </div>
                </div>
            </div>

<!--            <div style="overflow: auto;">-->
                <table class="table table-bordered table-hover" style="margin-top:10px;">
                    <thead>
                        <tr>
                            <th>Chamado WEB Nº</th>
                            <th>Chamado SISTEMA Nº</th>
                            <th>Cliente</th>
                            <th>Observação Score</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Observação Status</th>
                            <th>Data</th>
                            <th>Técnico</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $attr = 0;

                        $countPositiva = 0;
                        $countNeutra   = 0;
                        $countNegativa = 0;
                        $count         = 0;

                        $arrStatus = array( 1 => 'Resolvido', 2 => 'Parcial', 3 => 'Não resolvido');

                        foreach ($data as $key => $value) :

                            // faz a verificação NUP
                            $score      = $value['ChamadoAvaliacao']['score'];
                            $classScore = '';

                            if ($score >= 0 and $score <= 6) {
                                $classScore = 'danger';
                                $countNegativa++;
                            } else if ($score > 6 and $score <=8) {
                                $classScore = 'warning';
                                $countNeutra++;
                            } else if ($score > 8 and $score <= 10) {
                                $classScore = 'success';
                                $countPositiva++;
                            }

                            $count++;

                            ?>
                            <tr scope="row">
                                <td><?php echo $value['ChamadoAvaliacao']['id_fk_chamado']?></td>
                                <td><?php echo $value['Chamado']['SEQOS']?></td>
                                <td><?php echo $value['Cliente']['FANTASIA']?></td>
                                <td style="max-width: 1000px;"><?php echo $value['ChamadoAvaliacao']['descricao']?></td>
                                <td><span class="badge badge-pill badge-<?php echo $classScore; ?>"><?php echo $value['ChamadoAvaliacao']['score']?></span></td>
                                <td><?php echo $arrStatus[$value['ChamadoAvaliacao']['id_resolvido']]?></td>
                                <td style="max-width: 1000px;"><?php echo $value['ChamadoAvaliacao']['motivo_resolvido']?></td>
                                <td><?php echo date('d/m/y H:i', strtotime($value['ChamadoAvaliacao']['data_avaliacao']));?></td>
                                <td><?php echo $value['Chamado']['NMSUPORTET']?></td>
                            </tr>
                            <?php $attr++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
<!--            </div>-->
            <p class="hidden-print">
                <?php
                echo $this->Paginator->counter(array(
                    'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de {:count} no total, iniciando no registro {:start}, terminando em {:end}')
                ));
                ?>
            </p>

            <div class="pagination hidden-print" style="margin-bottom:50px">
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
    <?php

        $percPositiva = number_format(($countPositiva/$count)*100, 2, ',', '.');
        $percNeutra   = number_format(($countNeutra/$count)*100, 2, ',', '.');
        $percNegativa = number_format(($countNegativa/$count)*100, 2, ',', '.');

        $nps      = (($countPositiva/$count)*100) - (($countNegativa/$count)*100);
        $npsBg    = '';
        $labelNps = '';

        if ($nps < 0) {
            // -100 a -0
            $labelNps = 'Crítica';
            $npsBg    = '#DC3545';
        } elseif($nps >=0 and $nps <= 49) {
            // 0 a 49
            $labelNps = 'de Aperfeiçoamento';
            $npsBg    = '#FFC107';
        } elseif($nps >=50 and $nps <= 74){
            // 50 a 74
            $labelNps = 'de Qualidade';
            $npsBg    = '#00D3EE';
        } elseif($nps >=75 and $nps <= 100) {
            // 75 a 100
            $labelNps = 'de Excelência';
            $npsBg    = '#28A745';
        }

    ?>
    <div class="navbar navbar-fixed-bottom hidden-phone hidden-print" id="status" style="bottom:40px;background:#e1e1e1">
        <div class="btn-toolbar" style="color:#333">
            <div class="container">
                <div class="bs-docs-grid">
                    <div class="row-fluid">
                        <div class="span3" style="background:#fff;margin-left:5px;box-shadow:0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2)">
                            <div style="float:left;width:30%;background:#28A745;color:#fff;height:70px"><div style="padding:5px;text-align:center;margin-top:15px">Positivas</div></div>
                            <div style="float:right;width:68%">
                                <div>
                                    <div style="text-align:center;font-size:11px; color:#696969"><em>Score entre 9 e 10</em></div>
                                    <div style="text-align:center"><span style="font-size:40px"><?php echo $countPositiva; ?></span><span style="color:#ccc"> (<?php echo $percPositiva; ?>%)</span></div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div class="span3" style="background:#fff;margin-left:5px;box-shadow:0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2)">
                            <div style="float:left;width:30%;background:#FFC107;color:#fff;height:70px"><div style="padding:5px;text-align:center;margin-top:15px">Neutras</div></div>
                            <div style="float:left;width:68%">
                                <div>
                                    <div style="text-align:center;font-size:11px; color:#696969"><em>Score entre 7 e 8</em></div>
                                    <div style="text-align:center"><span style="font-size:40px"><?php echo $countNeutra; ?></span><span style="color:#ccc"> (<?php echo $percNeutra; ?>%)</span></div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                        <div class="span3" style="background:#fff;margin-left:5px;box-shadow:0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2)">
                            <div style="float:left;width:30%;background:#DC3545;color:#fff;height:70px"><div style="padding:5px;text-align:center;margin-top:15px">Negativas</div></div>
                            <div style="float:left;width:68%">
                                <div>
                                    <div style="text-align:center;font-size:11px; color:#696969"><em>Score entre 0 e 6</em></div>
                                    <div style="text-align:center"><span style="font-size:40px"><?php echo $countNegativa; ?></span><span style="color:#ccc"> (<?php echo $percNegativa; ?>%)</span></div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        </div>

                        <div class="span3" style="background:<?php echo $npsBg; ?>;color:#fff;margin-left:5px;box-shadow:0 10px 30px -12px rgba(0, 0, 0, 0.42), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2)">
                            <div style="float:left;width:30%;height:70px"><div style="padding:5px;text-align:center;margin-top:15px;font-size:20px">NPS</div></div>
                            <div style="float:left;width:68%">
                                <div style="margin-right:25px">
                                    <div style="text-align:center;font-size:11px;"><em>Zona <?php echo $labelNps; ?></em></div>
                                    <div style="text-align:center"><span style="font-size:40px"><?php echo number_format($nps); ?></span></div>
                                </div>
                            </div>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function cancelSearch() {
        removeUserSearchCookie();
        window.location = '<?php echo Router::url(array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'listarAvaliacao')); ?>';
    }

    const { getMostRecentBrowserWindow } = require('sdk/window/utils');

    var chromewin = getMostRecentBrowserWindow();
    chromewin.PrintUtils.printPreview(chromewin.PrintPreviewListener);

</script>
