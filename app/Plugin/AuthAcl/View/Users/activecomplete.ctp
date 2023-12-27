<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<h3>Thank You!</h3> Your account is activated. You may now 
			 <?php echo $this->Html->link(__('Sign in'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'login')); ?>.
		</div>
	</div>
</div>