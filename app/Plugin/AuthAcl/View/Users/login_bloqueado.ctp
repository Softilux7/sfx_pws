<div class="container">
<br/>
<div class="center">
<fieldset></fieldset>
</div>
	<div class="row">
		<div class="span4 offset4">
			<div class="panel panel-default">
				<div class="panel-heading text-center">
					<img src="<?php echo $this->webroot; ?>img/PWS_logo.png" title="PWS" alt="PWS Login">
					<h2><small><?php echo (__('Portal Web de Serviços')); ?></small></h2>
				</div>
				<div class="panel-body">
					<strong>Atenção,</strong></br> seu acesso está temporariamente suspenso, entre em contato com a <strong><?php echo $_SESSION['auth_user']['Empresa'][0]['empresa_fantasia'];?></strong> no telefone <strong><?php echo $_SESSION['auth_user']['Empresa'][0]['ddd'] . ' ' . $_SESSION['auth_user']['Empresa'][0]['fone'];?></strong>
				</div>
				<div class="panel-footer">
					<button class="btn btn-large btn-success btn-block" name="submit" type="submit" onclick="RedirectLogin()"><i class="fa fa-arrow-left"></i>&nbsp;<?php echo __('Voltar para o login'); ?></button>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function RedirectLogin(){
		window.location.href = "<?php echo $this->Html->url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'logout')); ?>"
	}
</script>

