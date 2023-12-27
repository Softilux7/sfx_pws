<?php
$strAction = $this->plugin . $this->name . $this->action;
$menus = array();
$menus['AuthAclAuthAclindex'] = 1;
$menus['AuthAclUsersindex'] = 2; // User menu
$menus['AuthAclUsersadd'] = 2;
$menus['AuthAclUsersview'] = 2;
$menus['AuthAclGroupsindex'] = 2;
$menus['AuthAclPermissionsindex'] = 2;
$menus['AuthAclPermissionsuser'] = 2;
$menus['AuthAclPermissionsuserPermission'] = 2;

$menus['ArticleArticlesindex'] = 3;
$menus['ArticleCategoriesindex'] = 3;

$menus['AuthAclSettingsindex'] = 4;
$menus['AuthAclSettingsemail'] = 4;
$menus['AuthAclUserseditAccount'] = 5;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo ($auth_user['EmpresaSelected']['Empresa']['empresa_fantasia'] . ' | Portal Web de Serviços'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>img/favicon.ico" />
    <?php $version = 7; ?>
    <link href="<?php echo $this->webroot; ?>css/template.css?v=<?php echo $version; ?>" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>css/font-awesome/css/font-awesome.min.css?v=<?php echo $version; ?>" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>bootstrap/css/bootstrap-responsive.min.css?v=<?php echo $version; ?>" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>bootstrap-modal/css/animate.min.css?v=<?php echo $version; ?>" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>jquery/jquery-loadmask/jquery.loadmask.css?v=<?php echo $version; ?>" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>bootgrid/jquery.bootgrid.min.css?v=<?php echo $version; ?>" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>datetimepicker/css/jquery.datetimepicker.css?v=<?php echo $version; ?>" rel="stylesheet">

    <script src="<?php echo $this->webroot; ?>jquery/jquery-1.8.2.min.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>jquery/jquery-loadmask/jquery.loadmask.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>jquery/jquery.maskMoney.min.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>js/jquery.mask.min.js?v=<?php echo $version; ?>"></script>

    <script src="<?php echo $this->webroot; ?>jquery/jquery.cookie.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>bootstrap/js/bootstrap.min.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>pwsjs/app.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>pwsjs/init.js?v=<?php echo $version; ?>"></script>

    <script src="<?php echo $this->webroot; ?>jqueryform/jquery.form.min.js?v=<?php echo $version; ?>"></script>

    <script src="<?php echo $this->webroot; ?>select2/js/select2.min.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>select2/js/i18n/pt-BR.js?v=<?php echo $version; ?>"></script>
    <link href="<?php echo $this->webroot; ?>select2/css/select2.min.css?v=<?php echo $version; ?>" rel="stylesheet">

    <script src="<?php echo $this->webroot; ?>bootstrap-modal/js/bootstrap.modal.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>bootstrap-modal/js/jquery.easing.1.3.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>tiny_mce/tiny_mce.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>inputmask/jquery.inputmask.bundle.js?v=<?php echo $version; ?>"></script>
    <script src="<?php echo $this->webroot; ?>datetimepicker/js/jquery.datetimepicker.js?v=<?php echo $version; ?>"></script>


    <style>
        table>thead>tr>th {
            cursor: default;
            text-align: center;
            color: #333333;
            text-shadow: 0 1px 0 #FFFFFF;
            background-color: #e6e6e6;
        }

        table>thead>tr>th>a {
            color: black;
        }
    </style>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJzqCIQ3uPa_gK3-VG3LhHNDB-pWL09ho&callback=initMap" type="text/javascript"></script> -->
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-91180159-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body>
    <div class="navbar navbar-inverse navbar-fixed-top hidden-print" id="mnu_admin_top">
        <div class="navbar-inner" style="background:#1e1e1e">
            <div class="container-fluid">

                <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target="#navbar">
                    <i class="fa fa-bars  fa-2x"></i>
                </button>
                <a class="navbar-brand" style="rad" title="Home" href="<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'auth_acl', 'action' => 'index')); ?>">    
                    <img class="brandimg" src="<?php echo $auth_user['EmpresaSelected']['Empresa']['logo'] ?>" style=" width: 3rem !important; height: 2.5rem !important;border-radius: 50%!important;margin-top: 8px; !important">
                </a>
                <div id="navbar" class="nav-collapse">

                    
                    <ul class="nav">
                        <li class="divider-vertical"></li>
                        <?php if ($this->Acl->check('AuthAcl', 'index', 'AuthAcl') == true) { ?>
                            <li class="<?php if (isset($menus[$strAction]) && (int) $menus[$strAction] == 1) { ?> active <?php } ?>">
                                <a title="Dashboard" href="<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'auth_acl', 'action' => 'index')); ?>">
                                    <i class="fa fa-home fa-lg"></i>
                                </a>
                            </li>
                        <?php } ?>
                        <?php if(EmpresaPermissionComponent::verifiqueClienteDataVoice($auth_user_group['id'], $auth_user['User']['empresa_id']) == false){?>
                        <li class="divider-vertical"></li>
                        <?php if ($this->Acl->check('Chamados', 'index', 'Pws') == true) { ?>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" title="Usuários" href="#"><i class="fa fa-wrench fa-lg"></i>
                                    <?php echo (__('Ass. Técnica'));  ?>
                                    <b class="caret"></b> </a>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ($this->Acl->check('Chamados', 'add', 'Pws') == true) { ?>
                                        <?php if($auth_user['User']['tecnico_terceirizado'] == false){ ?>
                                            <li><?php echo $this->Html->link((__('Abrir Chamado')), array('plugin' => 'pws', 'controller' => 'ContratoItens', 'action' => 'index')); ?></li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Chamados', 'index', 'Pws') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Acompanhar Chamado'), array('plugin' => 'pws', 'controller' => 'Chamados', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="divider-vertical"></li>
                        <?php if ($this->Acl->check('Solicitacao', 'index', 'Pws') == true) { ?>
                            <li class="dropdown ">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-cubes fa-lg"></i>
                                    <?php echo (__('Solicitações')); ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ($this->Acl->check('ContratoItens', 'index', 'Pws') == true) { ?>
                                        <li><?php echo $this->Html->link((__('Solicitar por Equipamento')), array('plugin' => 'pws', 'controller' => 'ContratoItens', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Contratos', 'index', 'Pws') == true && EmpresaPermissionComponent::verifiquePermissaoModuloContrato($auth_user['User']['empresa_id'], $auth_user_group['id'])) { ?>
                                        <li><?php echo $this->Html->link((__('Solicitar por Contrato')), array('plugin' => 'pws', 'controller' => 'Contratos', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Solicitacao', 'index', 'Pws') == true) { ?>
                                        <li><?php echo $this->Html->link((__('Acompanhar Solicitações')), array('plugin' => 'pws', 'controller' => 'Solicitacao', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>
                        <li class="divider-vertical"></li>
                        <?php if ($this->Acl->check('NfsaidaEntregas', 'index', 'Pws') == true) { ?>
                            <li class="dropdown ">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-truck fa-lg"></i>
                                    <?php echo (__('Transportador')); ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ($this->Acl->check('NfsaidaEntregas', 'index', 'Pws') == true) { ?>
                                        <li><?php echo $this->Html->link((__('Entregas')), array('plugin' => 'pws', 'controller' => 'NfsaidaEntregas', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php } ?>

                        <li class="divider-vertical"></li>
                        <?php if ($this->Acl->check('Users', 'index', 'AuthAcl') == true) { ?>
                            <li class="dropdown<?php if (isset($menus[$strAction]) && (int) $menus[$strAction] == 4) { ?> active <?php } ?>">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="fa fa-cogs fa-lg"></i>
                                    <?php echo (__('Config')); ?>
                                    <b class="caret"></b> </a>
                                <ul class="dropdown-menu">
                                    <?php if ($this->Acl->check('Settings', 'index', 'AuthAcl') == true) { ?>
                                        <li><?php echo $this->Html->link(__('General'), array('plugin' => 'auth_acl', 'controller' => 'settings', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Empresas', 'index', 'AuthAcl') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Empresa'), array('plugin' => 'auth_acl', 'controller' => 'empresas', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Defeitos', 'index', 'Pws') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Tabela Defeitos'), array('plugin' => 'pws', 'controller' => 'defeitos', 'action' => 'index')); ?></li>
                                    <?php } ?>

                                    <li class="nav-header"><?php echo __('Usuários'); ?></li>
                                    <?php if ($this->Acl->check('Users', 'index', 'AuthAcl') == true) { ?>
                                        <li><?php echo $this->Html->link((__('Administrar Usuário')), array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Users', 'allowApp', 'AuthAcl') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Liberar App'), array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'allowApp')); ?></li>
                                    <?php } ?>
                                    <?php if (($auth_user_group['id'] == 1 || $auth_user_group['id'] == 6)&& ($auth_user['User']['empresa_id'] == 1 || $auth_user['User']['empresa_id'] == 136)) { ?>
                                        <li><?php echo $this->Html->link(__('Rastreamento de técnicos'), array('plugin' => 'pws', 'controller' => 'AcompanharAtendimento', 'action' => 'maps')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('UsersLgpd', 'index', 'Pws') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Usuários LGPD'), array('plugin' => 'pws', 'controller' => 'usersLgpd', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Scripts', 'cleanDatabase', 'AuthAcl') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Script - Limpar bases'), array('plugin' => 'auth_acl', 'controller' => 'scripts', 'action' => 'cleanDatabase')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Groups', 'index', 'AuthAcl') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Grupos'), array('plugin' => 'auth_acl', 'controller' => 'groups', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    <?php if ($this->Acl->check('Permissions', 'index', 'AuthAcl') == true) { ?>
                                        <li><?php echo $this->Html->link(__('Permissões'), array('plugin' => 'auth_acl', 'controller' => 'permissions', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                    
                                    <?php if ($this->Acl->check('ConfiguracoesChamado', 'index', 'Pws') == true) { ?>
                                        <li class="nav-header"><?php echo __('Chamados'); ?></li>
                                        <li><?php echo $this->Html->link((__('Status Padrão Abertura Chamado')), array('plugin' => 'pws', 'controller' => 'ConfiguracoesChamado', 'action' => 'index')); ?></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <li class="divider-vertical"></li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                    
                    <ul class="nav pull-right">
                        <?php if (!empty($login_user)) { ?>
                            <li class="divider-vertical"></li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <strong><?php

                                            if ($auth_user['User']['filial_id'] != 0) {
                                                echo $auth_user['EmpresaSelected']['Empresa']['empresa_fantasia'];
                                            } else {
                                                echo " Todas";
                                            }
                                            ?> </strong>
                                    <b class="caret"></b> </a>
                                <ul class="dropdown-menu" style="max-height: 300px;overflow: auto;">
                                    <?php foreach ($auth_user['Empresa'] as $empresa) : ?>
                                        <li><a href="#" onclick="alteraEmp(<?php echo $empresa['id']; ?>);"><i class="fa fa-arrow-right"></i>
                                                <?php echo $empresa['empresa_fantasia']; ?></a></li>
                                    <?php endforeach; ?>
                                    <?php
                                        // específico para empresa ICON DIGITAL 
                                        if($auth_user['User']['filial_id'] != 70){
                                    ?>
                                    <li><a href="#" onclick="alteraEmp('0');"><i class="fa fa-arrow-right">Todas</i></a></li>
                                    <?php }?>
                                </ul>
                            <li class="divider-vertical"></li>
                            <li class="dropdown<?php if (isset($menus[$strAction]) && (int) $menus[$strAction] == 5) { ?> active <?php } ?>">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="fa fa-user fa-lg"></i>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><?php echo $this->Html->link(__('<i class="icon-pencil"></i> Editar Perfil'), array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'editAccount'), array('escape' => false)); ?></li>
                                    <li class="divider"></li>
                                        <?php if($auth_user['User']['dashboard_monitoramento'] == 1){ ?>
                                            <li class="nav-header"><?php echo __('Dashboard'); ?></li>
                                            <li><?php echo $this->Html->link(__('<i class="fa fa-tv fa-lg"></i> Monitoração'), array('plugin' => 'auth_acl', 'controller' => 'authAcl', 'action' => 'dashboard2'), array('escape' => false)); ?></li>
                                            <li class="divider"></li>
                                        <?php }?>
                                    <li class="nav-header"><?php echo __('Cliente'); ?></li>
                                    <li class="dropdown-submenu pull-left">
                                        <a tabindex="-1" href="#">Selecionar Cliente</a>
                                        <ul class="dropdown-menu" style="display: block;max-height: 300px;overflow: auto;">
                                            <?php foreach ($auth_user['Cliente'] as $cliente) : ?>
                                            <li style="<?php if($auth_user['User']['cliente_id'] == $cliente['CDCLIENTE']){ ?>background:#08c<?php }?>">
                                                    <a href="#" onclick="alteraCli(<?php echo $cliente['CDCLIENTE']; ?>);">
                                                        <i class="fa fa-plus-circle"></i>Cliente: <?php echo $cliente['FANTASIA']; ?>
                                                    </a>
                                            <?php endforeach; ?>
                                            <li style="<?php if($auth_user['User']['cliente_id'] == -1 || $auth_user['User']['cliente_id'] == ''){ ?>background:#08c<?php }?>"><a href="#" onclick="alteraCli('-1');"><i class="fa fa-plus-circle"></i> Cliente:Todos</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="divider-vertical"></li>
                            <li>
                                <?php echo $this->Html->link(__('<i class="fa fa-power-off fa-lg"></i> '), array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?>
                            </li>
                        <?php } else { ?>
                            <li><?php echo $this->Html->link(__('Sign in'), array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'login')); ?></li>
                            </a>
                            </li>
                            <li class="divider-vertical"></li>
                        <?php } ?>

                    </ul>
                    
                </div>
                <!--/.nav-collapse -->
            </div>
            
        </div>
        <div style="background: #0081c2;margin:0px;padding:0px;font-size:11px; color:#fff;">
            <div style="display:flex;">
                <div style="margin-left:70px">empresa: <strong><?php echo $_SESSION['auth_user']['Empresa'][0]['empresa_fantasia']; ?></strong></div>
                <div style="margin-left:10px">usuário: <strong><?php echo $_SESSION['auth_user']['User']['user_name']; ?></strong></div>
            </div>
        </div>
        <?php if($TFCREDBLOQ){ ?>
            <div style="background: #cc0000;margin:0px;padding:0px;font-size:12px; color:#fff;display:flex;justify-content:center">
                <div>Atenção entre em contato com a <strong><?php echo $_SESSION['auth_user']['Empresa'][0]['empresa_fantasia'];?></strong> no telefone <strong><?php echo $_SESSION['auth_user']['Empresa'][0]['ddd'] . ' ' . $_SESSION['auth_user']['Empresa'][0]['fone'];?></strong></div>
            </div>
        <?php }?>
        
        <!--
    <div style="background:#ff9900; color:#fff; font-size: 12px; text-align:center">
        <strong>Atenção</strong>, nossos servidores estão passando por uma instabilidade, podendo acarretar em certa demora em algumas funcionalidades do sistema.
        Já estamos trabalhando na solução do problema.
    </div>
    -->
    </div>
    <!-- container -->
    <div class="container-fluid" id="container" style="padding-top: 70px;">
        <div class="modal hide" id="exampleModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                    </div>
                    <div class="modal-body">
                        <div id="modal-body-message" style="position:abolute;background:#cc0000;color: #fff;padding: 3px;position: absolute;top: 59px;right: 15px;font-size: 12px;display:none"></div>
                        <div id="content-data-modal"></div>
                    </div>
                    <div class="modal-footer">
                        <div id="bar-button-modal"><button type="button" id="buttonCloseModal" class="btn btn-danger" data-dismiss="modal">Fechar</button></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal hide" style="z-index:1090" id="modalAlert" tabindex="0" data-backdrop="static" role="dialog" aria-labelledby="modalAlertLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="modalAlertLabel">New message</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div id="content-data-modalAlert"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="buttonClosemodalAlert" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal hide" id="loadingModal" data-backdrop="static" data-keyboard="false">
            <div class="modal-body">
                <div class="progress progress-striped active">
                    <div id="progressBar" class="bar" style="width: 10%;">10% Completo</div>
                </div>
            </div>
        </div>
        <div class="row-fluid" style="padding-top:10px;">

            <!--/.well -->

            <?php
            if (method_exists($this, 'fetch')) {
                echo $this->fetch('content');
            } else {
                echo $content_for_layout;
            }
            ?>
        </div>
    </div>

    <br />
    <br />
    <br />
    <div class="navbar navbar-fixed-bottom hidden-phone" id="barNotify" style="bottom:40px"></div>
    <div class="navbar navbar-fixed-bottom hidden-phone" id="status">
        <div class="btn-toolbar">
            <div class="btn-group pull-right" style="margin-top: 3px;">
                <?php echo __('&copy; PWS Licensed to Softilux 2016 - Versão: ' . $versao['Versao']['versao']); ?>
            </div>

        </div>
    </div>

    <?php echo $this->element('sql_dump'); ?>
    <!-- /container -->
</body>
<script>
    $(document).ready(function() {
        // remove user search cookie
        $('#mnu_admin_top').find('a').each(function() {
            $(this).click(function() {
                removeUserSearchCookie();
            });
        });
        $('#tab_user_manager').find('a').each(function() {
            $(this).click(function() {
                removeUserSearchCookie();
            });
        });

        if ($('#mnu_plugins').children('ul').find('li').length <= 1) {
            $('#mnu_plugins').hide();
        } else {
            $('#mnu_plugins').show();
        }

    });

    function removeUserSearchCookie() {
        $.cookie.raw = true;
        $.removeCookie('CakeCookie[srcPassArg]', {
            path: '/'
        });
    }

    function alteraEmp(id) {
        $("body").loadMask("Aguarde...");
        $.post('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'editEmp')); ?>/' + id, {
            id: id
        }, function(o) {
            document.location.reload();
        });
    }

    function alteraCli(id) {
        $("body").loadMask("Aguarde...");
        $.post('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'editCli')); ?>/' + id, {
            id: id
        }, function(o) {
            document.location.reload();
        });
    }

    // define a base url do sistema para o javascript
    BASE_URL = "<?php echo $this->request->base . "/" . strtolower($this->request->data['auth_plugin']) . "/"; ?>";

    // instancia javascript referente a classe
    new init().__construct('<?php echo __($className); ?>');
</script>

</html>