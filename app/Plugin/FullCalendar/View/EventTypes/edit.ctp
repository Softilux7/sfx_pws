
<div class="eventTypes form">
<?php echo $this->Form->create('EventType');?>
	<fieldset>
 		<legend><?php __('Editar Prioridade'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name',array('label' => 'Prioridade'));
		echo $this->Form->input('color', 
					array('label' => 'Cor','options' => array(
						'Blue' => 'Blue',
						'Red' => 'Red',
						'Pink' => 'Pink',
						'Purple' => 'Purple',
						'Orange' => 'Orange',
						'Green' => 'Green',
						'Gray' => 'Gray',
						'Black' => 'Black',
						'Brown' => 'Brown'
					)));

	?>
	</fieldset>
<?php echo $this->Form->end(__('Salvar', true));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Visualizar Prioridade', true), array('plugin' => 'full_calendar', 'action' => 'view', $this->Form->value('EventType.id'))); ?></li>
		<li><?php echo $this->Html->link(__('Listar Prioridades', true), array('plugin' => 'full_calendar', 'action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Quadro de Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?></li>
	</ul>
</div>
