<div class="container">
	<h2>
		<?php echo __('Tarefas'); ?>
	</h2>
	
	<div class="row-fluid show-grid">
		<div class="span12" style="text-align: right;">
			<button class="btn btn-primary" type="button"
				onclick="showQuadroTarefaPage();">
				<i class="icon-calendar icon-white"></i>
				<?php echo __('Quadro Tarefa'); ?>
			</button>
			<button class="btn btn-success" type="button"
				onclick="showAddTarefaPage();">
				<i class="icon-plus icon-white"></i>
				<?php echo __('Tarefa'); ?>
			</button>
		</div>
	<br />
	<br />
	</div>

<div class="row-fluid show-grid">

	<table class="table table-bordered table-hover list table-condensed table-striped">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('event_type_id','Prioridade');?></th>
			<th><?php echo $this->Paginator->sort('title','Titulo');?></th>
			<th><?php echo $this->Paginator->sort('status','Status');?></th>
			<th><?php echo $this->Paginator->sort('start','Data Inicio');?></th>
            <th><?php echo $this->Paginator->sort('end','Data Fim');?></th>
            
			<th class="actions">Ação</th>
	</tr>
  </thead>
	<?php
 
	$i = 0;
	foreach ($events as $event):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $this->Html->link($event['EventType']['name'], array('controller' => 'event_types', 'action' => 'view', $event['EventType']['id'])); ?>
		</td>
		<td><?php echo $event['Event']['title']; ?></td>
		<td><?php echo $event['Event']['status']; ?></td>
		<td><?php echo date('d/m/Y - h:i',strtotime( $event['Event']['start'])); ?></td>
        <?php if($event['Event']['all_day'] == 0) { ?>
   		<td><?php echo date('d/m/Y - h:i',strtotime( $event['Event']['end'])); ?></td>
        <?php } else { ?>
		<td>N/A</td>
        <?php } ?>

		<td style="text-align: center;">
						<?php echo $this->Acl->link(__('Ver'), array('action' => 'view', $event['Event']['id']),array('class'=>'btn btn-mini')); ?>
						<?php echo $this->Acl->link(__('Editar'), array('action' => 'edit', $event['Event']['id']),array('class'=>'btn btn-mini btn-primary')); ?>
						
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
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Nova Tarefa', true), array('plugin' => 'full_calendar', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Prioridades', true), array('plugin' => 'full_calendar', 'controller' => 'event_types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('Quadro de Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'full_calendar')); ?></li>
	</ul>
</div>
</div>
<script type="text/javascript">
function showAddTarefaPage() {
	window.location = "<?php echo Router::url(array('plugin' => 'full_calendar','action' => 'add')); ?>";
}
function showQuadroTarefaPage() {
	window.location = "<?php echo Router::url(array('plugin' => 'full_calendar','controller' => 'full_calendar')); ?>";
}
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