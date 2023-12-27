<div class="container">
	<h2>
		<?php echo __('Settings: General'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Settings','index','AuthAcl') == true){?>
					<li class="active"><?php echo $this->Html->link(__('General'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'index')); ?></li>
				<?php } ?>
				<?php if ($this->Acl->check('Settings','email','AuthAcl') == true){?>
				<li class="dropdown">
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
			<legend>
				<?php echo __('General Options'); ?>
			</legend>
			<div class="control-group">
				<label class="control-label" for="SettingEmailAddress"><?php echo __('Admin Email'); ?><span
					style="color: red;">*</span>
				</label>
				<div class="controls">
					<?php echo $this->Form->input('email_address',array('div' => false,'label'=>false,'placeholder'=>__('Email address'),'class' => 'input-xlarge')); ?>
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="SettingDefaultGroup"><?php echo __('Default Group'); ?>
				</label>
				<div class="controls">
					<?php echo $this->Form->select('default_group', $groups);?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">&nbsp;</label>
				<div class="controls">
					<label class="checkbox" for="SettingDisableRegistration"
						style="width: 160px;"> <?php echo $this->Form->checkbox('disable_registration',array('div' => false,'label'=>false)); ?>
						<?php echo __('Disable registrations'); ?>
					</label> <label class="checkbox" for="SettingDisableResetPassword"
						style="width: 170px;"> <?php echo $this->Form->checkbox('disable_reset_password',array('div' => false,'label'=>false)); ?>
						<?php echo __('Disable reset password'); ?>
					</label> <label class="checkbox"
						for="SettingRequireEmailActivation" style="width: 250px;"> <?php echo $this->Form->checkbox('require_email_activation',array('div' => false,'label'=>false)); ?>
						<?php echo __('Require email activation for new users'); ?>
					</label>
				</div>
			</div>
			<legend>
				<?php echo __('ReCaptcha Options'); ?>
			</legend>
			<div class="control-group">
				<label class="control-label" for="inputEmail">&nbsp;</label>
				<div class="controls">
					<label class="checkbox" for="SettingEnableRecaptcha"
						style="width: 90px;"> <?php echo $this->Form->checkbox('enable_recaptcha',array('div' => false,'label'=>false)); ?>
						<?php echo __('Enable'); ?>
					</label>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="SettingRecaptchaPublicKey"><?php echo __('Public Key'); ?>
				</label>
				<div class="controls">
					<?php echo $this->Form->input('recaptcha_public_key',array('div' => false,'label'=>false,'placeholder'=>__('Public Key'),'class' => 'input-xxlarge')); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="recaptcha_private_key"><?php echo __('Private Key'); ?>
				</label>
				<div class="controls">
					<?php echo $this->Form->input('recaptcha_private_key',array('div' => false,'label'=>false,'placeholder'=>__('Private Key'),'class' => 'input-xxlarge')); ?>
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
		if (o.error == 0){
			$('#SettingEmailAddress').parent().parent().removeClass('error');
			var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the setting'); ?>'
				+ '</div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}else if (o.error == 1){
			$('#SettingEmailAddress').parent().parent().addClass('error');
			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Error!'); ?></strong> '+o.error_message
				+ '</div>';
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}
	},'json');
}
</script>

