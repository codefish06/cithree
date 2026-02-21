<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vendors - <?php echo APP_NAME; ?></title>
	<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('application/assets/css/grid-layout.css'); ?>" rel="stylesheet">
</head>
<body class="app-body">

<div class="grid-container">
	<?php $this->load->view('template/header_menu'); ?>
	<main>
	<h1 class="page-title">Vendor Package Testing</h1>

	<div class="page-content">
		<p class="text-block">This page provides a comprehensive listing of all third-party vendor packages integrated and tested in this application.</p>

		<h2 class="section-label">Vendor Packages</h2>
		
		<table class="table-standard">
			<thead>
				<tr>
					<th>Package Name</th>
					<th>Version</th>
					<th>Description</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Select2</td>
					<td>4.1.0</td>
					<td>jQuery plugin for enhanced select boxes with search and tagging capabilities</td>
					<td><span class="status-active">Active</span></td>
					<td><a href="<?php echo base_url('vendor/select2'); ?>" class="link-primary">Test</a></td>
				</tr>
			</tbody>
		</table>

	</div>
	</main>
	<?php $this->load->view('template/footer'); ?>

</div>

</body>
</html>
