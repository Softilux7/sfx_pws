<div class="span9">
	<h2>
		<?php echo __('Pws Manager: Clientes'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Clientes','index','Pws') == true){?>
					<li class="active"><?php echo $this->Html->link(__('Clientes'), array('plugin' => 'Pws','controller' => 'clientes','action' => 'index')); ?></li>
				<?php } ?>
				<?php if ($this->Acl->check('Pwss','index','Pws') == true){?>
					<li><?php echo $this->Html->link(__('Pws'), array('plugin' => 'article','controller' => 'articles','action' => 'index')); ?></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<?php if ($this->Acl->check('Clientes','add','Pws') == true){?>
		<div class="span12" style="text-align: right;">
			<button class="btn btn-success" type="button"
				onclick="showAddClientePage();">
				<i class="icon-plus icon-white"></i>
				<?php echo __('Cliente'); ?>
			</button>
		</div>
		<?php }?>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<div class="input-append">       
                                <?php
							echo $this->Search->create ();
							echo $this->Search->selectFields ( 'filter1', array (
									'Cliente.id' => __ ( 'ID', true ),
									'Cliente.razao_social' => __ ( 'Razao Social', true ),
									'Cliente.cnpj' => __ ( 'Cnpj', true ) 
							), array (
									'class' => 'select-box' 
							) );
							echo $this->Search->selectOperators ( 'filter1' );
							echo $this->Search->input ( 'filter1',array('placeholder'=>"Filtrar Cliente"));
							
							
							?>
                <button class="btn" type="submit">
					<?php echo __('Search'); ?>
				</button>
				<button class="btn" type="button" onclick="cancelSearch();">
					<i class="icon-remove-sign"></i>
				</button>
				<?php echo $this->Search->end(); ?> 
			</div>
		</div>
	</div>
	<?php echo $this->Form->create('Cliente', array('action' => 'index','class'=>' form-signin form-horizontal')); ?>
	<?php echo $this->Form->end(); ?>
	<div class="row-fluid show-grid">
		<div class="span12">
			<div class="pagination">
				<ul>
					<?php
					echo $this->Paginator->prev ( '&larr; ' . __ ( 'previous' ), array (
							'tag' => 'li',
							'escape' => false 
					) );
					echo $this->Paginator->numbers ( array (
							'separator' => '',
							'tag' => 'li' 
					) );
					echo $this->Paginator->next ( __ ( 'next' ) . ' &rarr;', array (
							'tag' => 'li',
							'escape' => false 
					) );
					?>
				</ul>
			</div>
			<table
				class="table table-bordered table-hover list table-condensed table-striped">
				<thead>
					<tr>
						<th style="text-align: center; width: 30px;"><?php echo $this->Paginator->sort('id'); ?>
						</th>
						<th style="text-align: center;"><?php echo $this->Paginator->sort('razao_social'); ?>
						</th>
						<th style="text-align: center; width: 150px;"><?php echo $this->Paginator->sort('fantasia'); ?>
						</th>
						<th style="text-align: center; width: 150px;"><?php echo $this->Paginator->sort('cnpj'); ?>
						</th>
						<?php if ($this->Acl->check('Clientes','view','Pws') == true || $this->Acl->check('Clientes','edit','Pws') == true || $this->Acl->check('Clientes','delete','Pws') == true){?>
						<th style="text-align: center; width: 150px;"><?php echo __('Actions'); ?>
						</th>
						<?php } ?>
					</tr>
				</thead>
				<?php
				foreach ( $clientes as $cliente ) :
					?>
				<tr>
					<td style="text-align: center;"><?php echo h($cliente['Cliente']['id']); ?>&nbsp;</td>
					<td><?php echo h($cliente['Cliente']['razao_social']); ?>&nbsp;</td>
					<td><?php echo h($cliente['Cliente']['fantasia']); ?>&nbsp;</td>
					<td><?php echo h($cliente['Cliente']['cnpj']); ?>&nbsp;</td>
					<?php if ($this->Acl->check('Clientes','view','Pws') == true || $this->Acl->check('Clientes','edit','Pws') == true || $this->Acl->check('Clientes','delete','Pws') == true){?>
					<td style="text-align: center;">
						<?php echo $this->Acl->link(__('View'), array('action' => 'view', $cliente['Cliente']['id']),array('class'=>'btn btn-mini')); ?>
						<?php echo $this->Acl->link(__('Edit'), array('action' => 'edit', $cliente['Cliente']['id']),array('class'=>'btn btn-mini btn-primary')); ?>
						<?php echo $this->Acl->link(__('Delete'), array('action' => 'delete', $cliente['Cliente']['id']),array('class'=>'btn btn-mini btn-danger','onclick' =>'delCliente("'.h($cliente['Cliente']['id']).'","'.h($cliente['Cliente']['fantasia']).'");return false;')); ?>
					</td>
					<?php } ?>
				</tr>
				<?php endforeach; ?>
			</table>
			<p>
				<?php
				echo $this->Paginator->counter ( array (
						'format' => __ ( 'Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}' ) 
				) );
				?>
			</p>

			<div class="pagination">
				<ul>
					<?php
					echo $this->Paginator->prev ( '&larr; ' . __ ( 'previous' ), array (
							'tag' => 'li',
							'escape' => false 
					) );
					echo $this->Paginator->numbers ( array (
							'separator' => '',
							'tag' => 'li' 
					) );
					echo $this->Paginator->next ( __ ( 'next' ) . ' &rarr;', array (
							'tag' => 'li',
							'escape' => false 
					) );
					?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function cancelSearch(){
	removeUserSearchCookie();
	window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'clientes','action' => 'index')); ?>';
}
function delCliente(cliente_id, name) {
    $.sModal({
        image: '<?php echo $this->webroot; ?>img/icons/error.png',
        content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + name + '</b>?',
        animate: 'fadeDown',
        buttons: [{
            text: ' <?php echo __('Delete'); ?> ',
            addClass: 'btn-danger',
            click: function(id, data) {
                $.post('<?php echo Router::url(array('plugin' => 'article','controller' => 'clientes','action' => 'delete')); ?>/' + cliente_id, {}, function(o) {
	                    $('#container').load('<?php echo Router::url(array('plugin' => 'article','controller' => 'clientes','action' => 'index')); ?>', function() {
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
function showAddClientePage() {
	window.location = "<?php echo Router::url(array('plugin' => 'Pws','controller' => 'clientes','action' => 'add')); ?>";
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
