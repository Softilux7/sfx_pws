
<div class="eventTypes view">
<h2><?php echo __('Prioridade');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Prioridade'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventType['EventType']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Cor'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $eventType['EventType']['color']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Editar Prioridade', true), array('plugin' => 'full_calendar', 'action' => 'edit', $eventType['EventType']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Deletar Prioridade', true), array('plugin' => 'full_calendar', 'action' => 'delete', $eventType['EventType']['id']), null, sprintf(__('Are you sure you want to delete %s?', true), $eventType['EventType']['name'])); ?> </li>
		<li><?php echo $this->Html->link(__('Listar Prioridade', true), array('plugin' => 'full_calendar', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Quadro de Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?></li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Tarefas Relacionadas');?></h3>
	<?php if (!empty($eventType['Event'])):?>
	<table class="table table-bordered table-hover list table-condensed table-striped">
	<thead>
	<tr>
		<th><?php echo __('Titulo'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Data de Inicio'); ?></th>
        <th><?php echo __('Data Final'); ?></th>
        <th><?php echo __('Dia Todo'); ?></th>
		<th><?php echo __('Última Modificação'); ?></th>
		<th class="actions">Ação</th>
	</tr>
	</thead>
	<?php
		$i = 0;
		foreach ($eventType['Event'] as $event):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $event['title'];?></td>
			<td><?php echo $event['status'];?></td>
			<td><?php echo $event['start'];?></td>
            <td><?php if($event['all_day'] != 1) { echo $event['end']; } else { echo "N/A"; } ?></td>
            <td><?php if($event['all_day'] == 1) { echo "Yes"; } else { echo "No"; }?></td>
			<td><?php echo $event['modified'];?></td>
				<td style="text-align: center;">
				<?php echo $this->Acl->link(__('Ver'), array('action' => 'view', $eventType['EventType']['id']),array('class'=>'btn btn-mini')); ?>
				<?php echo $this->Acl->link(__('Editar'), array('action' => 'edit', $eventType['EventType']['id']),array('class'=>'btn btn-mini btn-primary')); ?>
						
		</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>
