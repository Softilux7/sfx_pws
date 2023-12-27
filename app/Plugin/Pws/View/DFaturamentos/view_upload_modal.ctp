<?php echo $this->Form->create('Upload', array('class' => 'form-horizontal', 'type' => 'file')); ?>
<div >
    <div><?php echo $this->Form->checkbox('sendemail', array('div' => false, 'checked' =>'checked', 'disabled' => '',  'label' => '', 'error' => false,  'class' => '', 'style' => 'min-width:30px')); ?> Enviar email</div>
</div>
<div>
    <div><h5 style="margin-bottom:2px">Empresa</h5></div>
    <div><?php echo $this->Form->select('idEmpresa', $arrEmpresa, array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false));?></div>
</div>
<div>
    <div><h5 style="margin-bottom:2px">Cliente</h5></div>
    <div><?php echo $this->Form->select('idCliente', array(), array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false));?></div>
</div>
<div style="float:left; margin-right:10px">
    <div><h5 style="margin-bottom:2px">Contrato</h5></div>
    <div><?php echo $this->Form->select('idContrato', array(), array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false));?></div>
</div>
<div style="float:left">
    <div><h5 style="margin-bottom:2px">Obs</h5></div>
    <div><?php echo $this->Form->input('obs', array('div' => false, 'label' => false, 'error' => false));?></div>
</div>
<div style="clear:both"></div>
<div style="float:left; margin-right:10px">
    <div><h5 style="margin-bottom:2px">Mês</h5></div>
    <div><?php echo $this->Form->select('idMoth', $moth, array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false));?></div>
</div>
<div style="float:left">
    <div><h5 style="margin-bottom:2px">Ano</h5></div>
    <div><?php echo $this->Form->select('idYear', $year, array('div' => false, 'label' => false, 'required', 'error' => false, 'class' => 'input-xxsmall', 'empty' => false));?></div>
</div>
<div style="clear:both"></div>
<div style="margin-top:15px;">
    <input type="file" name="files[]" multiple>
</div>
<div><em>Somente arquivos PDF</em></div>
<div style="margin-top:20px">
    <div class="progress">
      <div class="progress-bar" id="progressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;background:#53A753;color:#fff;font-size: 12px;height: 19px;line-height: 17px;text-align:center">0%</div>
    </div>
</div>
<?php echo $this->Form->end(); ?>