<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vendor Testing - <?php echo APP_NAME; ?></title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
		text-decoration: none;
		padding: 4px 8px;       
		border-radius: 3px;
	}

	a:hover {
		color: #fff;
		background-color: #003399;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 24px;
		font-weight: normal;
		margin: 0 0 20px 0;
		padding: 14px 15px 10px 15px;
	}

	h2 {
		color: #666;
		font-size: 16px;
		margin: 20px 0 10px 0;
		padding: 0;
	}

	table {
		width: 100%;
		border-collapse: collapse;
		margin: 20px 0;
	}

	table thead {
		background-color: #f5f5f5;
		border-bottom: 2px solid #D0D0D0;
	}

	table th {
		padding: 12px;
		text-align: left;
		font-weight: bold;
		color: #333;
	}

	table td {
		padding: 12px;
		border-bottom: 1px solid #E0E0E0;
	}

	table tr:hover {
		background-color: #f9f9f9;
	}

	.status-active {
		color: #28a745;
		font-weight: bold;
	}

	.status-testing {
		color: #ffc107;
		font-weight: bold;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p {
		margin: 0 0 10px;
		padding: 0;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Vendor Package Testing</h1>

	<div id="body">
		<p>This page provides a comprehensive listing of all third-party vendor packages integrated and tested in this application.</p>

		<h2>Vendor Packages</h2>
		
		<table>
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
					<td><a href="<?php echo base_url('vendor/select2'); ?>">Test</a></td>
				</tr>
			</tbody>
		</table>

	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' . ' | APP Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
