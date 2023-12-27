<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo($auth_user ['EmpresaSelected']['Empresa']['empresa_fantasia'] . ' | Portal Web de Serviços'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo $this->webroot; ?>img/favicon.ico"/>
    <link href="<?php echo $this->webroot; ?>css/template.css" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $this->webroot; ?>bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link
        href="<?php echo $this->webroot; ?>bootstrap-modal/css/animate.min.css"
        rel="stylesheet">
    <link
        href="<?php echo $this->webroot; ?>jquery/jquery-loadmask/jquery.loadmask.css"
        rel="stylesheet">

    <script src="<?php echo $this->webroot; ?>jquery/jquery-1.8.2.min.js"></script>
    <script src="<?php echo $this->webroot; ?>jquery/jquery-loadmask/jquery.loadmask.js"></script>
    <script src="<?php echo $this->webroot; ?>jquery/jquery.maskMoney.min.js"></script>
    <script src="<?php echo $this->webroot; ?>js/jquery.mask.min.js"></script>

    <script src="<?php echo $this->webroot; ?>jquery/jquery.cookie.js"></script>
    <script src="<?php echo $this->webroot; ?>bootstrap/js/bootstrap.min.js"></script>


    <script src="<?php echo $this->webroot; ?>select2/js/select2.min.js"></script>
    <link href="<?php echo $this->webroot; ?>select2/css/select2.min.css" rel="stylesheet">

    <script
        src="<?php echo $this->webroot; ?>bootstrap-modal/js/bootstrap.modal.js"></script>
    <script
        src="<?php echo $this->webroot; ?>bootstrap-modal/js/jquery.easing.1.3.js"></script>
    <script src="<?php echo $this->webroot; ?>tiny_mce/tiny_mce.js"></script>

    <style>
        table > thead > tr > th {
            cursor: default;
            text-align: center;
            color: #333333;
            text-shadow: 0 1px 0 #FFFFFF;
            background-color: #e6e6e6;
        }

        table > thead > tr > th > a {
            color: black;
        }
    </style>

</head>
<body>


<!-- container -->
<div class="container-fluid" id="container" style="padding-top: 15px;">
    <div class="row-fluid">

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


<br/>
<br/>
<br/>
<div class="navbar navbar-fixed-bottom hidden-phone" id="status">
    <div class="btn-toolbar">
        <div class="btn-group pull-right" style="margin-top: 3px;">
            <?php echo __('&copy; PortalWeb powered by Softilux 2015 - Versão: '.$versao['Versao']['versao']); ?>
        </div>

    </div>
</div>

<?php echo $this->element('sql_dump'); ?>
<!-- /container -->
</body>
<script>
    $(document).ready(function () {
        // remove user search cookie
        $('#mnu_admin_top').find('a').each(function () {
            $(this).click(function () {
                removeUserSearchCookie();
            });
        });
        $('#tab_user_manager').find('a').each(function () {
            $(this).click(function () {
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
        }, function (o) {
            document.location.reload();
        });
    }

    function alteraCli(id) {
        $("body").loadMask("Aguarde...");
        $.post('<?php echo Router::url(array('plugin' => 'auth_acl', 'controller' => 'users', 'action' => 'editCli')); ?>/' + id, {
            id: id
        }, function (o) {
            document.location.reload();
        });
    }
</script>
</html>
