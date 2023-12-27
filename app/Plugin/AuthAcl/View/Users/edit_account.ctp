<div class="container">
	<h2>
		<?php echo __('Meu Perfil'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#"><?php echo __('Editar Conta'); ?></a></li>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<?php if (count($errors) > 0){ ?>
                <div class="alert alert-error">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <?php foreach ($errors as $error) { ?>
                        <?php foreach ($error as $er) { ?>
                            <strong><?php echo __('Erro!'); ?>
                            </strong>
                            <?php echo h($er); ?>
                            <br/>
                        <?php } ?>
                    <?php } ?>
                </div>
			<?php } ?>
			<?php echo
			$this->Form->create('User',array('class'=>'form-horizontal')); ?>
			<div class="control-group <?php if (array_key_exists('user_email', $errors)){ echo 'error'; } ?>">
				<label for="inputEmail" class="control-label"><?php echo __('Email'); ?></label>
				<div class="controls">
					<?php echo $this->Form->input('user_email',array('div' => false,'label'=>false,'error'=>false,'readonly'=>'readonly')); ?>
				</div>
			</div>

			<?php if($changePassword) {?>

				<div class="control-group <?php if (array_key_exists('user_password', $errors)){ echo 'error'; } ?>">
					<label for="inputEmail" class="control-label"><?php echo __('Senha'); ?></label>
					<div class="controls">
						<?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'error'=>false)); ?>
					</div>
				</div>

				<div class="control-group <?php if (array_key_exists('user_confirm_password', $errors)){ echo 'error'; } ?>">
					<label for="inputEmail" class="control-label"><?php echo __('Confirmar Senha'); ?></label>
					<div class="controls">
						<?php echo $this->Form->password('user_confirm_password',array('div' => false,'label'=>false,'error'=>false)); ?>
					</div>
				</div>

			<?php }?>

			<div class="control-group <?php if (array_key_exists('user_name', $errors)){ echo 'error'; } ?>">
				<label for="inputEmail" class="control-label"><?php echo __('Nome'); ?>
                    <span style="color: red;">*</span>
				</label>
				<div class="controls">
					<?php echo $this->Form->input('user_name',array('div' => false,'label'=>false,'class' => 'input-xlarge','error'=>false)); ?>
				</div>
			</div>

			<div class="form-actions">
				<input type="button" class="btn btn-info"
					value="<?php echo __('Salvar'); ?>" onclick="editAccount();" />
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script>
	function editAccount(){
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'editAccount')); ?>',$('#UserEditAccountForm').serialize(),function(o){
			if (o.error === 0){
				var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:65px; display: none;">'
					+ '<button data-dismiss="alert" class="close" type="button">×</button>'
					+ '<strong><?php echo __('Sucesso!'); ?></strong> <?php echo __('Você editou sua conta com sucesso'); ?>'
					+ '</div>';
				var alertSuccess = $(strAlertSuccess).appendTo('body');
				alertSuccess.show();
				setTimeout(function() {
					alertSuccess.remove();
				}, 2000);
			} else {
				var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:0px; top:65px; display: none;">'
					+ '<button data-dismiss="alert" class="close" type="button">×</button>'
					+ o.error_message +
					+ '</div>';
				var alertSuccess = $(strAlertSuccess).appendTo('body');
				alertSuccess.show();
				setTimeout(function() {
					alertSuccess.remove();
				}, 3000);
			}
		},'json');
	}
</script>
