<!DOCTYPE html>
<html lang="en">
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

	<style>
		body {
			background-color: #d9d9d9;
			background: rgba(0, 0, 0, 0) url("<?php echo $this->webroot; ?>img/1069108.jpg") no-repeat scroll 50% 0;
		}
		.well {
			background-color: #FFF;
		}
		.painel{
			box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.20) !important;
		}
	</style>
</head>
<body>
	<!-- container -->
	<div class="container" id="container">
		<?php //echo $this->Session->flash(); ?>
		<?php //echo $this->Session->flash('auth'); ?>
		<?php 
			if (method_exists($this, 'fetch')){
				echo $this->fetch('content'); 
			}else{
				echo $content_for_layout;
			}	
		?>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
	<!-- /container -->
</body>
</html>
