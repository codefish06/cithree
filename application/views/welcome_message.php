<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
</head>
<body class="bg-white text-gray-600 font-sans">

<div class="m-3 border border-gray-300 shadow-lg">
	<h1 class="text-lg font-normal text-gray-700 border-b border-gray-300 p-4 pb-2 mb-4">Welcome to CodeIgniter!</h1>

	<div class="mx-4 my-6 min-h-24">
		<p class="mb-2">The page you are looking at is being generated dynamically by CodeIgniter.</p>

		<p class="mb-2">If you would like to edit this page you'll find it located at:</p>
		<code class="block bg-gray-100 border border-gray-300 text-blue-900 p-3 my-4 font-mono text-sm">application/views/welcome_message.php</code>

		<p class="mb-2">The corresponding controller for this page is found at:</p>
		<code class="block bg-gray-100 border border-gray-300 text-blue-900 p-3 my-4 font-mono text-sm">application/controllers/Welcome.php</code>

		<p class="mb-2">If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="userguide3/" class="text-blue-600 hover:text-orange-700">User Guide</a>.</p>
	</div>

	<p class="text-right text-xs border-t border-gray-300 py-8 px-3 mt-5">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' . '. APP Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
