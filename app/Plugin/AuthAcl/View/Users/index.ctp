<div class="span12">
    <h2>
        <?php echo __('Administrar Usuários'); ?>
    </h2>

    <div class="row-fluid show-grid" id="tab_user_manager">
        <div class="span12">
            <ul class="nav nav-tabs">
                <?php if ($this->Acl->check('Users', 'index', 'AuthAcl') == true) { ?>
                    <li class="active"><?php echo $this->Html->link(__('Usuários'), array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'index')); ?></li>
                <?php } ?>
                <?php if ($this->Acl->check('Groups', 'index', 'AuthAcl') == true) { ?>
                    <li><?php echo $this->Html->link(__('Grupos'), array('plugin' => 'auth_acl', 'controller' => 'groups', 'action' => 'index')); ?></li>
                <?php } ?>
                <?php if ($this->Acl->check('Permissions', 'index', 'AuthAcl') == true) { ?>
                    <li><?php echo $this->Html->link(__('Permissão'), array('plugin' => 'auth_acl', 'controller' => 'permissions', 'action' => 'index')); ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="row-fluid">
        <?php if ($this->Session->check('Message.flash')) { ?>
            <div class="alert">
                <button data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <?php echo($this->Session->flash()); ?>
                <br/>
            </div>
        <?php } ?>
    </div>
    <div class="row-fluid show-grid">
        <?php if ($this->Acl->check('Users', 'add', 'AuthAcl') == true) { ?>
            <div class="span12" style="text-align: right;">
                <button class="btn btn-success" type="button"
                        onclick="showAddUserPage();">
                    <i class="icon-plus icon-white"></i>
                    <?php echo __('Adicionar Usuário'); ?>
                </button>
            </div>
        <?php } ?>
    </div>
    <button type="button" class="btn btn-large btn-success btn-search" data-toggle="collapse"
            data-target="#search">
        <i class="icon-filter icon-white"></i> Filtrar Resultados
    </button>
    <div id="search" class="collapse">
        <div class="row-fluid show-grid">
            <div class="span12">
                <?php echo $this->Search->create('', array('class' => 'form-inline')); ?>
                <fieldset>
                    <legend>Filtro</legend>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Coluna:'); ?> </label>

                            <div class="controls">
                                <?php

                                echo $this->Search->selectFields('filter1', array(
                                    'User.id' => __('ID', true),
                                    'User.user_email' => __('Email', true),
                                    'User.user_name' => __('Nome', true)
                                ), array(
                                    'class' => 'select-box'
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Operador:'); ?> </label>

                            <div class="controls">
                                <?php echo $this->Search->selectOperators('filter1'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="span5">
                        <div class="control-group">
                            <label class="control-label"><?php echo __('Campo:'); ?> </label>

                            <div class="controls">
                                <?php
                                echo $this->Search->input('filter1', array(
                                    'placeholder' => "Localizar Usuário"
                                ));
                                ?>
                                <button class="btn" type="submit">
                                    <?php echo __('Filtrar'); ?>
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
    <div class="pagination pagination-small">
        <ul>
            <?php
            echo $this->Paginator->prev('<< ' . __(''), array(
                'tag' => 'li',
                'escape' => false
            ));
            echo $this->Paginator->numbers(array(
                'separator' => '',
                'tag' => 'li'
            ));
            echo $this->Paginator->next(__('') . ' >>', array(
                'tag' => 'li',
                'escape' => false
            ));
            ?>
        </ul>
    </div>
    <div class="row-fluid show-grid">
        <div class="span12">
            <p>

            <div class="btn-group">
                <a class="btn  btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
                    <?php echo __('Ordenação') ?>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><?php //echo $this->Paginator->sort('id','ID'); ?>
                    </li>
                    <li><?php echo $this->Paginator->sort('id', 'ID'); ?>
                    </li>
                    <li><?php echo $this->Paginator->sort('user_name', 'Nome'); ?>
                    </li>
                    <li><?php echo $this->Paginator->sort('empresa_fantasia', 'Revenda'); ?>
                    </li>
                    <li><?php echo $this->Paginator->sort('created', 'Data Inclusão'); ?>
                    </li>
                    <li><?php echo $this->Paginator->sort('modified', 'Data Alteração'); ?>
                    </li>
                </ul>
            </div>
            </p>
        </div>
    </div>
    <div class="row-fluid show-grid">
        <div class="span12">

            <?php
            // _tst($users[0]);
            $attr = 0;
            foreach ($users as $user) :
                $userId = $user['id'];
                ?>
                <div class="row-fluid show-grid">
                    <div class="span12 well">
                        <div class="span3">
                            <div><strong>Nome do Usuário: </strong>&nbsp;<?php echo h($user['User']['user_name']); ?>
                            </div>
                            <div><strong>Email:</strong>&nbsp;<?php echo h($user['User']['user_email']); ?>
                            </div>
                        </div>
                        <?php //print_r($user['Empresa']); ?>
                        <div class="span3">
                            <div><strong>Empresa: </strong>&nbsp;
                                <?php
                                $groupNames = array();
                                if (!empty($user['Empresa'])) {
                                    foreach ($user['Empresa'] as $empresa) {
                                        // TODO: PALEATIVO
                                        if($empresa['UsersEmpresa']['user_id'] == $userId){
                                            echo $empresa['empresa_fantasia'].";";
                                        }

                                    }
                                }
                                ?>
                            </div>
                            <div><strong>Perfil: </strong>&nbsp;<?php
                                $groupNames = array();
                                if (!empty($user['Group'])) {
                                    foreach ($user['Group'] as $group) {
                                        // TODO: PALEATIVO
                                        if($group['UsersGroup']['user_id'] == $userId){
                                            $groupNames[] = $group['name'];
                                            $groupid= $group['id'];
                                        }
                                    }
                                }
                                echo implode(',', $groupNames);
                                ?>&nbsp;
                            </div>
                        </div>
                        <div class="span1">
                            <div><strong>Status: </strong>&nbsp;
                                <?php if ($this->Acl->check('Users', 'changeStatus', 'AuthAcl') == true ) { ?>
                                    <?php if ($auth_user['User']['id'] != $user['User']['id'] && $groupid != 1 ) { ?>
                                        <a href="#"
                                           onclick="changeStatus(this,'<?php echo h($user['User']['id']); ?>',0); return false;"
                                           id="status_allowed_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 0) { ?> style="display: none;" <?php } ?>>
                                            <img src="<?php echo $this->webroot; ?>img/icons/allowed.png"/>
                                        </a>
                                        <a href="#"
                                           onclick="changeStatus(this,'<?php echo h($user['User']['id']); ?>',1); return false;"
                                           id="status_denied_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 1) { ?> style="display: none;" <?php } ?>>
                                            <img src="<?php echo $this->webroot; ?>img/icons/denied.png"/>
                                        </a>
                                    <?php } else { ?>
                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled.png"/>
                                    <?php } ?>
                                <?php } else { ?>
                                    <a id="status_allowed_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 0) { ?> style="display: none;" <?php } ?>>
                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled.png"/>
                                    </a>
                                    <a id="status_denied_<?php echo h($user['User']['id']); ?>" <?php if ($user['User']['user_status'] == 1) { ?> style="display: none;" <?php } ?>>
                                        <img src="<?php echo $this->webroot; ?>img/icons/disabled2.png"/>
                                    </a>
                                <?php } ?>
                                &nbsp;</div>
                            <div>&nbsp;    </div>
                        </div>
                        <div class="span3">
                            <div><strong>Data Inclusão:</strong>
                                &nbsp; <?php echo date('d/m/Y H:i:s', strtotime($user['User']['created'])); ?></div>

                            <div><strong>Data Alteração:</strong>
                                &nbsp; <?php echo date('d/m/Y H:i:s', strtotime($user['User']['modified'])); ?></div>
                        </div>
                        <div class="span2 text-right">&nbsp;
                            <?php if ($auth_user_group['id']==1 || $groupid != 1) { ?>
                            <?php echo $this->Acl->link('<i class="fa fa-pencil"></i>', array(
                                'controller' => 'Users',
                                'action' => 'edit',
                                h($user['User']['id'])
                            ), array(
                                'class' => 'btn btn-large btn-info',
                                'escape' => false,
                                'title' => 'Editar Usuário'
                            )); ?>
                            <?php if ($auth_user['User']['id'] != $user['User']['id'] && $groupid != 1) { ?>
                                <?php echo $this->Acl->link('Excluir', array('controller' => 'Users', 'action' => 'delete', $user['User']['id']), array('class' => 'btn btn-large btn-danger', 'escape' => true, 'onclick' => 'delUser("' . h($user['User']['id']) . '","' . h($user['User']['user_email']) . '");return false;')); ?>
                            <?php } else { ?>
                                <?php if ($this->Acl->check('Users', 'delete', 'AuthAcl') == true) { ?>
                                    <?php echo $this->Acl->link('Excluir', array(), array('class' => 'btn btn-large btn-danger disabled', 'escape' => true, 'onclick' => 'return false;')); ?>
                                <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php $attr++; ?>
            <?php endforeach; ?>

            <p>
                <?php

                echo $this->Paginator->counter(array(
                    'format' => __('Página {:page} de {:pages}, mostrando {:current} registros de {:count} no total, iniciando no registro {:start}, terminando em {:end}')
                ));
                ?>
            </p>

            <div class="pagination">
                <ul>
                    <?php echo $this->Paginator->prev('&larr; ' . __('Anterior'),
                        array('tag' => 'li', 'escape' => false));
                    echo
                    $this->Paginator->numbers(array('separator' => '', 'tag' => 'li'));
                    echo
                    $this->Paginator->next(__('Proximo') . ' &rarr;', array('tag' => 'li', 'escape' => false)); ?>
                </ul>
            </div>
        </div>
    </div>

</div>
<script>
    function cancelSearch() {
        removeUserSearchCookie();
        window.location = '<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'index')); ?>';
    }
    function delUser(user_id, email) {
        $.sModal({
            image: '<?php echo $this->webroot; ?>img/icons/error.png',
            content: '<?php echo __('Você tem certeza que deseja excluir o usuário'); ?>  <b>' + email + '</b>?',
            animate: 'fadeDown',
            buttons: [{
                text: ' <?php echo __('Excluir'); ?> ',
                addClass: 'btn-danger',
                click: function (id, data) {
                    $.post('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'delete')); ?>/' + user_id, {}, function (o) {
                    
                        $('#container').load('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'index'));  ?>', function () {
                            $.sModal('close', id);
                            $('#tab_user_manager').find('a').each(function () {
                                $(this).click(function () {
                                    removeUserSearchCookie();
                                });
                            });
                        });
                    }, 'json');
                }
            }, {
                text: ' <?php echo __('Cancelar'); ?> ',
                click: function (id, data) {
                    $.sModal('close', id);
                }
            }]
        });
    }
    function changeStatus(obj, user_id, status) {
        $("#container  table").mask("Waiting...");
        if (status == undefined) {
            status = 0;
        }
        $.post('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'changeStatus')); ?>', {
            data: {
                User: {
                    id: user_id,
                    user_status: status
                }
            }
        }, function (o) {
            if (status == 0) {
                $('#status_allowed_' + user_id).hide();
                $('#status_denied_' + user_id).show();
            } else {
                $('#status_allowed_' + user_id).show();
                $('#status_denied_' + user_id).hide();
            }
            var strAlertSuccess = '<div class="alert alert-success" style="position: fixed; right:0px; top:50px; display: none;">'
                + '<button data-dismiss="alert" class="close" type="button">×</button>'
                + '<strong><?php echo __('Success!'); ?></strong> <?php echo __('Status Alterado com Sucesso'); ?>' + '</div>';
            var alertSuccess = $(strAlertSuccess).appendTo('body');
            alertSuccess.show();
            setTimeout(function () {
                alertSuccess.remove();
            }, 2000);
            $("#container  table").unmask();
        }, 'json');
    }
    function showAddUserPage() {
        window.location = "<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'add')); ?>";
    }
    $(document).ready(function () {
        $('.pagination > ul > li').each(function () {
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
