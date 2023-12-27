<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="container">
	<h2>
		<?php echo __('Territorios (View)'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Territorios','index','AuthAcl') == true){?>
					<li class="active"><?php echo $this->Html->link(__('Territorios'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<form class="form-horizontal">
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Id'); ?>
					</label>
					<div class="controls">
						<?php echo h($territorio['Territorio']['id']); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Territorio Nome'); ?>
					</label>
					<div class="controls"><?php echo h($territorio['Territorio']['territorio_nome']); ?></div>
				</div>
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Status'); ?>
					</label>
					<div class="controls">
						<?php  if ((int) $territorio['Territorio']['status'] == 0) { ?>
						<img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
						<?php }else{ ?>
						<img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
						<?php } ?>
					</div>
				</div>

				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Criado Em:'); ?>
					</label>
					<div class="controls">
						<?php
						     echo date('d/m/Y H:i:s',strtotime($territorio['Territorio']['created'])); 
						     ?>
					</div>
				</div>
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo utf8_encode('Ultima Alteração:'); ?>
					</label>
					<div class="controls">
						<?php 
						echo date('d/m/Y H:i:s',strtotime($territorio['Territorio']['modified']));
						 ?>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Acl->link(__('Edit'), array('action' => 'edit', $territorio['Territorio']['id']),array('class'=>'btn  btn-primary')); ?>
					<a class="btn " onclick="cancel_add_user();"><?php echo __('Cancel'); ?>
					</a>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	function cancel_add_user() {
		window.location = '<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?>';
	}
</script>

