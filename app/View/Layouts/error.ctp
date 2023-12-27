<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title><?php echo (__('PWS | Portal Web de Serviços')); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo $this->webroot; ?>img/favicon.ico" />
	<link href="<?php echo $this->webroot; ?>css/template.css" rel="stylesheet">
	<link href="<?php echo $this->webroot; ?>bootstrap-modal/css/animate.min.css" rel="stylesheet">
	<link href="<?php echo $this->webroot; ?>css/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<script src="<?php echo $this->webroot; ?>jquery/jquery-1.8.2.min.js"></script>
	<script src="<?php echo $this->webroot; ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $this->webroot; ?>bootstrap-modal/js/bootstrap.modal.js"></script>
	<script src="<?php echo $this->webroot; ?>bootstrap-modal/js/jquery.easing.1.3.js"></script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="hero-unit center">
					<h1>Page Not Found <small><font face="Tahoma" color="red">Error 404</font></small></h1>
					<br />
					<h2><?php echo $this->Session->flash(); ?></h2>
					<p><?php echo $this->fetch('content'); ?></p>
					<p>A página solicitada não pôde ser encontrada.</p>
					<p><b>Clique em Voltar para voltar a pagina de origem:</b></p>
					<a href="javascript:window.history.go(-1)" class="btn btn-large btn-info"><i class="icon-home icon-white"></i>Voltar</a>
				</div>
				<br />

				<br />
				<p></p>
				<!-- By ConnerT HTML & CSS Enthusiast -->
			</div>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
