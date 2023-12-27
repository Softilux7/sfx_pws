<style>
<!--
.form-horizontal .control-label {
	padding-top: 0px;
}
-->
</style>
<div class="container">
	<h2>
		<?php echo __('Abertura de O.S'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Equipamentos','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('Equipamentos'), array('plugin' => 'auth_acl','controller' => 'equipamentos','action' => 'index')); ?></li>
				<?php } ?>
					<li class="active"><?php echo $this->Html->link(__('Abertura de O.S'), '#'); ?></li>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<?php if (count($errors) > 0){ ?>
			<div class="alert alert-error">
				<button data-dismiss="alert" class="close" type="button">×</button>
				<?php foreach($errors as $error){ ?>
				<?php foreach($error as $er){ ?>
				<strong><?php echo __('Error!'); ?> </strong>
				<?php echo utf8_encode($er); ?>
				<br />
				<?php } ?>
				<?php } ?>
			</div>
			<?php } ?>
			<?php echo $this->Form->create('Equipamento',array('class'=>'form-inline')); ?>
			
			<div class="span6">
				<div class="control-group">
					<label class="control-label"><?php echo utf8_encode(__('modelo')); ?><span
						style="color: red;">*</span> </label>
					<div class="controls">
					<?php echo $this->Form->input('modelo',array('div' => false,'label'=>false,'error'=>false,'class'=>'input-xxsmall')); ?>
				</div>
				</div>
			</div>

			<div class="span6">
				<div class="control-group">
					<label class="control-label"><?php echo __('serie'); ?><span
						style="color: red;">*</span> </label>
					<div class="controls">
					<?php echo $this->Form->input('serie',array('div' => false,'label'=>false,'error'=>false,'class'=>'input-xxsmall')); ?>
				</div>
				</div>
			</div>

			<div class="span6">
				<div class="control-group">
					<label class="control-label"><?php echo __('fabricante'); ?><span
						style="color: red;">*</span> </label>
					<div class="controls">
					<?php echo $this->Form->input('fabricante',array('div' => false,'id'=>'cnpj','label'=>false,'disabled'=>false,'error'=>false,'class'=>'input-xxsmall')); ?>
				</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
</div>
<script>
	function cancel_add() {
		window.location = '<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'equipamentos','action' => 'index')); ?>';
	}
	
	function desactiva(obj) { 

	nForm = document.forms['ClienteAddForm'];

	if(obj.checked){ 
		nForm.elements['ClienteCpf'].disabled = false;
		nForm.elements['ClienteCnpj'].disabled = true;
	 }else{ 
		nForm.elements['ClienteCpf'].disabled = true;
		nForm.elements['ClienteCnpj'].disabled = false;
	}
	} 

	$(document).ready(function() {
		if($('#estados').val().length != 0) {
		$.getJSON("<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'equipamentos','action' => 'listar_cidades_json')); ?>",{
		estadoId: $('#estados').val()
		}, function(cidades) {
		if(cidades != null)
		popularListaDeCidades(cidades, $('#cidades').val());
		});
		}
		$('#estados').live('change', function() {
		if($(this).val().length != 0) {
		$.getJSON("<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'equipamentos','action' => 'listar_cidades_json')); ?>",{
		estadoId: $(this).val()
		}, function(cidades) {
		if(cidades != null)
		popularListaDeCidades(cidades);
		});
		} else
		popularListaDeCidades(null);
		});
		$("#cnpj").mask("99.999.999/9999-99");
		$("#ddd").mask("99");
		$("#fone").mask("9999-9999");
		$("#cep").mask("99999-999");
		$('#numero').mask('00000000000',{optional: true});
		});



		function popularListaDeCidades(cidades, idCidade) {
		var options = '<option>Selecione uma Cidade</option>';
		if(cidades != null) {
		$.each(cidades, function(index, cidade){
		if(idCidade == index)
		options += '<option selected="selected" value="' + index + '">' +index + '</option>';
		else
		options += '<option value="' + index + '">' + index + '</option>';
		});
		}
		$('#cidades').html(options);
		}
	 
</script>
