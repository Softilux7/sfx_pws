<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<legend><?php echo __('Create a new AuthAcl Account'); ?></legend>
			<?php if (!empty($errors)){ ?>
            <div class="alert alert-error">
                <?php foreach($errors as $error){  ?>
	                <div>
						<strong><?php echo __('Error!'); ?> </strong>
						<?php echo h(implode('<br />', $error)); ?>
					</div>
                <?php } ?>
            </div>   
            <?php } ?>
			<?php echo $this->Form->create('User', array('action' => 'signup','class'=>' form-signin')); ?>
			<div class="control-group">
              <label  class="control-label"><?php echo __('Full Name'); ?></label>
              <div class="controls">
                <?php echo $this->Form->input('user_name',array('div' => false,'label'=>false,'placeholder'=>__('Full Name'),'error'=>false,'class' => 'span4')); ?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label"><?php echo __('Email'); ?> </label>
              <div class="controls">
                <?php echo $this->Form->input('user_email',array('div' => false,'label'=>false,'placeholder'=>__('Email address'),'error'=>false,'class' => 'span4')); ?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label"><?php echo __('Password'); ?></label>
              <div class="controls">
                <?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'placeholder'=>__('Password'),'error'=>false,'class' => 'span4')); ?>
              </div>
            </div>
            <div class="control-group">
              <label  class="control-label"><?php echo __('Confirm Password'); ?></label>
              <div class="controls">
                <?php echo $this->Form->password('user_confirm_password',array('div' => false,'label'=>false,'placeholder'=>__('Confirm Password'),'error'=>false,'class' => 'span4')); ?>
              </div>
            </div>
	
            <?php if (isset($general['Setting']) && (int)$general['Setting']['enable_recaptcha'] == 1){?>
            <div class="control-group">
              <label  class="control-label">ReCaptcha</label>
              <div class="controls">
              <?php echo $this->Form->hidden('recaptcha',array('value'=>'1')); ?>
                <script type="text/javascript">
					var RecaptchaOptions = {
						theme : 'white'
					};
				</script> 
                <?php 
				$publickey = $general['Setting']['recaptcha_public_key'];
					echo recaptcha_get_html($publickey, null); ?>
              </div>
            </div>
			<?php }?>
			<button type="submit" class="btn btn-large btn-primary">
				<?php echo __('Create my account'); ?>
			</button>
			<div style="padding-top:5px;">
				<label>
					<?php echo $this->Html->link(__('Have an account? Sign in!'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'login')); ?>
				</label>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
