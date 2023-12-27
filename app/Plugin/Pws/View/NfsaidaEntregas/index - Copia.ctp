<div class="container">
	<h2>
		<?php echo __('Listagem de Chamados'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">

				<li class="active"><?php echo $this->Html->link(__('Chamados'), array('plugin' => 'Pws','controller' => 'Chamados','action' => 'index')); ?></li>
				<li><?php echo $this->Html->link(__('Equipamento'), array('plugin' => 'Pws','controller' => 'Equipamentos','action' => 'index')); ?></li>




			</ul>
		</div>
	</div>
	<button type="button" class="btn btn-search" data-toggle="collapse"
		data-target="#search">
		<i class="icon-filter"></i> Filtrar Resultados
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
						<?php
						
						echo $this->Search->selectFields ( 'filter1', array (
								'Chamado.cdequipamento' => __ ( 'Chamado', true ),
								'Equipamento.serie' => __ ( 'Serie', true ),
								'Chamado.contrato' => __ ( 'Contrato', true ) 
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

					<div class="span5">
						<div class="control-group">
							<label class="control-label"><?php echo __('Campo:'); ?> </label>
							<div class="controls">
							<?php
							echo $this->Search->input ( 'filter1', array (
									'placeholder' => "Localizar Chamado" 
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


<?php echo $this->Search->end(); ?> 
	
			
			<?php echo $this->Session->flash(); ?>
 </fieldset>
			</div>
		</div>
	</div>	
	<?php echo $this->Form->create('Chamado', array('action' => 'index','class'=>' form-signin form-horizontal')); ?>
	<?php echo $this->Form->end(); ?>
	<div class="row-fluid show-grid">
		<div class="span12">
			<div class="pagination pagination-small">
				<ul>
					<?php
					echo $this->Paginator->prev ( '<< ' . __ ( '' ), array (
							'tag' => 'li',
							'escape' => false 
					) );
					echo $this->Paginator->numbers ( array (
							'separator' => '',
							'tag' => 'li' 
					) );
					echo $this->Paginator->next ( __ ( '' ) . ' >>', array (
							'tag' => 'li',
							'escape' => false 
					) );
					?>
				</ul>
			</div>
			<div class="row-fluid show-grid">
				<div class="span12">

					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<?php echo utf8_encode('Chamadoação')?>
						<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><?php //echo $this->Paginator->sort('id','ID'); ?>
						</li>
							<li><?php echo $this->Paginator->sort('seqos','Chamado'); ?>
						</li>
							<li><?php echo $this->Paginator->sort('contrato','Contrato'); ?>
						</li>
							<li><?php echo $this->Paginator->sort('serie','Serie'); ?>
						</li>
							<li><?php echo $this->Paginator->sort('produto_nome','Produto'); ?>
						</li>
							<li><?php echo $this->Paginator->sort('cidade','Cidade'); ?>
						</li>
							<li><?php echo $this->Paginator->sort('departamento','Departamento'); ?>
						</li>
						</ul>
					</div>

				</div>
			</div>
			<form name="form_sel_id">
				<table class="table table-bordered table-hover table-striped">
				<?php
				$attr = 0;
				foreach ( $Chamados as $Chamado ) :
					?>
				<tr>
						<td class="span6"><strong>Chamado:</strong><?php echo h($Chamado['Chamado']['id']); ?>
					<br /> <strong>Serie: </strong><?php echo h($Chamado['Equipamento']['SERIE']); ?>&nbsp;
					<br /> <strong>Contrato: </strong><?php echo h($Chamado['Chamado']['SEQCONTRATO']); ?>&nbsp;</td>
						<td class="span6"><strong>Cliente: </strong><?php echo h($Chamado['Chamado']['NMCLIENTE']); ?>&nbsp;
					<br /> <strong>Cidade: </strong><?php echo strtoupper($Chamado['Chamado']['CIDADE']); ?>&nbsp;
					<br /> <strong>Departamento: </strong><?php echo $Chamado['Equipamento']['DEPARTAMENTO']; ?>&nbsp;</td>
					</tr>
					<tr>
						<td class="span6" colspan="3" style="text-align: right;">
                        <?php
					
					echo $this->Acl->link ( '<i class="icon-zoom-in"></i>', array (
							'controller' => 'Chamados',
							'action' => 'add',
							$Chamado ['Chamado'] ['CDEQUIPAMENTO']
					), array (
							'class' => 'btn btn-large btn-default',
							'escape' => false 
					) ); 
					echo '&nbsp;'.$this->Acl->link ( '<i class="icon-edit icon-white"></i>', array (
							'controller' => 'Chamados',
							'action' => 'add',
							$Chamado ['Chamado'] ['CDEQUIPAMENTO']
					), array (
							'class' => 'btn btn-large btn-info',
							'escape' => false 
					) );
					?>
						</td>
					</tr>
				<?php $attr ++; ?>
				<?php endforeach; ?>
			</table>
			</form>
			<p>
				<?php
				echo $this->Paginator->counter ( array (
						'format' => __ ( 'Pagina {:page} de {:pages}, mostrando {:current} registros de {:count} no total, iniciando no registro {:start}, terminando em {:end}' ) 
				) );
				?>
			</p>

			<div class="pagination">
				<ul>
					<?php
					echo $this->Paginator->prev ( '&larr; ' . __ ( 'Anterior' ), array (
							'tag' => 'li',
							'escape' => false 
					) );
					echo $this->Paginator->numbers ( array (
							'separator' => '',
							'tag' => 'li' 
					) );
					echo $this->Paginator->next ( __ ( 'Proximo' ) . ' &rarr;', array (
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
	window.location = '<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Chamados','action' => 'index')); ?>';
}
function showAddChamadoPage() {
	window.location = "<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Chamados','action' => 'aberturaOs',$Chamado['Chamado']['id'])); ?>";
}
function delChamado(Chamado_id, name) {
    $.sModal({
        image: '<?php echo $this->webroot; ?>img/icons/error.png',
        content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + name + '</b>?',
        animate: 'fadeDown',
        buttons: [{
            text: ' <?php echo __('Delete'); ?> ',
            addClass: 'btn-danger',
            click: function(id, data) {
                $.post('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Chamados','action' => 'delete')); ?>/' + Chamado_id, {}, function(o) {
	                    $('#container').load('<?php echo Router::url(array('plugin' => 'Pws','controller' => 'Chamados','action' => 'index')); ?>', function() {
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

function selEquip() {
	total = document.form_sel_id.sel_equip.length;
	fals=0; 
	for(i = 0; i < total; i++) {
	 
	if(document.form_sel_id.sel_equip[i].checked==true) {
	alert(document.form_sel_id.sel_equip[i].value)
	} else {
	fals++;	
	}
  }
	  if (fals==total){
		  content = 'Por Favor Selecione um Chamado para a Abrir um Chamado.';
		  $.sModal({
		        image: '<?php echo $this->webroot; ?>img/icons/error.png',
		        content: '<b>' + content + '</b>',
		        animate: 'fadeDown',
		        buttons: [{
		            text: ' <?php echo __('Ok'); ?> ',
		            click: function(id, data) {
		                $.sModal('close', id);
		            }
		        }]
		        });	
//   		$(this).click(function(){
// 			var strAlertSuccess = '<div class="alert alert-error" style="position: fixed; right:0px; top:45px; display: none;">'
// 				+ '<button data-dismiss="alert" class="close" type="button">Ã—</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('Por Favor Selecione um Chamado na Listagem.'); ?>' + '</div>';
// 			var alertSuccess = $(strAlertSuccess).appendTo('body');
// 			alertSuccess.show();
// 			setTimeout(function() {
// 				alertSuccess.remove();
// 			}, 10000);
// 			$("#container  table").unmask();
// 		});
	  }
}

function msg(content){
    $.sModal({
        image: '<?php echo $this->webroot; ?>img/icons/alert.png',
        content: '<?php echo __('Are you sure you want to delete'); ?>  <b>' + content + '</b>?',
        animate: 'fadeDown',
        buttons: [{
            text: ' <?php echo __('Cancel'); ?> ',
            click: function(id, data) {
                $.sModal('close', id);
            }
        }]
        });	
}



</script>
