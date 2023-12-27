<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="container">
	<h2>
		<?php echo __('Pws: Territorios (Add)'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Territorios','index','Pws') == true){?>
					<li><?php echo $this->Html->link(__('Territorios'), array('plugin' => 'Pws','controller' => 'territorios','action' => 'index')); ?></li>
				<?php }?>
					<li class="active"><?php echo $this->Html->link(__('Add Territorio'),'#'); ?></li>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<?php if (count($errors) > 0){ ?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">×</button>
				<?php foreach($errors as $error){ ?>
				<?php foreach($error as $er){ ?>
				<strong><?php echo __('Error!'); ?> </strong>
				<?php echo h($er); ?>
				<br />
				<?php } ?>
				<?php } ?>
			</div>
			<?php } ?>
			<?php echo $this->Form->create('Territorio',array('class'=>'form-horizontal')); ?>
			<div class="control-group">
				<label class="control-label"><?php echo __('Nome do Territorio'); ?><span
					style="color: red;">*</span> </label>
				<div class="controls">
					<?php echo $this->Form->input('territorio_nome',array('div' => false,'label'=>false,'error'=>false,'class'=>'input-xxlarge')); ?>
				</div>
			</div>
			<div class="control-group">
				<label for="inputEmail" class="control-label"><?php echo __('Status'); ?>
				</label>
				<div class="controls">
					<?php echo $this->Form->checkbox('status',array('div' => false,'label'=>false)); ?>
				</div>
			</div>			
			<div class="form-actions">
				<input type="submit" class="btn btn-primary"
					value="<?php echo __('Salvar Territorio'); ?>" /> <input type="button"
					class="btn" value="<?php echo __('Cancelar'); ?>"
					onclick="cancel_add();" />
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
	function cancel_add() {
		window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'territorios','action' => 'index')); ?>';
	}
</script>