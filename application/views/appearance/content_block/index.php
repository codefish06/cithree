<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$page_title = 'Content Blocks';
$active_nav = 'content_block';
$this->load->view('template/app_start');
?>

<div class="app-page-header d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-end gap-3">
    <div>
        <p class="app-page-kicker">Appearance</p>
        <h1 class="h2 mb-2">Content blocks</h1>
        <p class="text-secondary mb-0">Reusable sections and widgets, ready to be edited and eventually surfaced across pages.</p>
    </div>
    <div class="app-page-actions">
        <a href="<?php echo site_url('content_block/create'); ?>" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M8 1a.5.5 0 0 1 .5.5V7.5H14a.5.5 0 0 1 0 1H8.5V14a.5.5 0 0 1-1 0V8.5H2a.5.5 0 0 1 0-1h5.5V1.5A.5.5 0 0 1 8 1z"></path>
            </svg>
            New block
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <div class="list-group-item px-4 py-4 d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-3">
                <div>
                    <h2 class="h5 mb-1">Header Block</h2>
                    <p class="text-secondary mb-0">A reusable header section for your pages.</p>
                </div>
                <div class="table-actions">
                    <a href="#" class="btn btn-outline-secondary btn-sm">Edit</a>
                    <a href="#" class="btn btn-outline-danger btn-sm">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/app_end'); ?>
