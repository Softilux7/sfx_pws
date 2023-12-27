<div class="events view">
<h2><?php echo __('Tarefa'); ?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Prioridade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->link($event['EventType']['name'], array('controller' => 'event_types', 'action' => 'view', $event['EventType']['id'])); ?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Titulo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $event['Event']['title']; ?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Detalhes'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $event['Event']['details']; ?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $event['Event']['status']; ?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data de Inicio'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $event['Event']['start']; ?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data Final'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php if($event['Event']['all_day'] != 1) { echo $event['Event']['end']; } else { echo "N/A"; } ?></dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Dia Todo'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php if($event['Event']['all_day'] == 1) { echo "Yes"; } else { echo "No"; } ?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Data da Criação'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $event['Event']['created']; ?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Última Modificação'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $event['Event']['modified']; ?></dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Editar Tarefa', true), array('plugin' => 'full_calendar', 'action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Deletar Tarefa', true), array('plugin' => 'full_calendar', 'action' => 'delete', $event['Event']['id']), null, sprintf(__('Are you sure you want to delete this %s event?', true), $event['EventType']['name'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Tarefas', true), array('plugin' => 'full_calendar', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Quadro de Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?></li>
	</ul>
</div>
