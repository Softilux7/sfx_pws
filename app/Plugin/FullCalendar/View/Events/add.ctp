<?php
echo $this->Html->script(array(
	'/full_calendar/js/jquery.datetimepicker')
     , array('inline' => 'false'));
echo $this->Html->css('/full_calendar/css/jquery.datetimepicker');
?>
<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
 		<legend><?php __('Nova Tarefa'); ?></legend>
	<?php
		echo $this->Form->input('event_type_id',array('label' => 'Tipo'));
	    echo $this->Form->input('cliente_id',array('label' => 'Cliente'));
	    echo $this->Form->input('versao_id',array('label' => 'Versão'));
		echo $this->Form->input('title',array('type'=>'hidden','label' => 'Titulo'));
		echo $this->Form->input('details',array('type'=>'hidden','label' => 'Descrição'));
		echo $this->Form->input('start',array('label' => 'Data de Inicio','type' => 'text','required','readonly'));
		echo $this->Form->input('end',array('type'=>'hidden ','label' => 'Data de Fim',));
		echo $this->Form->input('all_day', array('type'=>'hidden','label' => 'Dia todo','checked' => 'unchecked'));
		echo $this->Form->input('status', array('label' => 'Status','options' => array(
					'Agendado' => 'Agendado'
				)
			)
		);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar', true));?>
</div>
<!--<div class="actions">-->
<!--	<ul>-->
<!--		<li>--><?php //echo $this->Html->link(__('Listar Tarefas', true), array('plugin' => 'full_calendar', 'action' => 'index'));?><!--</li>-->
<!--		<li>--><?php //echo $this->Html->link(__('Quadro de Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?><!--</li>-->
<!--	</ul>-->
<!--</div>-->
<script type="text/javascript">
$(document).ready(function() {
$('#EventStart').datetimepicker({
	lang:'pt'
});

});
</script>