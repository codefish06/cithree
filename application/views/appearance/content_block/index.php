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
<body class="bg-white text-gray-600 font-sans">
    <div class="grid-container">
        <?php $this->load->view('template/header_menu'); ?>
        <main>
            <div class="mx-4 my-6 pb-2 border-b border-gray-300 flex items-center justify-between">
                <h1 class="text-2xl font-normal text-gray-700">Content Blocks</h1>
                <a href="<?php echo base_url('content_block/create'); ?>" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-900 transition ">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Block
                </a>
            </div>

            <div class="mx-4 my-6">
                <!-- Content Blocks Management Interface -->
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Your Content Blocks</h2>
                    <hr class="mb-4 border-gray-300">
                    <!-- Example content block listing -->
                    <ul class="divide-y divide-gray-200">
                        <li class="py-3 flex justify-between items-center">
                            <div>
                                <h3 class="text-md font-medium text-gray-900">Header Block</h3>
                                <p class="text-sm text-gray-600">A reusable header section for your pages.</p>
                            </div>
                            <div>
                                <a href="#" class="text-blue-600 hover:text-blue-800 font-semibold mr-4">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-800 font-semibold">Delete</a>
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