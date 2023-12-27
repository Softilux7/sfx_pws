<div class="container">
	<h2>
		<?php echo __('Prioridades'); ?>
	</h2>
<div class="row-fluid show-grid">
	<table class="table table-bordered table-hover list table-condensed table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('name','Prioridade');?></th>
            <th><?php echo $this->Paginator->sort('color','Cor');?></th>
			<th class="actions">Ação</th>
	</tr>
	</thead>
	<?php
	$i = 0;
	foreach ($eventTypes as $eventType):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $eventType['EventType']['name']; ?>&nbsp;</td>
        <td><?php echo $eventType['EventType']['color']; ?>&nbsp;</td>

		<td style="text-align: center;">
						<?php echo $this->Acl->link(__('Ver'), array('action' => 'view', $eventType['EventType']['id']),array('class'=>'btn btn-mini')); ?>
						<?php echo $this->Acl->link(__('Editar'), array('action' => 'edit', $eventType['EventType']['id']),array('class'=>'btn btn-mini btn-primary')); ?>
						
		</td>
	</tr>
<?php endforeach; ?>
	</table>

</div>
<p>
				<?php
				echo $this->Paginator->counter(array(
	'format' => __('Pagina {:page} de {:pages}, Mostrando {:current} registros do total de {:count}')
	));
	?>
			</p>

			<div class="pagination">
				<ul>
					<?php
					echo $this->Paginator->prev('&larr; ' . __('previous'),array('tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag'=>'li'));
					echo $this->Paginator->next(__('next') . ' &rarr;', array('tag' => 'li','escape' => false));
					?>
				</ul>
			</div>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Nova Prioridade', true), array('plugin' => 'full_calendar', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Gerenciar Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'events', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('Quadro de Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?></li>
	</ul>
</div>
<script type="text/javascript">

$(document).ready(function() {
	$('.pagination > ul > li').each(function() {
		if ($(this).children('a').length <= 0) {
			var tmp = $(this).html();
			if ($(this).hasClass('prev')) {
				$(this).addClass('disabled');
			} else if ($(this).hasClass('next')) {
				$(this).addClass('disabled');
			} else {
				$(this).addClass('active');
			}
			$(this).html($('<a></a>').append(tmp));
		}
	});
});
</script>