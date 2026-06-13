<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$strPageTitle = isset($page_title) && $page_title !== ''
    ? $page_title . ' - ' . APP_NAME
    : APP_NAME;
$arrExtraStyles = isset($extra_styles) && is_array($extra_styles) ? $extra_styles : [];
$strActiveNav = isset($active_nav) ? (string) $active_nav : '';
?>
<!doctype html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($strPageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="<?php echo base_url('application/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('application/assets/css/bootstrap-app.css'); ?>" rel="stylesheet">
    <?php foreach ($arrExtraStyles as $strStyleHref) { ?>
        <link href="<?php echo $strStyleHref; ?>" rel="stylesheet">
    <?php } ?>
</head>
<body class="bg-body-tertiary">
<header class="app-topbar sticky-top">
    <div class="container-fluid">
        <div class="app-topbar-shell">
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <button class="navbar-toggler app-topbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#appSidebar" aria-controls="appSidebar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="app-topbar-brand" href="<?php echo site_url(); ?>">
                    <span class="app-brand-badge">B</span>
                    <span class="d-none d-sm-inline"><?php echo htmlspecialchars(APP_NAME, ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
                <nav class="app-topbar-nav d-none d-lg-flex" aria-label="Primary">
                    <a href="<?php echo site_url(); ?>" class="app-topbar-link<?php echo $strActiveNav === 'home' ? ' active' : ''; ?>">Docs</a>
                    <a href="<?php echo site_url('bootstrap_examples'); ?>" class="app-topbar-link<?php echo $strActiveNav === 'bootstrap_examples' ? ' active' : ''; ?>">Examples</a>
                    <a href="<?php echo site_url('appearance'); ?>" class="app-topbar-link<?php echo $strActiveNav === 'appearance' ? ' active' : ''; ?>">UI</a>
                    <a href="<?php echo site_url('vendor'); ?>" class="app-topbar-link<?php echo $strActiveNav === 'vendor' || $strActiveNav === 'vendor_select2' ? ' active' : ''; ?>">Integrations</a>
                </nav>
            </div>

            <form class="app-topbar-search d-none d-md-flex" role="search">
                <span class="app-topbar-search-icon" aria-hidden="true">
                    <svg class="bi" width="16" height="16" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.398 1.398l3.85 3.85.707-.707-3.85-3.85zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                    </svg>
                </span>
                <input type="search" class="form-control" placeholder="Search" aria-label="Search">
                <span class="app-topbar-shortcut">⌘ K</span>
            </form>

            <div class="app-topbar-actions">
                <a href="<?php echo site_url('bootstrap_examples'); ?>" class="app-topbar-icon-link d-none d-lg-inline-flex" title="Bootstrap Examples">
                    <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M2 1h12v3H2V1zm0 5h5v9H2V6zm7 0h5v4H9V6zm0 6h5v3H9v-3z"></path>
                    </svg>
                </a>
                <a href="https://getbootstrap.com/docs/5.3/" target="_blank" rel="noopener noreferrer" class="app-topbar-icon-link d-none d-lg-inline-flex" title="Bootstrap Docs">
                    <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M8 0C3.58 0 0 3.58 0 8s3.58 8 8 8c1.77 0 3.4-.58 4.72-1.56l-2.03-1.7A4.98 4.98 0 0 1 8 13a5 5 0 1 1 4.9-6h-2.15l2.86 3.5L16 7h-2.09A6 6 0 0 0 8 0z"></path>
                    </svg>
                </a>
                <div class="dropdown d-none d-lg-block">
                    <button class="app-topbar-version dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        v5.3
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><span class="dropdown-item-text">Bootstrap 5.3 reference</span></li>
                    </ul>
                </div>
                <button type="button" class="app-topbar-theme" data-theme-toggle="true" aria-pressed="false">
                    <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                        <path d="M8 1a.5.5 0 0 1 .5.5V3a.5.5 0 0 1-1 0V1.5A.5.5 0 0 1 8 1zm0 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm5-4a.5.5 0 0 1 .5-.5H15a.5.5 0 0 1 0 1h-1.5A.5.5 0 0 1 13 8zM1 8a.5.5 0 0 1 .5-.5H3a.5.5 0 0 1 0 1H1.5A.5.5 0 0 1 1 8zm10.657-4.657a.5.5 0 0 1 .707 0l1.06 1.06a.5.5 0 1 1-.707.708l-1.06-1.061a.5.5 0 0 1 0-.707zm-8.485 8.485a.5.5 0 0 1 .707 0l1.06 1.06a.5.5 0 0 1-.707.708l-1.06-1.06a.5.5 0 0 1 0-.708zm9.545.707a.5.5 0 0 1 0-.707l1.06-1.06a.5.5 0 1 1 .707.707l-1.06 1.06a.5.5 0 0 1-.707 0zM3.879 4.05a.5.5 0 0 1 0-.708L4.94 2.282a.5.5 0 1 1 .707.707L4.586 4.05a.5.5 0 0 1-.707 0z"></path>
                    </svg>
                    <span class="visually-hidden" data-theme-label>Dark</span>
                </button>
            </div>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="appSidebar" class="col-lg-2 offcanvas-lg offcanvas-start border-end bg-body" tabindex="-1" aria-labelledby="appSidebarLabel">
            <div class="offcanvas-header border-bottom">
                <h2 class="offcanvas-title fs-5" id="appSidebarLabel"><?php echo htmlspecialchars(APP_NAME, ENT_QUOTES, 'UTF-8'); ?></h2>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#appSidebar" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body d-lg-flex flex-column p-0">
                <div class="list-group list-group-flush app-sidebar-nav rounded-0">
                    <a href="<?php echo site_url(); ?>" class="list-group-item list-group-item-action border-0 px-3 py-3<?php echo $strActiveNav === 'home' ? ' active' : ''; ?>">
                        <span class="d-inline-flex align-items-center gap-2">
                            <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5H6a.5.5 0 0 0 .5-.5V10h3v4.5a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354z"></path>
                            </svg>
                            Home
                        </span>
                    </a>
                    <a href="<?php echo site_url('appearance'); ?>" class="list-group-item list-group-item-action border-0 px-3 py-3<?php echo $strActiveNav === 'appearance' ? ' active' : ''; ?>">
                        <span class="d-inline-flex align-items-center gap-2">
                            <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M.5 13.5a.5.5 0 0 1 .5-.5h1.793l9.147-9.146a.5.5 0 0 1 .708 0l1.5 1.5a.5.5 0 0 1 0 .707L5 15H1a.5.5 0 0 1-.5-.5zm11.354-9.646-1-1L3.707 10H3v.707L10.854 2.854z"></path>
                            </svg>
                            Appearance
                        </span>
                    </a>
                    <a href="<?php echo site_url('content_block'); ?>" class="list-group-item list-group-item-action border-0 px-3 py-3<?php echo $strActiveNav === 'content_block' ? ' active' : ''; ?>">
                        <span class="d-inline-flex align-items-center gap-2">
                            <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M1 1h6v6H1V1zm8 0h6v6H9V1zM1 9h6v6H1V9zm8 0h6v6H9V9z"></path>
                            </svg>
                            Content Blocks
                        </span>
                    </a>
                    <a href="<?php echo site_url('vendor'); ?>" class="list-group-item list-group-item-action border-0 px-3 py-3<?php echo $strActiveNav === 'vendor' ? ' active' : ''; ?>">
                        <span class="d-inline-flex align-items-center gap-2">
                            <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4H0V2zm0 5h16v7a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V7zm3 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1H3z"></path>
                            </svg>
                            Vendor Packages
                        </span>
                    </a>
                    <a href="<?php echo site_url('vendor/select2'); ?>" class="list-group-item list-group-item-action border-0 px-3 py-3<?php echo $strActiveNav === 'vendor_select2' ? ' active' : ''; ?>">
                        <span class="d-inline-flex align-items-center gap-2">
                            <svg class="bi" width="16" height="16" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M3.5 2A1.5 1.5 0 0 0 2 3.5v9A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 12.5 2h-9zM5 5.5A1.5 1.5 0 1 1 8 5.5 1.5 1.5 0 0 1 5 5.5zm5.5 5.5h-5a.5.5 0 0 1-.4-.8l1.4-1.867a.5.5 0 0 1 .8 0l1.2 1.6.9-1.2a.5.5 0 0 1 .8 0l1.7 2.267a.5.5 0 0 1-.4.8z"></path>
                            </svg>
                            Select2 Demo
                        </span>
                    </a>
                </div>
                <div class="mt-auto border-top p-3">
                    <a href="<?php echo site_url('bootstrap_examples'); ?>" class="btn btn-outline-secondary w-100<?php echo $strActiveNav === 'bootstrap_examples' ? ' active' : ''; ?>">
                        Bootstrap Examples
                    </a>
                </div>
            </div>
        </nav>
        <main class="col-lg-10 ms-sm-auto px-4 py-4 app-main">
