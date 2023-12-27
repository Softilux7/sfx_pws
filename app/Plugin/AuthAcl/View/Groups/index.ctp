
<h2>
	<?php echo __('User Manager: Groups'); ?>
</h2>
<div class="row-fluid show-grid" id="tab_user_manager">
	<div class="span12">
		<ul class="nav nav-tabs">
			<?php if ($this->Acl->check('Users','index','AuthAcl') == true){?>
				<li><?php echo $this->Html->link(__('User Manager'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?></li>
			<?php } ?>
			<?php if ($this->Acl->check('Groups','index','AuthAcl') == true){?>
				<li class="active"><?php echo $this->Html->link(__('Groups'), array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?></li>
			<?php }?>
			<?php if ($this->Acl->check('Permissions','index','AuthAcl') == true){?>
				<li><?php echo $this->Html->link(__('Permissions'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?></li>
			<?php } ?>
		</ul>
	</div>
</div>
<div class="row-fluid show-grid">
	<?php if ($this->Acl->check('Groups','add','AuthAcl') == true){?>
	<div class="span12" style="text-align: right;">
		<button class="btn btn-success" type="button" onclick='formGroup();'>
			<i class="icon-plus icon-white"></i>
			<?php echo __('Group'); ?>
		</button>
	</div>
	<?php } ?>
</div>
<br />
<div class="row-fluid show-grid">
	<div class="span12">
		<table class="table table-bordered table-hover list table-condensed table-striped">
			<thead>
				<tr>
					<th style="width: 30px; text-align: center;"><?php echo __('ID'); ?>
					</th>
					<th><?php echo __('Name'); ?></th>
					<th style="width: 150px; text-align: center;"><?php echo __('Created'); ?>
					</th>
					<th style="width: 150px; text-align: center;"><?php echo __('Modified'); ?>
					</th>
					<?php if ($this->Acl->check('Groups','edit','AuthAcl') == true || $this->Acl->check('Groups','delete','AuthAcl') == true){?>
					<th class="actions" style="width: 110px; text-align: center;"><?php echo __('Actions'); ?>
					</th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($groups as $group): ?>
				<tr>
					<td style="text-align: center;"><?php echo h($group['Group']['id']); ?>&nbsp;
					</td>
					<td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
					<td style="text-align: center;"><?php echo h($group['Group']['created']); ?>&nbsp;
					</td>
					<td style="text-align: center;"><?php echo h($group['Group']['modified']); ?>&nbsp;
					</td>
					<?php if ($this->Acl->check('Groups','edit','AuthAcl') == true || $this->Acl->check('Groups','delete','AuthAcl') == true){?>
					<td style="text-align: center;">
					<?php if ($this->Acl->check('Groups','edit','AuthAcl') == true){?>
						<a class="btn btn-mini btn-info"	onclick='formGroup("<?php echo h($group['Group']['id']); ?>","<?php echo h($group['Group']['name']); ?>");' ><?php echo __('Edit'); ?></a>
					<?php }?> 
					<?php if ($this->Acl->check('Groups','delete','AuthAcl') == true){?>
						<a class="btn btn-mini btn-danger" 
						onclick='delGroup("<?php echo h($group['Group']['id']); ?>","<?php echo h($group['Group']['name']); ?>")' ><?php echo __('Delete'); ?></a>
					<?php }?>
					</td>
					<?php } ?>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	function delGroup(group_id,name) {
		$.sModal({
			image : '<?php echo $this->webroot; ?>img/icons/error.png',
			content : '<?php echo __('Are you sure you want to delete'); ?> <b>'+name+'</b>?',
			animate : 'fadeDown',
			buttons : [ {
				text : ' <?php echo __('Delete'); ?> ',
				addClass : 'btn-danger',
				click : function(id, data) {
					$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'groups','action' => 'delete')); ?>/'+group_id,{},function(o){
						$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?>', function() {
                			$.sModal('close',id);
                		});
                	},'json');
				}
			}, {
				text : ' <?php echo __('Cancel'); ?> ',
				click : function(id, data) {
					$.sModal('close', id);
				}
			} ]
		});
	}
	
	function formGroup(group_id,name){
		if (group_id == undefined){ 
			group_id = null;
			var header = "<?php echo __('Add Group'); ?>";
		}else{
			var header = "<?php echo __('Edit Group'); ?>";
		};
		var idField = '';
		if (name == undefined){ 
			name = '';
		}else{
			idField = '<input type="hidden" name="data[Group][id]" value="'+group_id+'" />';
		}
		
		var mId = $.sModal({
            header:header,
            animate:'fadeDown',
            content : '<div id="group_error"></div> <form style="margin:0"> Name<span style="color:red;">*</span> &nbsp; <input type="text" class="input-xlarge" value="'+name+'"  name="data[Group][name]"/>'+idField+'<form>',
            buttons:[
                {
                    text:'&nbsp; <?php echo __('Ok'); ?> &nbsp;',
                    addClass:'btn-primary',
                    click:function(id){
                    	if (group_id == null){
	                    	$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'groups','action' => 'add')); ?>',$('#'+id).find('form').serialize(),function(o){
	                    		if (o.error == 0){
		                    		$('#container').load('<?php echo $this->webroot; ?>auth_acl/groups', function() {
		                    			$.sModal('close',id);
		                    		});
	                    		}else{
	                    			var str_error = '<div class="alert alert-error">'+
	                    	              '<button data-dismiss="alert" class="close" type="button">×</button>'+
	                    	              '<strong><?php echo __('Error!'); ?></strong> '+o.error_message+
	                    	            '</div>'
	                    			$('#group_error').html(str_error);
	                    		}
	                    	},'json');
                    	}else{
                    		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'groups','action' => 'edit')); ?>/'+group_id,$('#'+id).find('form').serialize(),function(o){
                    			if (o.error == 0){
	                    			$('#container').load('<?php echo $this->webroot; ?>auth_acl/groups', function() {
		                    			$.sModal('close',id);
		                    		});
                    			}else{
                        			var str_error = '<div class="alert alert-error">'+
                        	              '<button data-dismiss="alert" class="close" type="button">×</button>'+
                        	              '<strong><?php echo __('Error!'); ?></strong> '+o.error_message+
                        	            '</div>'
                        			$('#group_error').html(str_error);
                        		}
	                    	},'json');
                    	}
                        
                    }
                },
                {
                    text:' <?php echo __('Cancel'); ?> ',
                    click:function(id,data){
                        $.sModal('close',id);
                    }
                }
            ]
        });
		
		$('#'+mId).find('input[type="text"]').each(function(){
			$(this).keypress(function(event){
				 if ( event.which == 13 ) {
				 	event.preventDefault();
				 }
			});
		});
	}
</script>
