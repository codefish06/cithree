<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$page_title = 'Select2 Demo';
$active_nav = 'vendor_select2';
$extra_styles = [
    base_url('application/assets/vendor/select2/css/select2.min.css'),
    base_url('application/assets/css/vendor/select2-customization.css'),
];
$extra_scripts = [
    base_url('application/assets/vendor/jquery/jquery.min.js'),
    base_url('application/assets/vendor/select2/js/select2.min.js'),
];
$extra_inline_scripts = [
<<<'JS'
document.addEventListener('DOMContentLoaded', function() {
    if (!window.jQuery || !jQuery.fn.select2) {
        return;
    }

    jQuery('#singleSelect').select2({
        placeholder: 'Select an option',
        allowClear: true
    });

    jQuery('#singleCustomSelect').select2({
        placeholder: 'Select an option',
        allowClear: true,
        dropdownCssClass: 'custom-select2-dropdown'
    });

    jQuery('#multipleSelect').select2({
        placeholder: 'Select options'
    });

    jQuery('#tagsSelect').select2({
        placeholder: 'Select options'
    });
});
JS
];
$this->load->view('template/app_start');
?>

<div class="app-page-header">
    <p class="app-page-kicker">Vendor Demo</p>
    <div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-end gap-3">
        <div>
            <h1 class="h2 mb-2">Select2 integration</h1>
            <p class="text-secondary mb-0">Bootstrap form controls wrapped around the Select2 demo states used in this app.</p>
        </div>
        <a href="<?php echo site_url('vendor'); ?>" class="btn btn-outline-secondary">Back to vendors</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="h5 mb-4">Examples</h2>
                <form class="row g-4">
                    <div class="col-12">
                        <label for="singleSelect" class="form-label">Basic single select</label>
                        <select id="singleSelect" class="form-select">
                            <option></option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                            <option value="4">Option 4</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="singleCustomSelect" class="form-label">Single custom select</label>
                        <select id="singleCustomSelect" class="form-select">
                            <option></option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                            <option value="4">Option 4</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="multipleSelect" class="form-label">Multiple select</label>
                        <select id="multipleSelect" class="form-select" multiple>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                            <option value="4">Option 4</option>
                            <option value="5">Option 5</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="tagsSelect" class="form-label">Tagging support</label>
                        <select id="tagsSelect" class="form-select" multiple>
                            <option value="Tag1">Tag1</option>
                            <option value="Tag2">Tag2</option>
                            <option value="Tag3">Tag3</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Notes</h2>
                <ul class="text-secondary mb-0">
                    <li>Single-select examples use clearable placeholders.</li>
                    <li>Multiple-select examples keep full-width responsive sizing.</li>
                    <li>Custom overrides stay isolated to the Select2 stylesheet.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/app_end'); ?>
