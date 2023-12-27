<div class="container">
	<h2>
		Script: Exclusão de dados
	</h2>
    <div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
                <li class="active"><?php echo $this->Html->link(__('General'), array('plugin' => 'auth_acl','controller' => 'settings','action' => 'index')); ?></li>
			</ul>
		</div>
	</div>
    <div class="row-fluid show-grid">
        <?php echo $this->Form->create('scripts',array('action' => 'runCleanDatabase','class'=>'form-horizontal')); ?>
		<div class="span12">
            <legend>
				<?php echo __('Informações gerais'); ?>
			</legend>
			<div class="control-group">
				<div class="controls" style="margin-left:60px">
					<?php echo $this->Form->input('id_base',array('div' => false,'label'=>false,'placeholder'=>__('Id base'),'class' => 'input-xlarge')); ?>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="inputEmail">&nbsp;</label>
				<div class="controls" style="margin-left:60px">
					<label class="checkbox" for="SettingDisableRegistration"
						style="width: 160px;"> <?php echo $this->Form->checkbox('checkConfirmRun',array('div' => false,'label'=>false)); ?>
						<?php echo __('Confirmar exclusão'); ?>
					</label> 
				</div>
			</div>
			<?php if ($this->Acl->check('Settings','save','AuthAcl') == true){?>
			<div class="form-actions" style="padding-left:60px"> 
				<button id="buttonRun" type="button" class="btn btn-danger"
					onclick="handdleButton();">
					<?php echo __('Confirmar exclusão'); ?>
				</button>
			</div>
			<?php } ?>
			<?php echo $this->Form->end(); ?>
			<div>
				<div id="progressbar" style="width:0%;background:#666;height:10px;">.</div>
			</div>
            <div>
                <div id="runLog"></div>
            </div>
		</div>
	</div>
</div>


<script type="text/javascript">
    function handdleButton(){

		const confirmRun = $('#scriptsCheckConfirmRun').is(':checked');

		if(confirmRun){

			if(window.confirm('Deseja realmente confirmar a exlclusão dos dados?')){

				// desabilita o botão
				$('#buttonRun').attr('disabled', true);
				$('#progressbar').width('0%');

				const amountScripts = <?php echo $amountScripts; ?>;
				var countRun = 0;
				const idbase = parseInt($('#scriptsIdBase').val());
				let data = null;

				// limpa as informações do log
				$('#runLog').html('');

				// mensagem de inicialização
				$('#runLog').prepend('<div><em><strong>Script inicializado...</strong></em></div>');

				for(var i = 0; i <= (amountScripts - 1); i++){

					console.log(i + '- ');

					$.ajax({
						type: "POST",
						url: "<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'Scripts', 'action' => 'runCleanDatabase')); ?>",
						timeout: 10000000,
						data: {idbase, position: i},
						dataType: 'json',
						success: function(response){
							data = response;
							console.log(data);
							// mensagem dos processados
							var container = '<div><div>' + countRun + ': ' + data.sql + '</div><div style="font-size:11px;color:red"><em>'+ data.error +'</em></div></div>';
							$('#runLog').prepend(container);

							countRun++;

							var valWidth = ((countRun * 100) / amountScripts);
							
							$('#progressbar').width(valWidth+'%');

							// valida o final do script
							if(countRun == amountScripts){
								// mensagem de finalização
								$('#runLog').prepend('<div><em><strong>Script finalizado!</strong><em></div>');

								// habilita o botão
								$('#buttonRun').attr('disabled', false);
								
								// desabilitar o checkbox
								$('#scriptsCheckConfirmRun').prop('checked', false);
							}
						},
					});

				}

			}
		}else{
			alert('Você precisa confirmar a exclusão dos dados');
		}

    }
</script>