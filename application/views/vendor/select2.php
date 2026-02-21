<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Vendor: Select2 - <?php echo APP_NAME; ?></title>
	<link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">

	<!-- Select2 CSS -->
	<link href="<?php echo base_url('application/assets/vendor/select2/css/select2.min.css'); ?>" rel="stylesheet" />
	<link href="<?php echo base_url('application/assets/css/grid-layout.css'); ?>" rel="stylesheet">	

</head>
<body class="app-body">

<div class="grid-container">
	<?php $this->load->view('template/header_menu'); ?>
	<main>
	<h1 class="page-title">Select2 Vendor Testing</h1>

	<div class="page-content">
		<p class="text-block">This page demonstrates Select2 functionality - a jQuery plugin for enhanced select boxes with search and tagging capabilities.</p>

		<h2 class="section-label">Select2 Examples</h2>

		<form>
			<div class="form-panel">
				<label for="singleSelect" class="form-label">Basic Single Select</label>
				<select id="singleSelect" class="form-control" style="width: 100%;">
					<option></option>
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
				</select>
			</div>
			<div class="form-panel">
				<label for="singleCustomSelect" class="form-label">Single Custom Select</label>
				<select id="singleCustomSelect" class="form-control" style="width: 100%;">
					<option></option>
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
				</select>
			</div>
			<div class="form-panel">
				<label for="multipleSelect" class="form-label">Multiple Select</label>
				<select id="multipleSelect" class="form-control" multiple="multiple" style="width: 100%;">
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
					<option value="5">Option 5</option>
				</select>
			</div>
            <div class="form-panel">
                <label for="tagsSelect" class="form-label">Tagging Support</label>
                <select id="tagsSelect" class="form-control" multiple="multiple" style="width: 100%;">
                    <option value="Tag1">Tag1</option>
                    <option value="Tag2">Tag2</option>
                    <option value="Tag3">Tag3</option>
                </select>
            </div>
		</form>

		<p class="text-block"><a href="<?php echo base_url('vendor'); ?>" class="link-primary">Back to Vendor Testing</a></p>
	</div>
	</main>
	<?php $this->load->view('template/footer'); ?>	
</div>

<!-- jQuery -->
<script src="<?php echo base_url('application/assets/vendor/jquery/jquery.min.js'); ?>"></script>

<!-- Select2 JS -->
<script src="<?php echo base_url('application/assets/vendor/select2/js/select2.min.js'); ?>"></script>

<script>
	$(document).ready(function() {
		console.log("Initializing Select2...");
		$('#singleSelect').select2({
			placeholder: "Select an option",
			allowClear: true,
		});

		$('#singleCustomSelect').select2({
			placeholder: "Select an option",
			allowClear: true,
			dropdownCssClass: 'custom-select2-dropdown', // Custom CSS class for dropdown
		});

		$('#multipleSelect').select2({
			placeholder: "Select options",
		});

		$('#tagsSelect').select2({
			placeholder: "Select options",
		});
	});
</script>
</body>
</html>
