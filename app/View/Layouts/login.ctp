<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Bootstrap, from Twitter</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link href="<?php echo $this->webroot; ?>bootstrap/css/bootstrap.css"
	rel="stylesheet">
<link
	href="<?php echo $this->webroot; ?>bootstrap-modal/css/animate.min.css"
	rel="stylesheet">
<style>
body {
	padding-top: 50px;
	/* 60px to make the container go all the way to the bottom of the topbar */
}
</style>
<link
	href="<?php echo $this->webroot; ?>bootstrap/css/bootstrap-responsive.css"
	rel="stylesheet">
</head>
<body>
     
	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('sql_dump'); ?>
	<!-- /container -->
	<script src="<?php echo $this->webroot; ?>jquery/jquery-1.8.2.min.js"></script>
	<script
		src="<?php echo $this->webroot; ?>bootstrap/js/bootstrap.min.js"></script>
	<script
		src="<?php echo $this->webroot; ?>bootstrap-modal/js/bootstrap.modal.js"></script>
	<script
		src="<?php echo $this->webroot; ?>bootstrap-modal/js/jquery.easing.1.3.js"></script>
</body>
</html>
