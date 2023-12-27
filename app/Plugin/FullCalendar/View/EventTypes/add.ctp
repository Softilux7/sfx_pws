
<div class="eventTypes form">
<?php echo $this->Form->create('EventType');?>
	<fieldset>
 		<legend><?php __('Adicionar Prioridade'); ?></legend>
	<?php
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
		<li><?php echo $this->Html->link(__('Prioridades', true), array('plugin' => 'full_calendar', 'action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('Quadro de tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?></li>
	</ul>
</div>
