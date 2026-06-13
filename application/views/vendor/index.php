<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$page_title = 'Vendor Packages';
$active_nav = 'vendor';
$this->load->view('template/app_start');
?>

<div class="app-page-header">
    <p class="app-page-kicker">Integrations</p>
    <h1 class="h2 mb-2">Vendor package testing</h1>
    <p class="text-secondary mb-0">A consolidated view of third-party packages integrated into the application.</p>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Package</th>
                        <th scope="col">Version</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">Select2</td>
                        <td><code>4.1.0</code></td>
                        <td>jQuery plugin for enhanced select boxes with search and tagging support.</td>
                        <td><span class="badge text-bg-success">Active</span></td>
                        <td class="text-end">
                            <a href="<?php echo site_url('vendor/select2'); ?>" class="btn btn-outline-primary btn-sm">Open demo</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->load->view('template/app_end'); ?>
