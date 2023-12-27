<div class="container">
	<h2>
		<?php echo __('Settings: Email (New User)'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Settings','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('General'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'index')); ?></li>
				<?php } ?>
				<?php if ($this->Acl->check('Settings','email','AuthAcl') == true){?>
				<li class="dropdown active">
					<a href="#" data-toggle="dropdown"	class="dropdown-toggle"><?php echo __('Email templates'); ?> <b	class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><?php echo $this->Html->link(__('New User'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'email/new_user')); ?></li>
						<li><?php echo $this->Html->link(__('Reset Password'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'email/reset_password')); ?></li>
					</ul></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<?php echo $this->Form->create('Setting',array('action' => 'save','class'=>'form-horizontal')); ?>

			<?php echo $this->Form->hidden('setting_key'); ?>

			<div class="control-group">
				<label for="email-activate-resend-subj" class="control-label"><?php echo __('Send link'); ?>
				</label>
				<div class="controls">
					<label> <?php echo $this->Form->input('send_link_subject',array('div' => false,'label'=>false,'class' => 'input-xlarge','placeholder'=>__('Subject'))); ?>
						<p class="help-inline">
							<?php echo __('Subject'); ?>
						</p>
					</label>
					<?php echo $this->Form->textarea('send_link_body',array('class' => 'input-xlarge','rows' => 10,'placeholder'=>__('Message body'))); ?>
					<div class="help-inline">
						<p>
							<?php echo __('Message body'); ?>
						</p>
						<br>
						<p>
							<strong><?php echo __('Shortcodes:'); ?>
							</strong>
						</p>
						<p>
							<?php echo __('Site address:'); ?>
							<code>{site_address}</code>
						</p>
						<p>
							<?php echo __('Full name:'); ?>
							<code>{user_name}</code>
						</p>
						<p>
							<?php echo __('User email:'); ?>
							<code>{user_email}</code>
						</p>
						<p>
							<?php echo __('Activation link:'); ?>
							<code>{activation_link}</code>
						</p>
					</div>
				</div>
			</div>


			<div class="control-group">
				<label for="email-activate-subj" class="control-label"><?php echo __('Activated'); ?>
				</label>
				<div class="controls">
					<label> <?php echo $this->Form->input('activated_subject',array('div' => false,'label'=>false,'class' => 'input-xlarge','placeholder'=>__('Subject'))); ?>
						<p class="help-inline">
							<?php echo __('Subject'); ?>
						</p>
					</label>
					<?php echo $this->Form->textarea('activated_body',array('class' => 'input-xlarge','rows' => 11,'placeholder'=>__('Message body'))); ?>
					<div class="help-inline">
						<p>
							<?php echo __('Message body'); ?>
						</p>
						<br>
						<p>
							<strong><?php echo __('Shortcodes:'); ?>
							</strong>
						</p>
						<p>
							<?php echo __('Site address:'); ?>
							<code>{site_address}</code>
						</p>
						<p>
							<?php echo __('Full name:'); ?>
							<code>{user_name}</code>
						</p>
						<p>
							<?php echo __('User email:'); ?>
							<code>{user_email}</code>
						</p>
					</div>
				</div>
			</div>

			<?php if ($this->Acl->check('Settings','save','AuthAcl') == true){?>
			<div class="form-actions">
				<button type="button" class="btn btn-info"
					onclick="save_setting();">
					<?php echo __('Save changes'); ?>
				</button>
			</div>
			<?php } ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
function save_setting(){
	$.post($('#SettingSaveForm').attr('action'),$('#SettingSaveForm').serialize(),function(o){
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
			+ '<button data-dismiss="alert" class="close" type="button">×</button>'
			+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the setting'); ?>'
			+ '</div>';
		var alertSuccess = $(strAlertSuccess).appendTo('body');
		alertSuccess.show();
		setTimeout(function() {
			alertSuccess.remove();
		}, 2000);
	},'json');
}
</script>
