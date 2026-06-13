<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$page_title = 'Welcome';
$active_nav = 'home';
$this->load->view('template/app_start');
?>

<div class="app-page-header">
    <p class="app-page-kicker">Getting Started</p>
    <h1 class="h2 mb-2">Welcome to <?php echo htmlspecialchars(APP_NAME, ENT_QUOTES, 'UTF-8'); ?></h1>
    <p class="text-secondary mb-0">This page is generated dynamically by CodeIgniter and now uses the shared Bootstrap application shell.</p>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="h4 mb-3">Project entry points</h2>
                <p>The page view is located at:</p>
                <pre class="bg-body-tertiary border rounded p-3"><code>application/views/welcome_message.php</code></pre>
                <p>The corresponding controller is located at:</p>
                <pre class="bg-body-tertiary border rounded p-3"><code>application/controllers/Welcome.php</code></pre>
                <p class="mb-0">If you are new to CodeIgniter, start with the <a href="<?php echo base_url('userguide3/'); ?>">User Guide</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Next steps</h2>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action px-0" href="<?php echo site_url('appearance'); ?>">Review appearance screens</a>
                    <a class="list-group-item list-group-item-action px-0" href="<?php echo site_url('content_block'); ?>">Open content blocks</a>
                    <a class="list-group-item list-group-item-action px-0" href="<?php echo site_url('vendor'); ?>">Inspect vendor integrations</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('template/app_end'); ?>
