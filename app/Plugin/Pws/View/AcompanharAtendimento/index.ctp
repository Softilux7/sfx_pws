<div style="float:left;width:19%;background:#fff;margin-right:4px;padding:3px 3px 20px 3px;border: 1px solid #d8dadc;">
    <div style="padding:5px 10px">
        <h3 style="border-bottom: 1px solid #eee;">Filtro</h3>
    </div>
    <div style="margin-left: 15px;">
        <div class="controls">
            <?php echo $this->Form->input('chamado_id', array('type' => 'text', 'div' => false, 'label' => 'Chamado Web', 'error' => false)); ?>
        </div>
        <div class="controls">
            <?php echo $this->Form->input('SEQOS', array('type' => 'text', 'div' => false, 'label' => 'Chamado Ilux', 'error' => false)); ?>
        </div>
        <div class="controls">
            <label for="status">Status</label>
            <?php echo $this->Form->select('ANDAMENTO_CHAMADO_APP', $arrStatus, array('div' => false, 'label' => 'Status', 'error' => false, 'class' => 'input-xxsmall', 'empty' => 'Todos')); ?>
        </div>
        <div class="controls">
            <label for="cliente">Cliente</label>
            <?php echo $this->Form->select('CDCLIENTE', $arrCliente, array('div' => false, 'label' => 'Cliente', 'error' => false, 'class' => 'input-xxsmall', 'empty' => 'Todos')); ?>
        </div>
        <div class="controls">
            <label for="cliente">Técnico</label>
            <?php echo $this->Form->select('NMATENDENTE', $arrTecnico, array('div' => false, 'label' => 'Status', 'error' => false, 'class' => 'input-xxsmall', 'empty' => 'Todos')); ?>
        </div>
        <div>
            <div class="controls" style="float:left;width:50%">
                <?php echo $this->Form->input('periodoIni', array('type' => 'text', 'div' => false, 'required', 'label' => 'Período inicial', 'error' => false, 'style' => 'width: 67px')); ?>
            </div>
            <div class="controls" style="float:left;width:50%">
                <?php echo $this->Form->input('periodoFim', array('type' => 'text', 'div' => false, 'required', 'label' => 'Período final', 'error' => false, 'style' => 'width: 67px')); ?>
            </div>
            <div style="clear:both"></div>
        </div>
        <div>
            <button type="submit" class="btn btn-large btn-success" id="buttonFilter"><i class="fa fa-filter" aria-hidden="true"></i> Filtrar </button>
            <button type="submit" class="btn btn-large btn-danger" id="buttonFilterClear"><i class="fa fa-trash" aria-hidden="true"></i> Limpar filtro </button>
        </div>
        <!-- <div>
            <input type="checkbox" style="margin-top:-2px"> Gerar relatório
        </div> -->
    </div>
</div>
<div style="float:left;width:79%;">
    <div style="padding-bottom: 4px;line-height:22px">
        <div style="float:left;width:25%;background:#fff;border:1px solid #e1e1e1;border-right:0px;">
            <div style="padding:5px;min-height: 72px;">
                <div style="float:left;width:30%;text-align:right;padding-top: 8px;"><i class="fa fa-car fa-2x" aria-hidden="true"></i></div>
                <div style="float:left;width:45%;margin-left:25px">
                    <div style="font-size: 25px;padding-top: 4px;" id="value_rota">0</div>
                    <div style="font-size: 12px;color:#999">Em rota</div>
                </div>
                <div style="clear:both"></div>
                <div id="atendente_rota"></div>
            </div>
        </div>
        <div style="float:left;width:25%;background:#fff;border:1px solid #e1e1e1;border-right:0px;">
            <div style="padding:5px;min-height: 72px;">
                <div style="float:left;width:30%;text-align:right;padding-top: 8px;"><i class="fa fa-street-view fa-2x" aria-hidden="true"></i></div>
                <div style="float:left;width:45%;margin-left:25px">
                    <div style="font-size: 25px;padding-top: 4px;" id="value_cliente">0</div>
                    <div style="font-size: 12px;color:#999">Chegou no cliente</div>
                </div>
                <div style="clear:both"></div>
                <div id="atendente_cliente"></div>
            </div>
        </div>
        <div style="float:left;width:25%;background:#fff;border:1px solid #e1e1e1;border-right:0px;">
            <div style="padding:5px;min-height: 72px;">
                <div style="float:left;width:30%;text-align:right;padding-top: 8px;"><i class="fa fa-hourglass-half fa-2x" aria-hidden="true"></i></div>
                <div style="float:left;width:45%;margin-left:25px">
                    <div style="font-size: 25px;padding-top: 4px;" id="value_atendimento">0</div>
                    <div style="font-size: 12px;color:#999">Em atendimento</div>
                </div>
                <div style="clear:both"></div>
                <div id="atendente_atendimento"></div>
            </div>
        </div>
        <div style="float:left;width:24%;background:#fff;border:1px solid #e1e1e1;;">
            <div style="padding:5px;min-height: 72px;">
                <div style="float:left;width:30%;text-align:right;padding-top: 8px;"><i class="fa fa-check-circle fa-2x" aria-hidden="true"></i></div>
                <div style="float:left;width:45%;margin-left:25px">
                    <div style="font-size: 25px;padding-top: 4px;" id="value_finalizado">0</div>
                    <div style="font-size: 12px;color:#999">Finalizado</div>

                </div>
                <div style="clear:both"></div>
                <div id="atendente_finalizado" style="overflow:auto"></div>
            </div>
        </div>

        <div style="clear:both"></div>
    </div>
    <div style="background:#fff;padding:3px;border: 1px solid #d8dadc;">
        <table id="grid-selection" class="table table-condensed table-hover table-striped">
            <thead>
                <tr>
                    <th data-column-id="id" style="width: 20px" data-type="numeric" data-identifier="true" data-visible="false">ID</th>
                    <!-- <th data-column-id="agendamento" data-visible="false">Agendamento</th> -->
                    <th data-column-id="tecnico" data-order="desc">Técnico</th>
                    <th data-column-id="status" data-order="desc">Status</th>
                    <!-- <th data-column-id="avaliacao" data-order="desc">Avaliação</th> -->
                    <th data-column-id="cliente" data-sortable="false">Cliente</th>
                    <th data-column-id="idChamado" data-sortable="false">Chamado</th>
                    <!--<th data-column-id="fase" data-sortable="false">Fase</th>-->
                    <th data-column-id="inicio" data-sortable="false">Início</th>
                    <!--<th data-column-id="prazo" data-sortable="false">Prazo</th>-->
                    <!--<th data-column-id="regiao" data-sortable="false">Região</th>-->
                    <!--<th data-column-id="tempo" data-sortable="false">Tempo</th>-->
                    <th data-column-id="timeline" data-formatter="timeline" data-sortable="false">Timeline</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div style="clear:both"></div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJzqCIQ3uPa_gK3-VG3LhHNDB-pWL09ho&callback=initMap" type="text/javascript"></script>
