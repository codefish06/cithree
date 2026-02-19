<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vendor Testing - <?php echo APP_NAME; ?></title>
	<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('application/assets/css/grid-layout.css'); ?>" rel="stylesheet">
</head>
<body class="bg-white text-gray-600 font-sans">

<div class="grid-container">
	<?php $this->load->view('template/header_menu'); ?>
	<main>
	<h1 class="text-2xl font-normal text-gray-700 border-b border-gray-300 p-4 pb-2 mb-5">Appearance</h1>

    <div class="mx-4 my-6">
        <p class="mb-6 text-gray-700">Customize your application's appearance and content management settings below.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Page Editing -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-8 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Page Editing</h3>
                <p class="text-gray-600 text-sm mb-4">Manage and edit your application pages.</p>
                <a href="<?php echo base_url('appearance'); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">Manage Pages →</a>
            </div>

            <!-- CMS UI Settings -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">CMS UI Settings</h3>
                <p class="text-gray-600 text-sm mb-4">Configure user interface and content management options.</p>
                <a href="<?php echo base_url('appearance'); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">Edit Settings →</a>
            </div>

            <!-- Theme Configuration -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Theme Configuration</h3>
                <p class="text-gray-600 text-sm mb-4">Customize colors, fonts, and layout themes.</p>
                <a href="<?php echo base_url('appearance'); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">Configure Theme →</a>
            </div>

            <!-- Content Blocks -->
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Content Blocks</h3>
                <p class="text-gray-600 text-sm mb-4">Manage reusable content sections and widgets.</p>
                <a href="<?php echo base_url('appearance/blocks'); ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">Manage Blocks →</a>
            </div>
        </div>
    </div>
	</main>
	<?php $this->load->view('template/footer'); ?>

</div>

</body>
</html>
