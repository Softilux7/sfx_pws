<div class="container">
	<h2>
		<?php echo __('Territorios'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Territorios','index','Pws') == true){?>
					<li class="active"><?php echo $this->Html->link(__('Territorio'), array('plugin' => 'Pws','controller' => 'Territorios','action' => 'index')); ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<?php if ($this->Acl->check('Territorios','add','Pws') == true){?>
		<div class="span12" style="text-align: right;">
			<button class="btn btn-success" type="button"
				onclick="showAddTerritorioPage();">
				<i class="icon-plus icon-white"></i>
				<?php echo __('Territorio'); ?>
			</button>
		</div>
		<?php }?>
		
	</div>
	<button type="button" class="btn btn-search" data-toggle="collapse" data-target="#search">
	<i class="icon-filter"></i>
    Filtrar Resultados
    </button>
     
    <div id="search" class="collapse">
	<div class="row-fluid show-grid">
		<div class="span10">
            <?php echo $this->Search->create ('',array('class'=>'form-inline'));	?>
            <fieldset>
             <legend>Filtro</legend>
			<div class="span3">
				<div class="control-group">
					<label class="control-label"><?php echo __('Coluna:'); ?> </label>
					<div class="controls">
						<?php echo $this->Search->selectFields ( 'filter1', array (
									'Territorio.id' => __ ( 'ID', true ),
									'Territorio.territorio_nome' => __ ( 'Territorio', true ),
							), array (
									'class' => 'select-box' 
							) );
						?>
					  </div>
				</div>
			</div>
			<div class="span3">
				<div class="control-group">
					<label class="control-label"><?php echo __('Operador:'); ?> </label>
					<div class="controls">
							<?php echo $this->Search->selectOperators ( 'filter1' );	?>
					  </div>
				</div>
			</div>

		<div class="span3">
			<div class="control-group">
			<label class="control-label"><?php echo __('Campo:'); ?> </label>
				<div class="controls">
				<div class="input-append">
							<?php
							echo $this->Search->input ( 'filter1', array (
									'placeholder' => "Filtrar Território", 
									'class'=> "search-query"
							) );
							?>
				<button class="btn" type="submit">
					<?php echo __('Search'); ?>
				</button>
				<button class="btn" type="button" onclick="cancelSearch();">
					<i class="icon-remove-sign"></i>
				</button>	
				</div>	
	                  </div>
			</div>
		</div>
</div>


<?php echo $this->Search->end(); ?> 
	
			
			<?php echo $this->Session->flash(); ?>
 </fieldset>
</div>
</div>	
	<?php echo $this->Form->create('Territorio', array('action' => 'index','class'=>' form-signin form-horizontal')); ?>
	<?php echo $this->Form->end(); ?>
	<div class="row-fluid show-grid">
		<div class="span12">
			<div class="pagination">
				<ul>
					<?php
					echo $this->Paginator->prev('&larr; ' . __('previous'),array('tag' => 'li','escape' => false));
					echo $this->Paginator->numbers(array('separator' => '','tag'=>'li'));
					echo $this->Paginator->next(__('next') . ' &rarr;', array('tag' => 'li','escape' => false));
					?>
				</ul>
			</div>
			<table class="table table-bordered table-hover list table-condensed table-striped">
				<thead>
					<tr>
						<th style="text-align: center; width: 30px;"><?php echo $this->Paginator->sort('id'); ?>
						</th>
						<th style="text-align: center;"><?php echo $this->Paginator->sort('territorio_nome','Nome do Territorio'); ?>
						</th>
						<?php if ($this->Acl->check('Territorios','view','Pws') == true || $this->Acl->check('Territorios','edit','Pws') == true || $this->Acl->check('Territorios','delete','Pws') == true){?>
						<th style="text-align: center; width: 150px;"><?php echo __('Actions'); ?>
						</th>
						<?php } ?>
					</tr>
				</thead>
				<?php
	foreach ($territorios as $territorio): ?>
				<tr>
					<td style="text-align: center;"><?php echo h($territorio['Territorio']['id']); ?>&nbsp;</td>
					<td><?php echo h($territorio['Territorio']['territorio_nome']); ?>&nbsp;</td>
					<?php if ($this->Acl->check('Territorios','view','Pws') == true || $this->Acl->check('Territorios','edit','Pws') == true || $this->Acl->check('Territorios','delete','Pws') == true){?>
					<td style="text-align: center;">
						<?php echo $this->Acl->link(__('<i class="icon-eye-open"></i>'), array('action' => 'view', $territorio['Territorio']['id']),array('class'=>'btn btn-mini','escape' => false)); ?>
						<?php echo $this->Acl->link(__('<i class="icon-edit icon-white"></i>'), array('action' => 'edit', $territorio['Territorio']['id']),array('class'=>'btn btn-mini btn-primary','escape' => false)); ?>
						<?php echo $this->Acl->link(__('Excluir'), array('action' => 'delete', $territorio['Territorio']['id']),array('class'=>'btn btn-mini btn-danger','onclick' =>'delTerritorio("'.h($territorio['Territorio']['id']).'","'.h($territorio['Territorio']['territorio_nome']).'");return false;')); ?>
					</td>
					<?php } ?>
				</tr>
				<?php endforeach; ?>
			</table>
			<p>
				<?php
				echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
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
	</div>
</div>
<script type="text/javascript">



function cancelSearch(){
	removeUserSearchCookie();
	window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Territorios','action' => 'index')); ?>';
}
function delTerritorio(territorio_id, name) {
    $.sModal({
        image: '<?php echo $this->webroot; ?>img/icons/error.png',
        content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + name + '</b>?',
        animate: 'fadeDown',
        buttons: [{
            text: ' <?php echo __('Delete'); ?> ',
            addClass: 'btn-danger',
            click: function(id, data) {
                $.post('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Territorios','action' => 'delete')); ?>/' + territorio_id, {}, function(o) {
	                    $('#container').load('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Territorios','action' => 'index')); ?>', function() {
                        $.sModal('close', id);
                        $('#tab_user_manager').find('a').each(function(){
                    		$(this).click(function(){
                    			removeUserSearchCookie();
                    		});
                    	});
                    });
                }, 'json');
            }
        }, {
            text: ' <?php echo __('Cancel'); ?> ',
            click: function(id, data) {
                $.sModal('close', id);
            }
        }]
        });
}
function showAddTerritorioPage() {
	window.location = "<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Territorios','action' => 'add')); ?>";
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
