<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Appearance - <?php echo APP_NAME; ?></title>
	<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('application/assets/css/grid-layout.css'); ?>" rel="stylesheet">
</head>
<body class="app-body">

<div class="grid-container">
	<?php $this->load->view('template/header_menu'); ?>
	<main>
	<h1 class="page-title">Appearance</h1>

    <div class="page-content">
        <p class="lead-text">Customize your application's appearance and content management settings below.</p>

        <div class="card-grid">
            <!-- Page Editing -->
            <div class="card card-padded-lg">
                <h3 class="card-title">Page Editing</h3>
                <p class="card-text">Manage and edit your application pages.</p>
                <a href="<?php echo base_url('appearance'); ?>" class="link-primary link-inline">Manage Pages →</a>
            </div>

            <!-- CMS UI Settings -->
            <div class="card">
                <h3 class="card-title">CMS UI Settings</h3>
                <p class="card-text">Configure user interface and content management options.</p>
                <a href="<?php echo base_url('appearance'); ?>" class="link-primary link-inline">Edit Settings →</a>
            </div>

            <!-- Theme Configuration -->
            <div class="card">
                <h3 class="card-title">Theme Configuration</h3>
                <p class="card-text">Customize colors, fonts, and layout themes.</p>
                <a href="<?php echo base_url('appearance'); ?>" class="link-primary link-inline">Configure Theme →</a>
            </div>

            <!-- Content Blocks -->
            <div class="card">
                <h3 class="card-title">Content Blocks</h3>
                <p class="card-text">Manage reusable content sections and widgets.</p>
                <a href="<?php echo base_url('content_block'); ?>" class="link-primary link-inline">Manage Blocks →</a>
            </div>
        </div>
    </div>
	</main>
	<?php $this->load->view('template/footer'); ?>

</div>

</body>
</html>
