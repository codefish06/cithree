<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('application/assets/css/grid-layout.css'); ?>" rel="stylesheet">
</head>
<body class="app-body">

<div class="grid-container">
	<?php $this->load->view('template/header_menu'); ?>
	<main>
		<h2 class="page-subtitle">Getting Started</h2>

		<div class="content-stack">
			<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

			<p>If you would like to edit this page you'll find it located at:</p>
			<code class="code-block">application/views/welcome_message.php</code>

			<p>The corresponding controller for this page is found at:</p>
			<code class="code-block">application/controllers/Welcome.php</code>

			<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="userguide3/" class="link-primary">User Guide</a>.</p>
		</div>
	</main>
  <?php $this->load->view('template/footer'); ?>
</div>

</body>
</html>
