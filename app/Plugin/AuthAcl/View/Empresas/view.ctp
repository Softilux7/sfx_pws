<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="container">
	<h2>
		<?php echo __('Pservice Manager: Clientes (view)'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Clientes','index','Pws') == true){?>
					<li ><?php echo $this->Html->link(__('Clientes'), array('plugin' => 'ass_tec','controller' => 'clientes','action' => 'index')); ?></li>
				<?php } ?>
					<li class="active"><?php echo $this->Html->link(__('Cliente'), '#'); ?></li>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<form class="form-horizontal">
				<div class="control-group">
					<label class="control-label"><?php echo __('Id'); ?>
					</label>
					<div class="controls">
						<?php echo h($cliente['Cliente']['id']); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo __('Razao Social'); ?>
					</label>
					<div class="controls">
						<?php echo h($cliente['Cliente']['razao_social']); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo __('Nome Fantasia'); ?>
					</label>
					<div class="controls">
						<?php echo h($cliente['Cliente']['fantasia']); ?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo __('Pessoa Fisica'); ?>
					</label>
					<div class="controls">
						<?php
						if ($cliente ['Cliente'] ['pessoa_fisica'] == 'N') {
							echo utf8_encode('Não');
						} else {
							echo 'Sim';
						}
						?>
					</div>
				</div>
				<?php if ($cliente['Cliente']['pessoa_fisica']=='N'):?>
				<div class="control-group">
					<label class="control-label"><?php echo __('Cnpj'); ?>
					</label>
					<div class="controls">
						<?php echo h($cliente['Cliente']['cnpj']); ?>
					</div>
				</div>
				<?php else : ?>
								<div class="control-group">
					<label class="control-label"><?php echo __('Cpf'); ?>
					</label>
					<div class="controls">
						<?php echo h($cliente['Cliente']['cpf']); ?>
					</div>
				</div>
				<?php endif;?>
				<div class="form-actions">
					<?php echo $this->Acl->link(__('Edit'), array('action' => 'edit', $cliente['Cliente']['id']),array('class'=>'btn  btn-primary')); ?>
					<a class="btn " onclick="cancel_add();"><?php echo __('Cancel'); ?>
					</a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function cancel_add() {
		window.location = '<?php echo Router::url(array('plugin' => 'ass_tec','controller' => 'clientes','action' => 'index')); ?>';
	}
</script>
