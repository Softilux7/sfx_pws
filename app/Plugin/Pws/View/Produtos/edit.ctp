<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="container">
	<h2>
		<?php echo __('Pws: Produtos (Edit)'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Produtos','index','Pws') == true){?>
					<li><?php echo $this->Html->link(__('Produtos'), array('plugin' => 'Pws','controller' => 'produtos','action' => 'index')); ?></li>
				<?php }?>
					<li class="active"><?php echo $this->Html->link(__('Edit Produto'),'#'); ?></li>
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
				<?php echo h($er); ?>
				<br />
				<?php } ?>
				<?php } ?>
			</div>
			<?php } ?>
			<?php echo $this->Form->create('Produto',array('class'=>'form-horizontal')); ?>
			<div class="control-group">
				<label class="control-label"><?php echo utf8_encode(__('Código do Produto')); ?><span
					style="color: red;">*</span> </label>
				<div class="controls">
					<?php echo $this->Form->input('cdproduto',array('div' => false,'label'=>false,'error'=>false,'class'=>'input-smal')); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label"><?php echo __('Nome do Produto'); ?><span
					style="color: red;">*</span> </label>
				<div class="controls">
					<?php echo $this->Form->input('produto_nome',array('div' => false,'label'=>false,'error'=>false,'class'=>'input-xxlarge')); ?>
				</div>
			</div>

			<div class="form-actions">
				<input type="submit" class="btn btn-primary"
					value="<?php echo __('Salvar Produto'); ?>" /> <input type="button"
					class="btn" value="<?php echo __('Cancelar'); ?>"
					onclick="cancel_add();" />
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
	function cancel_add() {
		window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'produtos','action' => 'index')); ?>';
	}
</script>