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
					<p>			<?php echo $this->Form->create('User', array('action' => 'login','class'=>' form-signin')); ?>
						<?php if (!empty($error)) {?>
					<div class="alert alert-error"><?php echo $error;?></div>
					<?php } ?>
					<div class="control-group">
						<div class="input-prepend">
							<span class="add-on"><i class="fa fa-envelope-o"></i></span>
							<?php echo $this->Form->input('user_email',array('div' => false,'id'=>'prependedInput','label'=>false,'placeholder'=>(__('Endereço de Email')),'class'=>'input-xlarge','required')); ?>
						</div>
					</div>
					<div class="control-group">
						<div class="input-prepend">
							<span class="add-on"><i class="fa fa-lock"></i></span>
							<?php echo $this->Form->password('user_password',array('div' => false,'label'=>false,'placeholder'=>__('Senha'),'class'=>'input-xlarge','required')); ?>
						</div>
					</div>
					<label class="checkbox inline" for="remember_me">
						<?php echo $this->Form->checkbox('remember_me',array('div' => false,'label'=>false)); ?>
						<?php echo __('Lembrar de mim'); ?>
					</label>
					<div style="padding-top:5px;"> 
						<?php if (isset($general['Setting']) && (int)$general['Setting']['disable_reset_password'] == 0){?>
							<label>
								<a href="#" onclick='resetPassword(); return false;'><?php echo (__('Não consegue acessar sua conta?')); ?></a>
							</label>
						<?php }?>
						<?php if (isset($general['Setting']) && (int)$general['Setting']['disable_registration'] == 0){?>
							<label>
								<?php echo $this->Html->link(__('Criar uma nova Conta'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'signup')); ?>
							</label>
						<?php }?>
						
					</div>
					</p>
				</div>
				<div class="panel-footer">
					<button class="btn btn-large btn-success btn-block" name="submit" type="submit"><i class="fa fa-sign-in"></i>&nbsp;<?php echo __('Entrar'); ?></button>
					<?php echo $this->Form->end(); ?>
				</div>
				<div class="panel-footer">
					<div style="font-size:11px;line-height: 20px">
						<a target="_blank" href="<?php echo $this->webroot; ?>/files/lgpd/politica_de_privacidade.pdf">Política de privacidade</a>, 
						<a target="_blank" href="<?php echo $this->webroot; ?>/files/lgpd/termo_de _consentimento_para_tratamento_de_dados.pdf">Termo de consentimento para tratamento de dados</a>, 
						<a target="_blank" href="<?php echo $this->webroot; ?>/files/lgpd/termos_e_condicoes_gerais_de_uso.pdf">Termos e condições gerais de uso</a>
					</div>
					<div style="text-align: center; font-size: small;">
						<?php echo __('&copy; powered by Softilux 2016'); ?>
					</div>
				</div>
			</div>



		</div>
	</div>
</div>

<script>
<?php if (isset($general['Setting']) && (int)$general['Setting']['disable_reset_password'] == 0){?>
function resetPassword() {
	var step = 1;
    var mId = $.sModal({
    	header:'<?php echo __('Redefinir Senha'); ?>',
    	width:450,
        form:[
			{label:'<?php echo __('Endereço de email'); ?>',type:'text',name:'user_email',attr:{'placeholder':'Endereço de email',style:'width:300px;'}}
              ],
        animate: 'fadeDown',
        buttons: [{
            text: ' <?php echo __('Enviar'); ?> ',
            addClass: 'btn-primary',
            click: function(id, data) {
            	if (step === 1){
	            	var btnSubmit = $('#'+id).children('.modal-footer').children('a');
	            	btnSubmit.attr({disabled:'disabled'});
	            	btnSubmit.text('<?php echo __('Carregando...'); ?>');
	            	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'users','action' => 'resetPassword')); ?>',{data:{User:{user_email:$('#'+id).find('#user_email').val()}}},function(o){
	            		if (o.send_link === 1){
		            		btnSubmit.attr({disabled:false});
		                	btnSubmit.text('<?php echo __('Fechar'); ?>');
		                	$('#'+id).children('.modal-body').children('div').html('<div class="alert alert-success" style="padding:8px;"><?php echo __('Enviamos um e-mail com as instruções de redefinição de senha. Por favor verifique seu email.'); ?></div>');
		                	step =2;
	            		}else if (o.send_link === -1){
							btnSubmit.attr({disabled:false});
		                	btnSubmit.text(' <?php echo __('Encaminhar'); ?> ');
	            			step =1;
	            			$('#'+id).find('.alert-error').remove();
	            			$('#'+id).children('.modal-body').children('div').prepend('<div class="alert alert-error" style="padding:8px;"><strong>Atenção!</strong> Você não tem permissão para alterar senha. Envie um email para <strong>' + o.email_admin + '</strong></div>');
						}else{
	            			btnSubmit.attr({disabled:false});
		                	btnSubmit.text(' <?php echo __('Encaminhar'); ?> ');
	            			step =1;
	            			$('#'+id).find('.alert-error').remove();
	            			$('#'+id).children('.modal-body').children('div').prepend('<div class="alert alert-error" style="padding:8px;"><?php echo __('<strong>Erro</strong> !, Por favor, forneça um endereço de e-mail correto.'); ?></div>');
	            		}
	            	},'json');
            	}else if (step == 2){
            		$.sModal('close', id);
            	}
            }
        }]
        });
    $('#'+mId).find('input[type="text"]').each(function(){
		$(this).keypress(function(event){
			 if ( event.which == 13 ) {
			 	event.preventDefault();
			 }
		});
	});
}
<?php } ?>
$(document).ready(function(){
	$('#authMessage').each(function(){
		var errors = $('<div class="alert alert-error" style="margin-bottom:0px;"></div>').html($(this).html());
		$('#container').children('.container').prepend(errors);
	});

	$('#flashMessage').each(function(){
		var errors = $('<div class="alert alert-success" style="margin-bottom:0px;"></div>').html($(this).html());
		$('#container').children('.container').prepend(errors);
	});
});
</script>
