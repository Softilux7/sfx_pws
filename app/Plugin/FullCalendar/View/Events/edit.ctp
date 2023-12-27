<?php
echo $this->Html->script(array(
	'/full_calendar/js/jquery.datetimepicker')
     , array('inline' => 'false'));
echo $this->Html->css('/full_calendar/css/jquery.datetimepicker');
?>
<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
 		<legend><?php __('Editar Tarefa'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('event_type_id',array('label' => 'Prioridade'));
		echo $this->Form->input('title',array('label' => 'Titulo'));
		echo $this->Form->input('details',array('label' => 'Detalhes'));
		echo $this->Form->input('start',array('label' => 'Data de Inicio','type' => 'text','required'));
		echo $this->Form->input('end',array('label' => 'Data de Fim','type' => 'text','required'));
		echo $this->Form->input('all_day',array('label' => 'Dia Todo'));
		echo $this->Form->input('status', array('options' => array(
					'Scheduled' => 'Scheduled','Confirmed' => 'Confirmed','In Progress' => 'In Progress',
					'Rescheduled' => 'Rescheduled','Completed' => 'Completed'
					)
				)
			);
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Ver Tarefa', true), array('plugin' => 'full_calendar', 'action' => 'view', $this->Form->value('Event.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Tarefas', true), array('plugin' => 'full_calendar', 'action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Quadro de Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?></li>
	</ul>
</div>
<script type="text/javascript">
$(document).ready(function() {
$('#EventStart').datetimepicker();
$('#EventEnd').datetimepicker();
});
</script>