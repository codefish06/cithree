<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Content Blocks - <?php echo APP_NAME; ?></title>
    <link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('application/assets/css/grid-layout.css'); ?>" rel="stylesheet">
</head>
<body class="app-body">
    <div class="grid-container">
        <?php $this->load->view('template/header_menu'); ?>
        <main>
            <div class="page-header-row">
                <h1 class="page-title-inline">Content Blocks</h1>
                <a href="<?php echo base_url('content_block/create'); ?>" class="btn btn-dark">
                    <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Block
                </a>
            </div>

            <div class="page-content">
                <!-- Content Blocks Management Interface -->
                <div class="card">
                    <h2 class="card-title">Your Content Blocks</h2>
                    <hr class="separator">
                    <!-- Example content block listing -->
                    <ul class="list-divider">
                        <li class="list-item-row">
                            <div>
                                <h3 class="item-title">Header Block</h3>
                                <p class="item-subtitle">A reusable header section for your pages.</p>
                            </div>
                            <div>
                                <a href="#" class="link-primary link-gap">Edit</a>
                                <a href="#" class="link-danger">Delete</a>
                            </div>
                        </li>
                        <!-- More content blocks can be listed here -->
                    </ul>
                </div>
            </div>
        </main>
        <?php $this->load->view('template/footer'); ?>
    </div>
</body>
</html>
