<script type="text/javascript">
plgFcRoot = '<?php echo $this->Html->url('/'); ?>' + "full_calendar";
</script>
<?php
echo $this->Html->script(array('/full_calendar/js/jquery-1.5.min', '/full_calendar/js/jquery-ui-1.8.9.custom.min', '/full_calendar/js/fullcalendar.min', '/full_calendar/js/jquery.qtip-1.0.0-rc3.min', '/full_calendar/js/ready'), array('inline' => 'false'));
echo $this->Html->css('/full_calendar/css/fullcalendar');
?>

<div class="span12">
	<h2>
		<?php echo __('Quadro de Tarefas'); ?>
	</h2>
		<div class="row-fluid show-grid">
		
		<div class="span12" style="text-align: right;">
			<button class="btn btn-success" type="button"
				onclick="showAddTarefaPage();">
				<i class="icon-plus icon-white"></i>
				<?php echo __('Tarefa'); ?>
			</button>
			<button class="btn btn-primary" type="button"
				onclick="showListarTarefaPage();">
				<i class="icon-list-alt icon-white"></i>
				<?php echo __('Listar Tarefas'); ?>
			</button>
		</div>
	<br />
	<br />
	</div>
	<div id="calendar"></div>
<div class="actions">
	<ul>
	    <li><?php echo $this->Html->link(__('Nova Tarefa', true), array('plugin' => 'full_calendar', 'controller' => 'events', 'action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Listar Tarefas', true), array('plugin' => 'full_calendar', 'controller' => 'events')); ?></li>
		<li><?php echo $this->Html->link(__('Prioridades', true), array('plugin' => 'full_calendar', 'controller' => 'event_types')); ?></li>
	</ul>
</div>
</div>
<script type="text/javascript">
function showAddTarefaPage() {
	window.location = "<?php echo Router::url(array('plugin' => 'full_calendar','controller' => 'events','action' => 'add')); ?>";
}
function showListarTarefaPage() {
	window.location = "<?php echo Router::url(array('plugin' => 'full_calendar','controller' => 'events','action' => 'index')); ?>";
}
</script>