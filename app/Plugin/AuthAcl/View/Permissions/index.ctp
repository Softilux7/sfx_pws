<div class="span12">
	<h2>
		<?php echo __('Administrar Premissão de Usuário'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Users','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('Usuários'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?></li>
				<?php } ?>
				<?php if ($this->Acl->check('Groups','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('Grupos'), array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?></li>
				<?php }?>
				<?php if ($this->Acl->check('Permissions','index','AuthAcl') == true){?>
					<li class="active"><?php echo $this->Html->link(__('Permissão'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<?php if ($this->Acl->check('Permissions','syncAco','AuthAcl') == true){?>
	<div class="row-fluid show-grid">
		<div class="span12">
			<button class="btn btn-success" type="button" onclick="syncAco(this);">
				<i class="icon-refresh icon-white"></i>
				<?php echo __('Sync Acos'); ?>
			</button>
		</div>
	</div>
	<?php } ?>
	<br />
	<div class="row-fluid show-grid" id="permission_tab">
		<ul class="nav nav-tabs">
			<?php if ($this->Acl->check('Permissions','index','AuthAcl') == true){?>
				<li class="active"><?php echo $this->Html->link(__('Groups permissions'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?></li>
			<?php }?>
			<?php if ($this->Acl->check('Permissions','user','AuthAcl') == true){?>
				<li><?php echo $this->Html->link(__('Users permissions'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'user')); ?></li>
			<?php } ?>
		</ul>
	</div>


	<div class="row-fluid show-grid">
		<div class="span12">
			<div style="overflow: auto;">
				<table class="table table-bordered table-hover list table-condensed table-striped"
					style="width: auto;">
					<thead>
						<tr>
							<th style="text-align: center;"><?php echo __('Actions / Groups'); ?>
							</th>
							<?php foreach($groups as $group){ ?>
							<th><?php echo h($group); ?>
							</th>
							<?php }	?>
						</tr>
					</thead>
					<tr>
						<td><?php echo __('All'); ?></td>
						<?php foreach($groups as $groupId => $group){ ?>
						<td style="text-align: center;">
						<?php if ($this->Acl->check('Permissions','allowAll','AuthAcl') == true || $this->Acl->check('Permissions','denyAll','AuthAcl')){?>
						<?php if ($this->Acl->check('Permissions','allowAll','AuthAcl') == true){ ?>
						<a href="#"
							onclick="allowAll('<?php echo $groupId; ?> '); return false;"><img
								src="<?php echo $this->webroot; ?>img/icons/allowed.png" /> </a>
						<?php }else{ ?>
							<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
						<?php } ?>
							&nbsp; 
						<?php if ($this->Acl->check('Permissions','denyAll','AuthAcl') == true){ ?>
							<a href="#"
							onclick="denyAll('<?php echo $groupId; ?> '); return false;"> <img
								src="<?php echo $this->webroot; ?>img/icons/denied.png" />
						</a>
						<?php }else{ ?>
							<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
						<?php } ?>
						<?php }else{ ?>
								<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> &nbsp;
								<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
						<?php } ?>
						</td>

						<?php }	?>
					</tr>

					<?php foreach($acoController as $name => $controller){ ?>
					<?php if (!empty($controller['children'])){ ?>
					<?php foreach($controller['children']  as $action){ ?>
					<?php if ($action['Aco']['alias'] == 'isAuthorized') continue; ?>
					<tr>
						<td><?php echo $name; ?>-><?php echo h($action['Aco']['alias']); ?>
						</td>
						<?php foreach($groups as $groupId => $group){ ?>
						<td style="text-align: center;">
						<?php if ($this->Acl->check('Permissions','allow','AuthAcl') == true || $this->Acl->check('Permissions','deny','AuthAcl')){?>
							<?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
							<?php if ($this->Acl->check('Permissions','deny','AuthAcl') == true){?>
							<a href="#"
							onclick="deny(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
								<img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
						</a> 
						<?php }else{ ?>
							<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
						<?php } ?>
						<?php }else{ ?>
						<?php if ($this->Acl->check('Permissions','allow','AuthAcl') == true){?>
						 <a href="#"
							onclick="allow(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
								<img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
						</a> 
						<?php }else{?>
								<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
						<?php } ?>
						<?php } ?>
						<?php }else{ ?>
							<?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
								<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
							<?php }else{ ?> 
								<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
							<?php } ?>
						<?php } ?>
						</td>

						<?php }	?>
					</tr>
					<?php } ?>
					<?php } ?>
					<?php } ?>

					<?php foreach($acoPlugin as $pluginName => $controllers){ ?>
					<tr>
						<td colspan="<?php echo (count($groups)+1); ?>"
							style="background-color: #E6E6E6; color: #333333;"><strong>Plugin
								<?php echo $pluginName; ?>
						</strong></td>
					</tr>
					<?php if (!empty($controllers['children'])){ ?>
					<?php foreach($controllers['children'] as $name => $controller){ ?>
					<?php if ($controller['Aco']['alias'] == 'AccessDenied') continue; ?>
					<?php if (!empty($controller['children'])){ ?>
					<?php foreach($controller['children']  as $action){ ?>
					<?php if ($action['Aco']['alias'] == 'isAuthorized') continue; ?>
					<?php if ($action['Aco']['alias'] == 'login') continue; ?>
					<?php if ($action['Aco']['alias'] == 'logout') continue; ?>
					<?php if ($action['Aco']['alias'] == 'signup') continue; ?>
					<?php if ($action['Aco']['alias'] == 'activate') continue; ?>
					<?php if ($action['Aco']['alias'] == 'editAccount') continue; ?>
					<?php if ($action['Aco']['alias'] == 'resetPassword') continue; ?>
					<?php if ($action['Aco']['alias'] == 'signupcomplete') continue; ?>
					<?php if ($action['Aco']['alias'] == 'activecomplete') continue; ?>
					<tr>
						<td><?php echo h($controller['Aco']['alias']); ?>-><?php echo h($action['Aco']['alias']); ?>
						</td>
						<?php foreach($groups as $groupId => $group){ ?>
						<td style="text-align: center;"><?php if ($this->Acl->check('Permissions','allow','AuthAcl') == true || $this->Acl->check('Permissions','deny','AuthAcl')){?>
							<?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
							<?php if ($this->Acl->check('Permissions','deny','AuthAcl') == true){?>
							<a href="#"
							onclick="deny(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
								<img src="<?php echo $this->webroot; ?>img/icons/allowed.png" /> </a>
							<?php }else{ ?>
								<img
								src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
							<?php } ?>
						 <?php }else{ ?> 
							<?php if ($this->Acl->check('Permissions','allow','AuthAcl') == true){?>
							<a href="#"
							onclick="allow(this,'<?php echo $groupId; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
								<img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
						</a>
							<?php }else{ ?>
								<img
								src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
							<?php } ?>
						 <?php } ?> <?php } else{ ?> <?php if (isset($permissions[$groupId][$action['Aco']['id']]) && $permissions[$groupId][$action['Aco']['id']] == 1){ ?>
							<img
								src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
							<?php }else{ ?> <img
								src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
						 <?php } ?> <?php } ?></td>
						<?php }	?>
					</tr>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
					<?php } ?>
				</table>
			</div>
		</div>
	</div>

</div>
<script>
	function allow(obj, group_id, action_id) {
		$("#container  table").loadMask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
				+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'allow')); ?>', {
			data : {
				groupId : group_id,
				actionId : action_id
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}
	
	function allowAll(group_id){
		$("#container  table").loadMask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
			+ '<button data-dismiss="alert" class="close" type="button">×</button>'
			+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
			+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'allowAll')); ?>', {
			data : {
				groupId : group_id
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}
	
	function deny(obj, group_id, action_id) {
		$("#container  table").loadMask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
				+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'deny')); ?>', {
			data : {
				groupId : group_id,
				actionId : action_id
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}
	
	function denyAll(group_id){
		$("#container  table").loadMask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
			+ '<button data-dismiss="alert" class="close" type="button">×</button>'
			+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
			+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'denyAll')); ?>', {
			data : {
				groupId : group_id,
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}

	function syncAco(obj) {
		$("#container  table").loadMask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully synced the Acos'); ?>'
				+ '</div>';
		$(obj).attr('disabled','disabled');
		$(obj).html('<i class="icon-refresh icon-white"></i> <?php echo __('Sync Acos...'); ?>');
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'syncAco')); ?>',{},function() {
				$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?>');
				var alertSuccess = $(strAlertSuccess).appendTo(
						'body');
				alertSuccess.show();
				setTimeout(function() {
					alertSuccess.remove();
				}, 2000);
			}, 'json');
	}
	$(document).ready(function(){
		$('#permission_tab').find('a').each(function() {
			$(this).click(function() {
				removeUserSearchCookie();
			});
		});
	});
</script>
