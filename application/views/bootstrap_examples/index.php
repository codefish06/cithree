<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$this->load->view('template/app_start');
?>

<div class="app-page-header">
    <p class="app-page-kicker">Reference</p>
    <h1 class="h2 mb-2">Bootstrap 5.3 examples</h1>
    <p class="text-secondary mb-0">Local reference copies of the Bootstrap example pages. Each example opens in a new tab and uses the Bootstrap assets already copied into this application.</p>
</div>

<div class="row g-4">
    <?php foreach ($examples as $example) { ?>
        <div class="col-md-6 col-xl-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                        <h2 class="h5 mb-0"><?php echo htmlspecialchars($example['title'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <?php if ($example['is_rtl']) { ?>
                            <span class="badge text-bg-secondary">RTL</span>
                        <?php } ?>
                    </div>
                    <p class="text-secondary small mb-4"><?php echo htmlspecialchars($example['slug'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="mt-auto">
                        <a href="<?php echo $example['url']; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary">
                            Open example
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php $this->load->view('template/app_end'); ?>
