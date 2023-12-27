<div class="container">
	<h2>
		<?php echo __('User Manager: Permissions'); ?>
	</h2>
	<div class="row-fluid show-grid" id="tab_user_manager">
		<div class="span12">
			<ul class="nav nav-tabs">
				<?php if ($this->Acl->check('Users','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('User Manager'), array('plugin' => 'auth_acl','controller' => 'users','action' => 'index')); ?></li>
				<?php } ?>
				<?php if ($this->Acl->check('Groups','index','AuthAcl') == true){?>
					<li><?php echo $this->Html->link(__('Groups'), array('plugin' => 'auth_acl','controller' => 'groups','action' => 'index')); ?></li>
				<?php }?>
				<?php if ($this->Acl->check('Permissions','index','AuthAcl') == true){?>
					<li class="active"><?php echo $this->Html->link(__('Permissions'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<div class="span12">
			<button class="btn btn-success" type="button"
				onclick="syncAco('<?php echo $user['User']['id']; ?>',this);">
				<i class="icon-refresh icon-white"></i>
				<?php echo __('Sync Acos'); ?>
			</button>
		</div>
	</div>
	<br />
	<div class="row-fluid show-grid" id="permission_tab">
		<ul class="nav nav-tabs">
			<?php if ($this->Acl->check('Permissions','index','AuthAcl') == true){?>
				<li><?php echo $this->Html->link(__('Groups permissions'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'index')); ?></li>
			<?php }?>
			<?php if ($this->Acl->check('Permissions','user','AuthAcl') == true){?>
				<li class="active"><?php echo $this->Html->link(__('Users permissions'), array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'user')); ?></li>
			<?php } ?>
		</ul>
	</div>
	<div class="row-fluid show-grid">
		<a href="<?php echo $this->webroot; ?>auth_acl/permissions/user"
			class="btn"> &larr; <?php echo __('Back'); ?>
		</a>
	</div>
	<br />
	<div class="row-fluid show-grid">
		<div class="span12">
			<table class="table table-bordered table-hover list table-condensed table-striped"
				style="width: auto;">
				<thead>
					<tr>
						<th style="text-align: center;"><?php echo __('Actions / User'); ?>
						</th>
						<th><?php echo $user['User']['user_email']; ?></th>
					</tr>
				</thead>
				<tr>
					<td>All</td>
					<td style="text-align: center;">
					<?php if ($this->Acl->check('Permissions','userAllowAll','AuthAcl') == true || $this->Acl->check('Permissions','userDenyAll','AuthAcl') == true ){?>
						<?php if ($this->Acl->check('Permissions','userAllowAll','AuthAcl') == true){ ?>
						<a href="#"
							onclick="user_allowAll('<?php echo $user['User']['id']; ?>'); return false;"><img
							src="<?php echo $this->webroot; ?>img/icons/allowed.png" /> </a>
						<?php }else{ ?>
							<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
						<?php }?>
						&nbsp; 
						<?php if ($this->Acl->check('Permissions','userDenyAll','AuthAcl') == true){ ?>
						<a href="#"
						onclick="user_denyAll('<?php echo $user['User']['id']; ?>'); return false;">
							<img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
						<?php }else{ ?>
							<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
						<?php } ?>
					</a>
					<?php }else{ ?>
							<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> &nbsp;
							<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
					<?php } ?>
					</td>

				</tr>

				<?php foreach($acoController as $name => $controller){ ?>
				<?php if (!empty($controller['children'])){ ?>
				<?php foreach($controller['children']  as $action){ ?>
				<?php if ($action['Aco']['alias'] == 'isAuthorized') continue; ?>
				<tr>
					<td><?php echo $name; ?>-><?php echo h($action['Aco']['alias']); ?>
					</td>
					<td style="text-align: center;">
					<?php if ($this->Acl->check('Permissions','userAllow','AuthAcl') == true || $this->Acl->check('Permissions','userDeny','AuthAcl')){?>
					<?php if (isset($permissions[$user['User']['id']][$action['Aco']['id']]) && $permissions[$user['User']['id']][$action['Aco']['id']] == 1){ ?>
						<?php if ($this->Acl->check('Permissions','userDeny','AuthAcl') == true){ ?>
						<a href="#"
						onclick="user_deny(this,'<?php echo $user['User']['id']; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
							<img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
					</a> 
					<?php }else{ ?>
						<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" />
					<?php } ?>
					<?php }else{ ?> 
					<?php if ($this->Acl->check('Permissions','userAllow','AuthAcl') == true){ ?>
					<a href="#"
						onclick="user_allow(this,'<?php echo $user['User']['id']; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
							<img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
					</a> 
					<?php }else{ ?>
						<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
					<?php }?>
					<?php } ?>
					<?php }else{ ?>
						<?php if (isset($permissions[$user['User']['id']][$action['Aco']['id']]) && $permissions[$user['User']['id']][$action['Aco']['id']] == 1){ ?>
						<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> 
						<?php }else{ ?>
						<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
						<?php } ?>
					<?php } ?>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
				<?php } ?>

				<?php foreach($acoPlugin as $pluginName => $controllers){ ?>
				<tr>
					<td colspan="2" style="background-color: #E6E6E6; color: #333333;"><strong>Plugin
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
					<td style="text-align: center;">
					<?php if ($this->Acl->check('Permissions','userAllow','AuthAcl') == true || $this->Acl->check('Permissions','userDeny','AuthAcl')){?>
					<?php if (isset($permissions[$user['User']['id']][$action['Aco']['id']]) && $permissions[$user['User']['id']][$action['Aco']['id']] == 1){ ?>
						<?php if ($this->Acl->check('Permissions','userDeny','AuthAcl') == true){?>
						<a href="#"
						onclick="user_deny(this,'<?php echo $user['User']['id']; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
							<img src="<?php echo $this->webroot; ?>img/icons/allowed.png" />
					</a> 
					<?php }else{?>
					<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> 
					<?php } ?>
					<?php }else{ ?>
					<?php if ($this->Acl->check('Permissions','userAllow','AuthAcl') == true){?>
					 <a href="#"
						onclick="user_allow(this,'<?php echo $user['User']['id']; ?>','<?php echo $action['Aco']['id']; ?>'); return false;">
							<img src="<?php echo $this->webroot; ?>img/icons/denied.png" />
					</a> 
					<?php }else{ ?>
					<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
					<?php } ?>
					<?php } ?>
					<?php }else{ ?>
					<?php if (isset($permissions[$user['User']['id']][$action['Aco']['id']]) && $permissions[$user['User']['id']][$action['Aco']['id']] == 1){ ?>
					<img src="<?php echo $this->webroot; ?>img/icons/disabled.png" /> 
					<?php }else{ ?>
					<img src="<?php echo $this->webroot; ?>img/icons/disabled2.png" />
					<?php }?>
					<?php } ?>
					</td>
				</tr>
				<?php } ?>
				<?php } ?>
				<?php } ?>
				<?php } ?>
				<?php } ?>
			</table>
		</div>
	</div>
	<div class="row-fluid show-grid">
		<a href="<?php echo $this->webroot; ?>auth_acl/permissions/user"
			class="btn"> &larr; Back</a>
	</div>

</div>
<script>
	function user_allow(obj, user_id, action_id) {
		$("#container  table").mask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
				+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userAllow')); ?>', {
			data : {
				userId : user_id,
				actionId : action_id
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userPermission')); ?>/'+user_id);
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}

	function user_allowAll(user_id) {
		$("#container  table").mask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
				+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userAllowAll')); ?>', {
			data : {
				userId : user_id,
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userPermission')); ?>/'+user_id);
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}

	function user_deny(obj, user_id, action_id) {
		$("#container  table").mask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
				+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userDeny')); ?>', {
			data : {
				userId : user_id,
				actionId : action_id
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userPermission')); ?>/'+user_id);
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}

	function user_denyAll(user_id) {
		$("#container  table").mask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully changed the permission'); ?>'
				+ '</div>';
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userDenyAll')); ?>', {
			data : {
				userId : user_id,
			}
		}, function(o) {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userPermission')); ?>/'+user_id);
			var alertSuccess = $(strAlertSuccess).appendTo('body');
			alertSuccess.show();
			setTimeout(function() {
				alertSuccess.remove();
			}, 2000);
		}, 'json');
	}

	function syncAco(user_id,obj) {
		$("#container  table").mask("Waiting...");
		var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:45px; display: none;">'
				+ '<button data-dismiss="alert" class="close" type="button">×</button>'
				+ '<strong><?php echo __('Success!'); ?></strong> <?php echo __('You successfully synced the Acos'); ?>'
				+ '</div>';
		$(obj).attr('disabled','disabled');
		$(obj).html('<i class="icon-refresh icon-white"></i> <?php echo __('Sync Acos...'); ?>');
		$.post('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'syncAco')); ?>',{},function() {
			$('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl','controller' => 'permissions','action' => 'userPermission')); ?>/'+user_id);
				var alertSuccess = $(strAlertSuccess).appendTo(
						'body');
				alertSuccess.show();
				setTimeout(function() {
					alertSuccess.remove();
				}, 2000);
			}, 'json');
	}
	$(document).ready(function() {
		$('#permission_tab').find('a').each(function() {
			$(this).click(function() {
				removeUserSearchCookie();
			});
		});
	});
</script>
