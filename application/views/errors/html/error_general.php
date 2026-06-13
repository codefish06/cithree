<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
</head>
<body class="app-body">
	<div class="error-shell">
		<h1 class="error-title"><?php echo $heading; ?></h1>
		<div class="error-content"><?php echo $message; ?></div>
	</div>
<script src="<?php echo base_url('application/assets/js/theme.js'); ?>"></script>
</body>
</html>
