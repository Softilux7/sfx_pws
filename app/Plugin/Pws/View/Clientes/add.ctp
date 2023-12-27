<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="container">
	<h2>
		<?php echo __('Pws Manager: Clientes (Add)'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Clientes','index','Pws') == true){?>
					<li ><?php echo $this->Html->link(__('Clientes'), array('plugin' => 'Pws','controller' => 'clientes','action' => 'index')); ?></li>
				<?php } ?>
					<li class="active"><?php echo $this->Html->link(__('Add Cliente'), '#'); ?></li>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<?php if (count($errors) > 0){ ?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">Ã—</button>
				<?php foreach($errors as $error){ ?>
				<?php foreach($error as $er){ ?>
				<strong><?php echo __('Error!'); ?> </strong>
				<?php echo utf8_encode($er); ?>
				<br />
				<?php } ?>
				<?php } ?>
			</div>
			<?php } ?>
			<?php echo $this->Form->create('Cliente',array('class'=>'form-horizontal')); ?>
			<div class="control-group">
				<label class="control-label"><?php echo utf8_encode(__('Razão Social')); ?><span
					style="color: red;">*</span> </label>
				<div class="controls">
					<?php echo $this->Form->input('razao_social',array('div' => false,'label'=>false,'error'=>false,'class'=>'input-xxsmall')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label"><?php echo __('Fantasia'); ?><span
					style="color: red;">*</span> </label>
				<div class="controls">
					<?php echo $this->Form->input('fantasia',array('div' => false,'label'=>false,'error'=>false,'class'=>'input-xxsmall')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label"><?php echo __('Pessoa Fisica'); ?>
				</label>
				<div class="controls">
				<label class="radio-inline">
					<?php
					$attributes = array('legend' => false, 'div' => false, 'label'=>false, 'error'=>false);
					echo $this->Form->checkbox('pessoa_fisica', array(
							'value' => 'S',
							'hiddenField' => 'N', 'onclick'=> 'desactiva(this);'
					),$attributes);
					 ?>
				</label>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label"><?php echo __('CNPJ'); ?>
				</label>
				<div class="controls">
					<?php echo $this->Form->input('cnpj',array('div' => false,'label'=>false,'disabled'=>false,'error'=>false,'class'=>'input-xxsmall')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<label class="control-label"><?php echo __('CPF'); ?>
				</label>
				<div class="controls">
					<?php echo $this->Form->input('cpf',array('div' => false,'label'=>false,'disabled'=>true,'error'=>false,'class'=>'input-xxsmall')); ?>
				</div>
			</div>
			
			<div class="form-actions">
				<input type="submit" class="btn btn-primary"
					value="<?php echo __('Salvar Cliente'); ?>" /> <input type="button"
					class="btn" value="<?php echo __('Cancelar'); ?>"
					onclick="cancel_add();" />
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
	function cancel_add() {
		window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'clientes','action' => 'index')); ?>';
	}
	
	function desactiva(obj) { 

	nForm = document.forms['ClienteAddForm'];

	if(obj.checked){ 
		nForm.elements['ClienteCpf'].disabled = false;
		nForm.elements['ClienteCnpj'].disabled = true;
	 }else{ 
		nForm.elements['ClienteCpf'].disabled = true;
		nForm.elements['ClienteCnpj'].disabled = false;
	}
	} 
	 
</script>
