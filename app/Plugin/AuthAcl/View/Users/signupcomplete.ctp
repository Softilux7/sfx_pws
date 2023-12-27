<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<h3>Thank You!</h3> You have been registered, 
			<?php if (isset($general['Setting']) && (int)$general['Setting']['require_email_activation'] == 1){?>
			 you have been sent an e-mail to the address you specified before.
			 Please check your e-mails to activate your account.
			 <?php } ?>
			 <?php echo $this->Html->link(__('Sign in'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'login')); ?>.
		</div>
	</div>
</div>