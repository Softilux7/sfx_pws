<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="container">
	<h2>
		<?php echo __('User Manager: Users (Add)'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Users','index','AuthAcl') == true){?>
					<li class="active"><?php echo $this->Html->link(__('User Manager'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?></li>
				<?php } ?>
				<?php if ($this->Acl->check('Groups','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('Groups'), array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?></li>
				<?php }?>
				<?php if ($this->Acl->check('Permissions','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('Permissions'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<form class="form-horizontal">
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Email'); ?>
					</label>
					<div class="controls">
						<?php echo h($user['User']['user_email']); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Password'); ?>
					</label>
					<div class="controls">******</div>
				</div>

				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Name'); ?>
					</label>
					<div class="controls">
						<?php echo h($user['User']['user_name']); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Cliente Relacionado'); ?>
					</label>
					<div class="controls">
						<?php echo 'ID: '. h($user['Cliente']['id']) . '/' .h($user['Cliente']['cdcliente']) .' - '. h($user['Cliente']['fantasia']); ?>
					</div>
				</div>

				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Groups'); ?>
					</label>
					<div class="controls">
						<?php
						$groupNames = array();
						if (!empty($user['Group'])){
									foreach($user['Group'] as $group){
										$groupNames[] = $group['name'];
									}
								}
								echo implode(',',$groupNames);
							 ?>
					</div>
				</div>

				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Status'); ?>
					</label>
					<div class="controls">
						<?php  if ((int) $user['User']['user_status'] == 0) { ?>
						<img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
						<?php }else{ ?>
						<img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
						<?php } ?>
					</div>
				</div>

				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Created'); ?>
					</label>
					<div class="controls">
						<?php echo h($user['User']['created']); ?>
					</div>
				</div>
				<div class="control-group">
					<label for="inputEmail" class="control-label"><?php echo __('Modified'); ?>
					</label>
					<div class="controls">
						<?php echo h($user['User']['modified']); ?>
					</div>
				</div>

				<div class="form-actions">
					<?php echo $this->Acl->link(__('Edit'), array('action' => 'edit', $user['User']['id']),array('class'=>'btn  btn-primary')); ?>
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

