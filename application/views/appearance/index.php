<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$page_title = 'Appearance';
$active_nav = 'appearance';
$this->load->view('template/app_start');
?>

<div class="app-page-header">
    <p class="app-page-kicker">Admin</p>
    <h1 class="h2 mb-2">Appearance</h1>
    <p class="text-secondary mb-0">Manage visual settings and reusable content from a single Bootstrap-based interface.</p>
</div>

<div class="app-card-grid">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="app-builder-icon">
                    <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2 2h12v2H2V2zm0 4h12v8H2V6zm2 2v4h8V8H4z"></path>
                    </svg>
                </span>
                <h2 class="h5 mb-0">Page Editing</h2>
            </div>
            <p class="text-secondary">Manage and edit application pages and page-level content.</p>
            <a href="<?php echo site_url('appearance'); ?>" class="btn btn-outline-primary">Manage pages</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="app-builder-icon">
                    <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M9.669.864 8 0 6.331.864 0 4l1.36.673v6.654L8 16l6.64-4.673V4.673L16 4 9.669.864zM8 1.118l5.186 2.569L8 6.256 2.814 3.687 8 1.118zM2.36 4.53 7.5 7.074v7.08l-5.14-3.62V4.53zm11.28 0v6.004l-5.14 3.62v-7.08l5.14-2.544z"></path>
                    </svg>
                </span>
                <h2 class="h5 mb-0">CMS UI Settings</h2>
            </div>
            <p class="text-secondary">Configure interface conventions and content management defaults.</p>
            <a href="<?php echo site_url('appearance'); ?>" class="btn btn-outline-primary">Edit settings</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="app-builder-icon">
                    <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M5.5.5A.5.5 0 0 1 6 1v1h4V1a.5.5 0 0 1 1 0v1h1A1.5 1.5 0 0 1 13.5 3.5v9A1.5 1.5 0 0 1 12 14H4A1.5 1.5 0 0 1 2.5 12.5v-9A1.5 1.5 0 0 1 4 2h1V1a.5.5 0 0 1 .5-.5zM4 3a.5.5 0 0 0-.5.5V5h9V3.5A.5.5 0 0 0 12 3H4zm8.5 3h-9v6.5A.5.5 0 0 0 4 13h8a.5.5 0 0 0 .5-.5V6z"></path>
                    </svg>
                </span>
                <h2 class="h5 mb-0">Theme Configuration</h2>
            </div>
            <p class="text-secondary">Control layout, color, and typography decisions in a consistent way.</p>
            <a href="<?php echo site_url('appearance'); ?>" class="btn btn-outline-primary">Configure theme</a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="app-builder-icon">
                    <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M1 1h6v6H1V1zm8 0h6v6H9V1zM1 9h6v6H1V9zm8 0h6v6H9V9z"></path>
                    </svg>
                </span>
                <h2 class="h5 mb-0">Content Blocks</h2>
            </div>
            <p class="text-secondary">Manage reusable content sections and widgets used across the application.</p>
            <a href="<?php echo site_url('content_block'); ?>" class="btn btn-primary">Manage blocks</a>
        </div>
    </div>
</div>

<?php $this->load->view('template/app_end'); ?>
