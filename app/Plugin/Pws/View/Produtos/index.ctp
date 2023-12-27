<div class="container">
	<h2>
		<?php echo __('Pws Manager: Produtos'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Produtos','index','Pws') == true){?>
					<li class="active"><?php echo $this->Html->link(__('Produto'), array('plugin' => 'Pws','controller' => 'Produtos','action' => 'index')); ?></li>
				<?php } ?>
				<?php if ($this->Acl->check('Produtos','index','Pws') == true){?>
					<li><?php echo $this->Html->link(__('Pws'), array('plugin' => 'Pws','controller' => 'Pwss','action' => 'index')); ?></li>
				<?php }?>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<?php if ($this->Acl->check('Produtos','add','Pws') == true){?>
		<div class="span12" style="text-align: right;">
			<button class="btn btn-success" type="button"
				onclick="showAddProdutoPage();">
				<i class="icon-plus icon-white"></i>
				<?php echo __('Produto'); ?>
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
									'Produto.id' => __ ( 'ID', true ),
									'Produto.produto_nome' => __ ( 'Razao Social', true ),
							), array (
									'class' => 'select-box' 
							) );
							echo $this->Search->selectOperators ( 'filter1' );
							echo $this->Search->input ( 'filter1',array('placeholder'=>"Filtrar Produto"));
								
							?>
                <button class="btn" type="submit">
					<?php echo __('Search'); ?>
				</button>
				<button class="btn" type="button" onclick="cancelSearch();">
					<i class="icon-remove-sign"></i>
				</button>
				<?php echo $this->Search->end(); ?> 
			</div>
			
			<?php echo $this->Session->flash(); ?>
			
		</div>
	</div>
	<?php echo $this->Form->create('Produto', array('action' => 'index','class'=>' form-signin form-horizontal')); ?>
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
						<th style="text-align: center; width: 150px;"><?php echo $this->Paginator->sort('cdproduto','Codigo do Produto'); ?>
						</th>
						<th style="text-align: center;"><?php echo $this->Paginator->sort('produto_nome','Nome do Produto'); ?>
						</th>
						<?php if ($this->Acl->check('Produtos','view','Pws') == true || $this->Acl->check('Produtos','edit','Pws') == true || $this->Acl->check('Produtos','delete','Pws') == true){?>
						<th style="text-align: center; width: 150px;"><?php echo __('Actions'); ?>
						</th>
						<?php } ?>
					</tr>
				</thead>
				<?php
	foreach ($produtos as $produto): ?>
				<tr>
					<td style="text-align: center;"><?php echo h($produto['Produto']['id']); ?>&nbsp;</td>
					<td style="text-align: center;"><?php echo h($produto['Produto']['cdproduto']); ?>&nbsp;</td>
					<td><?php echo h($produto['Produto']['produto_nome']); ?>&nbsp;</td>
					<?php if ($this->Acl->check('Produtos','view','Pws') == true || $this->Acl->check('Produtos','edit','Pws') == true || $this->Acl->check('Produtos','delete','Pws') == true){?>
					<td style="text-align: center;">
						<?php echo $this->Acl->link(__('View'), array('action' => 'view', $produto['Produto']['id']),array('class'=>'btn btn-mini')); ?>
						<?php echo $this->Acl->link(__('Edit'), array('action' => 'edit', $produto['Produto']['id']),array('class'=>'btn btn-mini btn-primary')); ?>
						<?php echo $this->Acl->link(__('Delete'), array('action' => 'delete', $produto['Produto']['id']),array('class'=>'btn btn-mini btn-danger','onclick' =>'delProduto("'.h($produto['Produto']['id']).'","'.h($produto['Produto']['produto_nome']).'");return false;')); ?>
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
	window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Produtos','action' => 'index')); ?>';
}
function delProduto(produto_id, name) {
    $.sModal({
        image: '<?php echo $this->webroot; ?>img/icons/error.png',
        content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + name + '</b>?',
        animate: 'fadeDown',
        buttons: [{
            text: ' <?php echo __('Delete'); ?> ',
            addClass: 'btn-danger',
            click: function(id, data) {
                $.post('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Produtos','action' => 'delete')); ?>/' + produto_id, {}, function(o) {
	                    $('#container').load('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Produtos','action' => 'index')); ?>', function() {
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
function showAddProdutoPage() {
	window.location = "<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Produtos','action' => 'add')); ?>";
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
