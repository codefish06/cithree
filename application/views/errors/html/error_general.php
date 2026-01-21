<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Error</title>
<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
</head>
<body class="bg-white text-gray-600 font-sans">
	<div class="m-3 border border-gray-300 shadow-lg">
		<h1 class="text-lg font-normal text-gray-700 border-b border-gray-300 p-4 pb-2 mb-4"><?php echo $heading; ?></h1>
		<div class="p-4"><?php echo $message; ?></div>
	</div>
</body>
</html>