<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vendor Testing - <?php echo APP_NAME; ?></title>
	<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
</head>
<body class="bg-white text-gray-600 font-sans">

<div class="m-3 border border-gray-300 shadow-lg">
	<h1 class="text-2xl font-normal text-gray-700 border-b border-gray-300 p-4 pb-2 mb-5">Vendor Package Testing</h1>

	<div class="mx-4 my-6">
		<p class="mb-2">This page provides a comprehensive listing of all third-party vendor packages integrated and tested in this application.</p>

		<h2 class="text-gray-600 text-base font-normal my-5 py-0">Vendor Packages</h2>
		
		<table class="w-full border-collapse my-5">
			<thead class="bg-gray-100 border-b-2 border-gray-300">
				<tr>
					<th class="p-3 text-left font-bold text-gray-900">Package Name</th>
					<th class="p-3 text-left font-bold text-gray-900">Version</th>
					<th class="p-3 text-left font-bold text-gray-900">Description</th>
					<th class="p-3 text-left font-bold text-gray-900">Status</th>
					<th class="p-3 text-left font-bold text-gray-900">Action</th>
				</tr>
			</thead>
			<tbody>
				<tr class="hover:bg-gray-100">
					<td class="p-3 border-b border-gray-200">Select2</td>
					<td class="p-3 border-b border-gray-200">4.1.0</td>
					<td class="p-3 border-b border-gray-200">jQuery plugin for enhanced select boxes with search and tagging capabilities</td>
					<td class="p-3 border-b border-gray-200"><span class="text-green-600 font-bold">Active</span></td>
					<td class="p-3 border-b border-gray-200"><a href="<?php echo base_url('vendor/select2'); ?>" class="text-blue-600 hover:text-orange-700">Test</a></td>
				</tr>
			</tbody>
		</table>

	</div>

	<p class="text-right text-xs border-t border-gray-300 py-8 px-3 mt-5">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' . ' | APP Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
