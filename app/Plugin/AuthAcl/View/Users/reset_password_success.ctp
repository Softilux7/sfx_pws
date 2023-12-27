<div class="container">
	<div class="row">
		<div class="span4 offset4 well">
			<h3>Obrigado!</h3> Sucesso ao resetar sua senha. Agora você pode acessar o sistema
			 <?php echo $this->Html->link(__('Sign in'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'login')); ?>.
		</div>
	</div>
</div>