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
<body class="bg-white text-gray-600 font-sans">

<div class="grid-container">
	<?php $this->load->view('template/header_menu'); ?>
	<main>
	<h1 class="text-2xl font-normal text-gray-700 border-b border-gray-300 p-4 pb-2 mb-5">Select2 Vendor Testing</h1>

	<div class="mx-4 my-6">
		<p class="mb-2">This page demonstrates Select2 functionality - a jQuery plugin for enhanced select boxes with search and tagging capabilities.</p>

		<h2 class="text-gray-600 text-base font-normal my-5 py-0">Select2 Examples</h2>

		<form>
			<div class="mb-5 p-4 bg-gray-100 border border-gray-200 rounded">
				<label for="singleSelect" class="block mb-2 font-bold text-gray-900">Basic Single Select</label>
				<select id="singleSelect" class="form-control w-full" style="width: 100%;">
					<option></option>
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
				</select>
			</div>
			<div class="mb-5 p-4 bg-gray-100 border border-gray-200 rounded">
				<label for="singleCustomSelect" class="block mb-2 font-bold text-gray-900">Single Custom Select</label>
				<select id="singleCustomSelect" class="form-control w-full" style="width: 100%;">
					<option></option>
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
				</select>
			</div>
			<div class="mb-5 p-4 bg-gray-100 border border-gray-200 rounded">
				<label for="multipleSelect" class="block mb-2 font-bold text-gray-900">Multiple Select</label>
				<select id="multipleSelect" class="form-control w-full" multiple="multiple" style="width: 100%;">
					<option value="1">Option 1</option>
					<option value="2">Option 2</option>
					<option value="3">Option 3</option>
					<option value="4">Option 4</option>
					<option value="5">Option 5</option>
				</select>
			</div>
            <div class="mb-5 p-4 bg-gray-100 border border-gray-200 rounded">
                <label for="tagsSelect" class="block mb-2 font-bold text-gray-900">Tagging Support</label>
                <select id="tagsSelect" class="form-control w-full" multiple="multiple" style="width: 100%;">
                    <option value="Tag1">Tag1</option>
                    <option value="Tag2">Tag2</option>
                    <option value="Tag3">Tag3</option>
                </select>
            </div>
		</form>

		<p class="mb-2"><a href="<?php echo base_url('vendor'); ?>" class="text-blue-600 hover:text-orange-700">Back to Vendor Testing</a></p>
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