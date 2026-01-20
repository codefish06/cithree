<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Select2 Testing - <?php echo APP_NAME; ?></title>

	<!-- Select2 CSS -->
	<link href="<?php echo base_url('assets/vendor/select2/css/select2.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('assets/vendor/select2/css/select2-bootstrap-5-theme.min.css'); ?>" rel="stylesheet" />

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

	.form-group {
		margin-bottom: 20px;
		padding: 15px;
		background-color: #f9f9f9;
		border: 1px solid #E0E0E0;
		border-radius: 4px;
	}

	label {
		display: block;
		margin-bottom: 8px;
		font-weight: bold;
		color: #333;
	}

	.select2-container--bootstrap-5 .select2-selection--single {
		height: 38px;
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
	<h1>Select2 Vendor Testing</h1>

	<div id="body">
		<p>This page demonstrates Select2 functionality - a jQuery plugin for enhanced select boxes with search and tagging capabilities.</p>

		<h2>Select2 Examples</h2>

		<form>
			<div class="form-group">
				<label for="singleSelect">Single Select</label>
				<select id="singleSelect" class="form-control" style="width: 100%;">
					<option></option>
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
				</select>
			</div>

			<div class="form-group">
				<label for="multipleSelect">Multiple Select</label>
				<select id="multipleSelect" class="form-control" multiple="multiple" style="width: 100%;">
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
					<option value="5">Option 5</option>
				</select>
			</div>

            <div class="form-group">
                <label for="tagsSelect">Tagging Support</label>
                <select id="tagsSelect" class="form-control" multiple="multiple" style="width: 100%;">
                    <option value="Tag1">Tag1</option>
                    <option value="Tag2">Tag2</option>
                    <option value="Tag3">Tag3</option>
                </select>
            </div>
		</form>

		<p><a href="<?php echo base_url('vendor'); ?>">Back to Vendor Testing</a></p>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' . ' | APP Version <strong>' . APP_VERSION . '</strong>' : '' ?></p>
</div>

<!-- jQuery -->
<script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>

<!-- Select2 JS -->
<script src="<?php echo base_url('assets/vendor/select2/js/select2.min.js'); ?>"></script>

<script>
	$(document).ready(function() {
		$('#singleSelect').select2({
			placeholder: "Select an option",
			allowClear: true,
			theme: "bootstrap-5"
		});

		$('#multipleSelect').select2({
			placeholder: "Select options",
			theme: "bootstrap-5"
		});
	});
</script>
</body>
</html>