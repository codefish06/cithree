<!-- Dependencies -->
<script type="text/javascript" src="<?php echo base_url('application/assets/vendor/jquery/jquery.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('application/assets/js/bootstrap.bundle.min.js'); ?>"></script>
<script type="text/javascript" src="/assets/summernote/0.9.1/summernote-lite.min.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('application/assets/css/bootstrap.min.css'); ?>"/>
<link type="text/css" rel="stylesheet" href="/assets/summernote/0.9.1/summernote-lite.min.css"/>
<link type="text/css" rel="stylesheet" href="/assets/font_awesome/css/font-awesome.min.css"/>

<?php
$strFileVersion = md5(rand());
$arrStatePayload = $content_block_state_payload ?? null;
$strSuccessMessage = $this->session->flashdata("success");
$arrEditorRenderSlots = is_array($editor_render_slots ?? null)
    ? $editor_render_slots
    : [];
?>
<!-- Custom CSS -->
<link type="text/css" rel="stylesheet" href="<?php echo $path_editor_css; ?>?filever=<?php echo $strFileVersion; ?>"/>
<link type="text/css" rel="stylesheet" href="<?php echo $path_bootstrap_icon_css; ?>?filever=<?php echo $strFileVersion; ?>"/>
<link rel="stylesheet" href="<?php echo $store_stylesheet; ?>" id="content_block_store_stylesheet"/>
<!-- End Custom CSS -->

<div id="content_block_editor_loading_screen" aria-live="polite" aria-label="Content Block Editor loading">
    <div class="content-block-editor-loading-shell">
        <i class="bi bi-circle-square" aria-hidden="true"></i>
        <span>Content Block Editor loading...</span>
    </div>
    <div class="content-block-editor-loading-spinner" aria-hidden="true">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
</div>

<div class="container-fluid content-block-page-container editor-app content-block-editor-page">
    <span id="php_info" data-size-limit="<?php echo ini_get(
        "post_max_size",
    ); ?>" data-amount-limit="<?php echo ini_get(
    "max_file_uploads",
); ?>" class="d-none"></span>
    <span id="editor_permissions" data-can-use-developer-tools="<?php echo !empty(
        $is_developer_user
    )
        ? "1"
        : "0"; ?>" class="d-none"></span>
    <?php echo form_open_multipart($domain_extn . "/cms/Content_block/save", [
        "autocomplete" => "off",
        "class" => "form form-cms striped-rows",
        "id" => "editor_form",
    ]); ?>

    <div class="row pt-3 pb-2 border-bottom content-block-editor-navbar editor-topbar">
        <div class="col-12">
            <div class="row align-items-start align-items-lg-center g-2 pb-2" id="page_header">
                <div class="col-12 col-lg-4 d-flex align-items-center justify-content-start gap-2 mb-2 mb-lg-0 order-1"
                     id="page_header_title_wrap">
                    <a id="page_header_cancel" class="btn btn-secondary btn-sm"
                       href="/cms/Content_block/view" title="Back to List View">
                        <i class="bi bi-arrow-up-left-square-fill" aria-hidden="true"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-dark icon-control" id="toggle_blocks_btn"
                            title="Hide blocks sidebar" aria-label="Hide blocks sidebar">
                        <i class="bi bi-layout-sidebar"></i>
                    </button>
                    <h2 class="h5 fw-semibold mb-0" id="page_header_title">
                        <i class="bi bi-circle-square" aria-hidden="true"></i>
                        <span class="page_header_title-text"><?php echo $page_title; ?></span>
                    </h2>
                </div>

                <div class="col-12 col-lg-3 mb-2 mb-lg-0 d-flex justify-content-start justify-content-lg-center order-2 page_header-name-slot">
                    <div class="input-group content-block-name-group">
                        <input
                                type="text"
                                class="form-control form-control-sm fw-semibold text-center"
                                id="title" name="title"
                                maxlength="50"
                                placeholder="Please add a Content Block Name"
                                value="<?php echo $content_block_name ?? ""; ?>"
                        />
                    </div>
                </div>

                <div class="col-12 col-lg-5 d-flex flex-wrap gap-2 justify-content-start justify-content-lg-end order-3">
                    <button
                            type="button"
                            class="btn btn-sm btn-outline-dark icon-control active"
                            id="snap_guides_toggle_btn"
                            data-bs-toggle="button"
                            autocomplete="off"
                            aria-pressed="true"
                            aria-label="Toggle snap to guides"
                            title="Snap to guides on. Hold Alt while dragging to temporarily disable."
                    >
                        <i class="bi bi-magnet-fill"></i>
                    </button>
                    <?php
                    $arrEditorBreakpoints = is_array(
                        ($arrContentBlockSchema ?? [])["breakpoints"] ?? null,
                    )
                        ? $arrContentBlockSchema["breakpoints"]
                        : [];
                    if (empty($arrEditorBreakpoints)) {
                        $arrEditorBreakpoints = [
                            [
                                "handle" => "desktop",
                                "label" => "Desktop",
                                "previewWidth" => CONTENT_BLOCK_CANVAS_DESKTOP_CONTAINER_WIDTH,
                                "iconClass" => "bi-display",
                            ],
                            [
                                "handle" => "tablet",
                                "label" => "Tablet",
                                "previewWidth" => 834,
                                "iconClass" => "bi-tablet",
                            ],
                            [
                                "handle" => "mobile",
                                "label" => "Mobile",
                                "previewWidth" => 390,
                                "iconClass" => "bi-phone",
                            ],
                        ];
                    }
                    $arrEditorBpIconFallbacks = [
                        "desktop" => "bi-display",
                        "tablet" => "bi-tablet",
                        "mobile" => "bi-phone",
                    ];
                    $strEditorBaseBreakpoint = "desktop";
                    $bEditorHasDesktopBreakpoint = false;
                    $iEditorBasePreviewWidth = 0;
                    foreach ($arrEditorBreakpoints as $arrEditorBaseBp) {
                        $strEditorBaseCandidate =
                            (string) ($arrEditorBaseBp["handle"] ?? "");
                        $iEditorPreviewWidth =
                            (int) ($arrEditorBaseBp["previewWidth"] ?? 0);
                        if ($strEditorBaseCandidate === "desktop") {
                            $strEditorBaseBreakpoint = "desktop";
                            $bEditorHasDesktopBreakpoint = true;
                            break;
                        }
                        if (
                            ($arrEditorBaseBp["maxWidth"] ?? null) === null &&
                            $iEditorPreviewWidth > $iEditorBasePreviewWidth
                        ) {
                            $strEditorBaseBreakpoint = $strEditorBaseCandidate;
                            $iEditorBasePreviewWidth = $iEditorPreviewWidth;
                        }
                    }
                    if (
                        !$bEditorHasDesktopBreakpoint &&
                        $strEditorBaseBreakpoint === "" &&
                        !empty($arrEditorBreakpoints[0]["handle"])
                    ) {
                        $strEditorBaseBreakpoint =
                            (string) $arrEditorBreakpoints[0]["handle"];
                    }
                    ?>
                    <div class="btn-group btn-group-sm viewport-presets" role="group" aria-label="Preview width">
                        <?php foreach (
                            $arrEditorBreakpoints
                            as $arrEditorBp
                        ) { ?>
                            <?php
                            $strEBpHandle = htmlspecialchars(
                                (string) ($arrEditorBp["handle"] ?? ""),
                                ENT_QUOTES,
                                "UTF-8",
                            );
                            $strEBpLabel = htmlspecialchars(
                                (string) ($arrEditorBp["label"] ??
                                    $strEBpHandle),
                                ENT_QUOTES,
                                "UTF-8",
                            );
                            $strEBpRawIcon = !empty($arrEditorBp["iconClass"])
                                ? $arrEditorBp["iconClass"]
                                : $arrEditorBpIconFallbacks[
                                        $arrEditorBp["handle"]
                                    ] ?? "bi-display";
                            $strEBpIcon = htmlspecialchars(
                                $strEBpRawIcon,
                                ENT_QUOTES,
                                "UTF-8",
                            );
                            $bEBpActive =
                                $strEBpHandle === $strEditorBaseBreakpoint;
                            ?>
                            <button
                                    type="button"
                                    class="btn btn-outline-secondary viewport-preset-btn<?php echo $bEBpActive
                                        ? " active"
                                        : ""; ?>"
                                    data-viewport-preset="<?php echo $strEBpHandle; ?>"
                                    data-preview-width="<?php echo (int) ($arrEditorBp[
                                        "previewWidth"
                                    ] ?? 0); ?>"
                                    aria-pressed="<?php echo $bEBpActive
                                        ? "true"
                                        : "false"; ?>"
                                    title="<?php echo $strEBpLabel; ?> preview"
                            >
                                <i class="bi <?php echo $strEBpIcon; ?>"></i>
                            </button>
                        <?php } ?>
                    </div>
                    <button type="button" class="btn btn-sm btn-dark icon-control" id="toggle_sidebar_btn"
                            title="Hide sidebar" aria-label="Hide sidebar">
                        <i class="bi bi-layout-sidebar-reverse"></i>
                    </button>

                    <input type="hidden" id="save_type" name="save_type" value="save"/>
                    <button id="save_exit" type="submit"
                            class="btn btn-primary btn-sm d-flex align-items-center btn-save btn-save-exit"
                            data-save-type="save_exit"
                            data-bs-placement="left"
                            title="Save & Exit"
                            aria-label="Save and exit">
                        <i class="bi bi-check2-square btn-save-icon" aria-hidden="true"></i>
                    </button>
                    <button id="save" type="submit"
                            class="btn btn-success btn-sm d-flex align-items-center btn-save btn-save-save"
                            data-save-type="save"
                            name="save"
                            data-bs-placement="left"
                            title="Save"
                            aria-label="Save">
                        <i class="bi bi-floppy btn-save-icon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="toast-container editor-toast-stack">
                <div
                    id="editor_success_toast"
                    class="toast editor-toast text-bg-success border-0"
                    role="status"
                    aria-live="polite"
                    aria-atomic="true"
                    data-bs-autohide="true"
                    data-bs-delay="3200"
                >
                    <div class="d-flex align-items-center">
                        <div class="toast-body"><?php echo $strSuccessMessage
                            ? htmlspecialchars(
                                $strSuccessMessage,
                                ENT_QUOTES,
                                "UTF-8",
                            )
                            : ""; ?></div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>

            <input type="hidden" id="domain_extn" value="<?php echo $domain_extn; ?>">
            <input type="hidden" id="content_block_server_saved_at" value="<?php echo intval(
                $content_block_server_saved_at ?? 0,
            ); ?>">
            <input type="hidden" id="content_block_store_stylesheet_href" value="<?php echo htmlspecialchars(
                $store_stylesheet ?? "",
                ENT_QUOTES,
                "UTF-8",
            ); ?>">
            <input type="hidden" id="image_placeholder_path" value="<?php echo htmlspecialchars(
                $path_image_placeholder ?? "",
                ENT_QUOTES,
                "UTF-8",
            ); ?>">

            <script id="content_block_state_payload"
                    type="application/json"><?php echo json_encode(
                        $arrStatePayload,
                        JSON_HEX_TAG |
                            JSON_HEX_AMP |
                            JSON_HEX_APOS |
                            JSON_HEX_QUOT,
                    ); ?></script>
            <script id="content_block_schema_payload"
                    type="application/json"><?php echo json_encode(
                        $arrContentBlockSchema ?? [],
                        JSON_HEX_TAG |
                            JSON_HEX_AMP |
                            JSON_HEX_APOS |
                            JSON_HEX_QUOT,
                    ); ?></script>

            <div class="content-block-editor-shell editor-body mt-2">
                <div class="app-shell-wrap">
                    <div class="app-shell" id="app_shell">
                        <aside class="block-sidebar editor-rail editor-rail-left" id="block_sidebar">
                        <div class="block-sidebar-tabs rail-tabs nav nav-tabs" id="block_sidebar_tabs" role="tablist">
                            <button class="tab-btn btn btn-sm btn-outline-secondary active" id="blocks_tab"
                                    data-bs-toggle="tab" data-bs-target="#blocks_panel" type="button" role="tab"
                                    aria-controls="blocks_panel" aria-selected="true" aria-label="Blocks">
                                Blocks
                            </button>
                            <button class="tab-btn btn btn-sm btn-outline-secondary" id="layers_tab"
                                    data-bs-toggle="tab" data-bs-target="#layers_panel" type="button" role="tab"
                                    aria-controls="layers_panel" aria-selected="false" aria-label="Layers">
                                Layers
                            </button>
                            <button class="tab-btn tab-btn-developer btn btn-sm btn-outline-secondary settings-hidden" id="developer_tools_tab"
                                    data-bs-toggle="tab" data-bs-target="#developer_tools_panel" type="button" role="tab"
                                    aria-controls="developer_tools_panel" aria-selected="false" aria-label="Developer tools">
                                <i class="bi bi-terminal"></i>
                                <span class="visually-hidden">Developer tools</span>
                            </button>
                        </div>

                        <div class="block-sidebar-panels rail-scroll tab-content">

                            <section class="block-tab-panel tab-pane fade show active" id="blocks_panel" role="tabpanel"
                                     aria-labelledby="blocks_tab">
                                <div class="block-search-wrap">
                                    <i class="bi bi-search block-search-icon"></i>
                                    <input class="form-control form-control-sm block-search" type="search"
                                           placeholder="Search blocks" aria-label="Search blocks">
                                </div>
                                <div id="block_palette_mount"></div>
                            </section>

                            <section class="block-tab-panel tab-pane fade" id="layers_panel" role="tabpanel"
                                     aria-labelledby="layers_tab">
                                <div id="sidebar_columns"></div>
                            </section>

                            <section class="block-tab-panel tab-pane fade settings-hidden" id="developer_tools_panel" role="tabpanel"
                                     aria-labelledby="developer_tools_tab" aria-hidden="true">
                                <div class="developer_tools_panel" id="developer_tools">
                                    <div class="developer-tools-head">
                                        <span class="developer-tools-title">Developer Tools</span>
                                        <span class="developer-tools-shortcut">Press X to toggle</span>
                                    </div>
                                    <div class="developer-tool" data-developer-tool="coords">
                                        <div class="developer-tool-title">Coordinates</div>
                                        <div class="coords-readout" id="coords" aria-live="polite">Select a freeform item to see where it sits on the canvas.</div>
                                    </div>
                                    <div class="developer-tool" data-developer-tool="metrics">
                                        <div class="developer-tool-title">Selection Metrics</div>
                                        <div class="coords-readout" id="selection_metrics" aria-live="polite">Select a column or element to inspect width, height, and min/max constraints.</div>
                                    </div>
                                    <div class="developer-tool" data-developer-tool="state-tree">
                                        <div class="developer-tool-title">Selection Settings</div>
                                        <div class="developer-tool-meta" id="developer_state_meta">No selection</div>
                                        <div class="developer-tool-actions">
                                            <button type="button" class="developer-tool-iconbtn" id="developer_state_inspect_btn" disabled title="Open JSON panel" aria-label="Open JSON panel">
                                                <i class="bi bi-braces" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="developer-tool-iconbtn" id="developer_state_export_btn" disabled title="Export JSON" aria-label="Export JSON">
                                                <i class="bi bi-download" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <div class="developer-tool-summary" id="developer_state_tree" aria-live="polite">
                                            Inspect the current selection JSON in the bottom panel.
                                        </div>
                                    </div>
                                    <div class="developer-tool" data-developer-tool="code">
                                        <div class="developer-tool-title">Content Block</div>
                                        <div class="developer-tool-meta">HTML and CSS export</div>
                                        <div class="developer-tool-actions">
                                            <button type="button" class="developer-tool-iconbtn" id="developer_code_copy_html_btn" title="Copy HTML" aria-label="Copy HTML">
                                                <i class="bi bi-clipboard" aria-hidden="true"></i>
                                            </button>
                                            <button type="button" class="developer-tool-iconbtn developer-tool-iconbtn-primary" id="developer_code_toggle_btn" title="Open code panel" aria-label="Open code panel">
                                                <i class="bi bi-code-slash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                        <div class="developer-tool-summary">
                                            HTML and CSS open in the same bottom panel.
                                        </div>
                                    </div>
                                    <div class="developer-tool" data-developer-tool="save-history">
                                        <div class="developer-tool-title">Save History</div>
                                        <div class="developer-tool-meta" id="developer_save_history_meta">No save activity recorded yet.</div>
                                        <div class="developer-tool-summary developer-save-history" id="developer_save_history" aria-live="polite">
                                            Save-state transitions will appear here once the editor changes.
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </aside>

                    <div class="layout-viewport-wrap canvas-shell">
                        <div class="layout-viewport canvas-stage-wrap" id="layout_viewport">
                            <div class="layout-viewport-status" aria-live="polite" aria-atomic="true">
                                <div id="content_block_autosave_restore_banner"
                                     class="content-block-autosave-restore"
                                     hidden>
                                    <span class="content-block-autosave-restore-message">
                                        <i class="bi bi-clock-history" aria-hidden="true"></i>
                                        <span>Unsaved local changes from <strong class="content-block-autosave-restore-time"></strong> were found.</span>
                                    </span>
                                    <span class="content-block-autosave-restore-actions">
                                        <button type="button" class="btn btn-sm btn-warning js-autosave-restore">Restore</button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary js-autosave-discard">Discard</button>
                                    </span>
                                </div>
                                <span id="content_block_autosave_indicator"
                                      class="content_block_autosave_indicator"><?php $this->load->view(
                                          "cms/content_block/controls/_autosave_indicator",
                                      ); ?></span>
                            </div>
                            <button type="button" class="viewport-grip viewport-grip-left" data-resize-side="left"
                                    aria-label="Resize preview from left"></button>
                            <main class="layout canvas-stage" id="layout"></main>
                            <button type="button" class="viewport-grip viewport-grip-right" data-resize-side="right"
                                    aria-label="Resize preview from right"></button>
                            <button type="button" class="viewport-grip viewport-grip-bottom" data-resize-axis="height"
                                    aria-label="Resize preview height"></button>
                            <div class="viewport-resize-readout" id="viewport_resize_readout" aria-live="polite"></div>
                        </div>
                    </div>

                    <aside class="sidebar editor-rail editor-rail-right" id="sidebar">
                        <div class="sidebar-tabs rail-tabs nav nav-tabs" id="sidebar_tabs" role="tablist">
                            <button class="tab-btn tab-btn-settings btn btn-sm btn-outline-secondary active"
                                    id="block_styles_tab" data-bs-toggle="tab" data-bs-target="#block_styles_panel"
                                    type="button" role="tab" aria-controls="block_styles_panel" aria-selected="true"
                                    aria-label="Styles">
                                <span>Styles</span>
                            </button>
                            <button class="tab-btn tab-btn-settings btn btn-sm btn-outline-secondary"
                                    id="block_properties_tab" data-bs-toggle="tab" data-bs-target="#block_properties_panel"
                                    type="button" role="tab" aria-controls="block_properties_panel" aria-selected="false"
                                    aria-label="Properties">
                                <span>Properties</span>
                            </button>
                        </div>

                        <div class="settings-wrap rail-scroll" id="block_settings_wrap">
                            <div class="settings-empty" id="settings_empty">Select a block or column to edit settings.
                            </div>

                            <div class="settings-form settings-hidden" id="block_settings_form">
                                <div class="settings-context">
                                    <span class="settings-context-chip settings-context-kicker visually-hidden">Now Editing</span>
                                    <div class="settings-context-selection">
                                        <span class="settings-context-icon" id="settings_context_icon" aria-hidden="true">
                                            <i class="bi bi-square"></i>
                                        </span>
                                        <div class="settings-context-copy">
                                            <div class="settings-context-title" id="settings_context_title">Selection</div>
                                        </div>
                                    </div>
                                    <span class="settings-context-chip settings-context-breakpoint visually-hidden" id="settings_context_breakpoint">Desktop</span>
                                </div>
                                <input type="hidden" id="setting_type" value="">

                                <div class="sidebar-panels tab-content">
                                    <section class="tab-panel tab-pane fade" id="block_properties_panel" role="tabpanel"
                                             aria-labelledby="block_properties_tab">
                                        <div class="accordion settings-accordion" id="block_properties_accordion">
                                            <div class="accordion-item" data-settings-section="properties-general">
                                                <h2 class="accordion-header" id="heading_settings_general">
                                                    <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_general" aria-expanded="true"
                                                            aria-controls="collapse_settings_general">
                                                        <span class="settings-section-title">General</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="General help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_general" class="accordion-collapse collapse show"
                                                     aria-labelledby="heading_settings_general" data-bs-parent="#block_properties_accordion">
                                                    <div class="accordion-body">
                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "properties_general"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") !==
                                                                "objectFit"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "layoutFlow"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "layoutPreset"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "rowWidths"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "rowBehavior"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "rowMinColWidth"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "rowColumns"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                in_array(
                                                                    $arrControl[
                                                                        "handle"
                                                                    ] ?? "",
                                                                    [
                                                                        "rowMatchHeights",
                                                                        "rowHostBehavior",
                                                                        "rowHostMaxWidth",
                                                                        "rowHostColumns",
                                                                        "rowHostQueryWidths",
                                                                    ],
                                                                    true,
                                                                )
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "containerMode"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "absoluteCanvasHeight"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item settings-hidden" id="settings_button_properties_group" data-settings-section="properties-button">
                                                <h2 class="accordion-header" id="heading_settings_button_properties">
                                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_button_properties" aria-expanded="false"
                                                            aria-controls="collapse_settings_button_properties">
                                                        <span class="settings-section-title">Button</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Button help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_button_properties" class="accordion-collapse collapse"
                                                     aria-labelledby="heading_settings_button_properties" data-bs-parent="#block_properties_accordion">
                                                    <div class="accordion-body">
                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "properties_button"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="settings-panel-empty settings-hidden" id="settings_properties_empty">
                                            No properties for this selection. Use <strong>Styles</strong> to edit layout and appearance.
                                        </div>
                                    </section>

                                    <section class="tab-panel tab-pane fade show active" id="block_styles_panel" role="tabpanel"
                                             aria-labelledby="block_styles_tab">
                                        <div class="accordion settings-accordion" id="block_styles_accordion">
                                            <div class="accordion-item settings-group settings-group-typography settings-hidden" data-settings-section="styles-typography">
                                                <h2 class="accordion-header" id="heading_settings_typography">
                                                    <button class="accordion-button py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_typography" aria-expanded="true"
                                                            aria-controls="collapse_settings_typography">
                                                        <span class="settings-section-title">Typography</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Typography help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_typography" class="accordion-collapse collapse show"
                                                     aria-labelledby="heading_settings_typography" data-bs-parent="#block_styles_accordion">
                                                    <div class="accordion-body">
                                                        <?php $this->load->view(
                                                            "cms/content_block/controls/_style_section_tools",
                                                            [
                                                                "style_section" =>
                                                                    "typography",
                                                                "style_section_label" =>
                                                                    "Typography",
                                                            ],
                                                        ); ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_compound"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>


                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_color"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "headingLevel"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "textAlign"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "textTransform"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "textDecoration"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "fontStyle"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "typography_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                    "wordBreak" ||
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                    "textDirection"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item settings-group settings-group-appearance" data-settings-section="styles-appearance">
                                                <h2 class="accordion-header" id="heading_settings_appearance">
                                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_appearance" aria-expanded="false"
                                                            aria-controls="collapse_settings_appearance">
                                                        <span class="settings-section-title">Appearance</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Appearance help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_appearance" class="accordion-collapse collapse"
                                                     aria-labelledby="heading_settings_appearance" data-bs-parent="#block_styles_accordion">
                                                    <div class="accordion-body">
                                                        <?php $this->load->view(
                                                            "cms/content_block/controls/_style_section_tools",
                                                            [
                                                                "style_section" =>
                                                                    "appearance",
                                                                "style_section_label" =>
                                                                    "Appearance",
                                                            ],
                                                        ); ?>
                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "appearance_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item settings-group settings-group-fill" data-settings-section="styles-fill">
                                                <h2 class="accordion-header" id="heading_settings_fill">
                                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_fill" aria-expanded="false"
                                                            aria-controls="collapse_settings_fill">
                                                        <span class="settings-section-title">Fill</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Fill help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_fill" class="accordion-collapse collapse"
                                                     aria-labelledby="heading_settings_fill" data-bs-parent="#block_styles_accordion">
                                                    <div class="accordion-body">
                                                        <?php $this->load->view(
                                                            "cms/content_block/controls/_style_section_tools",
                                                            [
                                                                "style_section" =>
                                                                    "fill",
                                                                "style_section_label" =>
                                                                    "Fill",
                                                            ],
                                                        ); ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "fill_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item settings-group settings-group-spacing" data-settings-section="styles-spacing">
                                                <h2 class="accordion-header" id="heading_settings_spacing">
                                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_spacing" aria-expanded="false"
                                                            aria-controls="collapse_settings_spacing">
                                                        <span class="settings-section-title">Spacing</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Spacing help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_spacing" class="accordion-collapse collapse"
                                                     aria-labelledby="heading_settings_spacing" data-bs-parent="#block_styles_accordion">
                                                    <div class="accordion-body">
                                                        <?php $this->load->view(
                                                            "cms/content_block/controls/_style_section_tools",
                                                            [
                                                                "style_section" =>
                                                                    "spacing",
                                                                "style_section_label" =>
                                                                    "Spacing",
                                                            ],
                                                        ); ?>
                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "spacing_compound"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item settings-group settings-group-border" data-settings-section="styles-border">
                                                <h2 class="accordion-header" id="heading_settings_border">
                                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_border" aria-expanded="false"
                                                            aria-controls="collapse_settings_border">
                                                        <span class="settings-section-title">Border</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Border help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_border" class="accordion-collapse collapse"
                                                     aria-labelledby="heading_settings_border" data-bs-parent="#block_styles_accordion">
                                                    <div class="accordion-body">
                                                        <?php $this->load->view(
                                                            "cms/content_block/controls/_style_section_tools",
                                                            [
                                                                "style_section" =>
                                                                    "border",
                                                                "style_section_label" =>
                                                                    "Border",
                                                            ],
                                                        ); ?>
                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "border_compound"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_schema_control_renderer",
                                                                [
                                                                    "control" => $arrControl,
                                                                ],
                                                            ); ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item settings-group settings-group-effects" data-settings-section="styles-effects">
                                                <h2 class="accordion-header" id="heading_settings_effects">
                                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_effects" aria-expanded="false"
                                                            aria-controls="collapse_settings_effects">
                                                        <span class="settings-section-title">Effects</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Effects help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_effects" class="accordion-collapse collapse"
                                                     aria-labelledby="heading_settings_effects" data-bs-parent="#block_styles_accordion">
                                                    <div class="accordion-body">
                                                        <?php $this->load->view(
                                                            "cms/content_block/controls/_style_section_tools",
                                                            [
                                                                "style_section" =>
                                                                    "effects",
                                                                "style_section_label" =>
                                                                    "Effects",
                                                            ],
                                                        ); ?>
                                                        <div class="effects-state-switch">
                                                            <?php $this->load->view(
                                                                "cms/content_block/controls/_segmented_option_group",
                                                                [
                                                                    "input_id" =>
                                                                        "effects_state_switch",
                                                                    "radio_name" =>
                                                                        "effects_state_switch_radio",
                                                                    "value" =>
                                                                        "normal",
                                                                    "group_aria_label" =>
                                                                        "Effects interaction state",
                                                                    "group_class" =>
                                                                        "pb-segmented",
                                                                    "options" => [
                                                                        [
                                                                            "value" =>
                                                                                "normal",
                                                                            "title" =>
                                                                                "Normal",
                                                                            "ariaLabel" =>
                                                                                "Normal",
                                                                            "id" =>
                                                                                "effects_state_switch_normal",
                                                                            "buttonClass" =>
                                                                                "pb-icon-radio",
                                                                            "buttonHtml" =>
                                                                                '<span class="pb-icon-btn"><span class="pb-inline-label">Normal</span></span>',
                                                                        ],
                                                                        [
                                                                            "value" =>
                                                                                "hover",
                                                                            "title" =>
                                                                                "Hover",
                                                                            "ariaLabel" =>
                                                                                "Hover",
                                                                            "id" =>
                                                                                "effects_state_switch_hover",
                                                                            "buttonClass" =>
                                                                                "pb-icon-radio",
                                                                            "buttonHtml" =>
                                                                                '<span class="pb-icon-btn"><span class="pb-inline-label">Hover</span></span>',
                                                                        ],
                                                                        [
                                                                            "value" =>
                                                                                "active",
                                                                            "title" =>
                                                                                "Active",
                                                                            "ariaLabel" =>
                                                                                "Active",
                                                                            "id" =>
                                                                                "effects_state_switch_active",
                                                                            "buttonClass" =>
                                                                                "pb-icon-radio",
                                                                            "buttonHtml" =>
                                                                                '<span class="pb-icon-btn"><span class="pb-inline-label">Active</span></span>',
                                                                        ],
                                                                    ],
                                                                ],
                                                            ); ?>
                                                            <select id="effects_state_switch" class="visually-hidden" aria-hidden="true" tabindex="-1">
                                                                <option value="normal" selected>Normal</option>
                                                                <option value="hover">Hover</option>
                                                                <option value="active">Active</option>
                                                            </select>
                                                            <small class="text-muted effects-state-note" id="effects_state_hint">Hover and active inherit from normal until you override a field.</small>
                                                        </div>
                                                        <div class="effects-quick-grid">
                                                            <?php foreach (
                                                                $arrEditorRenderSlots[
                                                                    "effects_quick"
                                                                ] ?? []
                                                                as $arrControl
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        </div>
                                                        <hr class="effects-divider">
                                                        <div class="effects-builder-layout">
                                                            <div class="effects-collections" role="list" aria-label="Advanced effects">
                                                                <?php foreach (
                                                                    $arrEditorRenderSlots[
                                                                        "effects_collections"
                                                                    ] ?? []
                                                                    as $arrCollection
                                                                ) { ?>
                                                                    <?php $this->load->view(
                                                                        "cms/content_block/controls/_control_effect_collection_builder",
                                                                        [
                                                                            "collection" => $arrCollection,
                                                                        ],
                                                                    ); ?>
                                                                <?php } ?>
                                                            </div>
                                                            <aside class="effects-helper settings-hidden" id="effects_helper_panel" aria-live="polite">
                                                                <div class="effects-helper-head">
                                                                    <div>
                                                                        <p class="effects-helper-kicker">Effect Builder</p>
                                                                        <h3 class="effects-helper-title" id="effects_helper_title">Add effect</h3>
                                                                    </div>
                                                                    <button type="button" class="btn btn-sm effects-helper-close" id="effects_helper_close_btn" aria-label="Close effect builder">
                                                                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                                <p class="effects-helper-summary text-muted" id="effects_helper_summary">Choose an effect on the left to build a value without writing CSS manually.</p>

                                                                <div class="effects-helper-form settings-hidden" id="effects_helper_box_shadow">
                                                                    <div class="setting-row mb-0 effects-helper-grid-span">
                                                                        <label class="form-label mb-1" for="effects_box_shadow_mode">Type</label>
                                                                        <div class="btn-group btn-group-sm settings-radio-prototype" role="group" aria-label="Box shadow type" data-radio-select="effects_box_shadow_mode">
                                                                            <input type="radio" class="btn-check" name="effects_box_shadow_modeRadio" id="effects_box_shadow_mode_outset" value="outset" autocomplete="off">
                                                                            <label class="btn btn-outline-primary" for="effects_box_shadow_mode_outset">Outside</label>
                                                                            <input type="radio" class="btn-check" name="effects_box_shadow_modeRadio" id="effects_box_shadow_mode_inset" value="inset" autocomplete="off">
                                                                            <label class="btn btn-outline-primary" for="effects_box_shadow_mode_inset">Inside</label>
                                                                        </div>
                                                                        <select id="effects_box_shadow_mode" class="form-select form-select-sm settings-bridge-control">
                                                                            <option value="outset">Outside</option>
                                                                            <option value="inset">Inside</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="effects-helper-grid effects-helper-grid-double">
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_box_shadow_x">X Offset</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_box_shadow_x" class="form-control" step="1" value="0">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_box_shadow_y">Y Offset</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_box_shadow_y" class="form-control" step="1" value="6">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_box_shadow_blur">Blur</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_box_shadow_blur" class="form-control" min="0" step="1" value="20">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_box_shadow_spread">Spread</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_box_shadow_spread" class="form-control" step="1" value="0">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_box_shadow_color">Color</label>
                                                                            <input type="color" id="effects_box_shadow_color" class="form-control form-control-sm form-control-color effects-helper-color-input" value="#0f172a">
                                                                        </div>
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_box_shadow_opacity">Opacity</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_box_shadow_opacity" class="form-control" min="0" max="100" step="1" value="14">
                                                                                <span class="input-group-text">%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="effects-helper-form settings-hidden" id="effects_helper_text_shadow">
                                                                    <div class="effects-helper-grid effects-helper-grid-double">
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_text_shadow_x">X Offset</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_text_shadow_x" class="form-control" step="1" value="0">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_text_shadow_y">Y Offset</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_text_shadow_y" class="form-control" step="1" value="1">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_text_shadow_blur">Blur</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_text_shadow_blur" class="form-control" min="0" step="1" value="2">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_text_shadow_color">Color</label>
                                                                            <input type="color" id="effects_text_shadow_color" class="form-control form-control-sm form-control-color effects-helper-color-input" value="#0f172a">
                                                                        </div>
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_text_shadow_opacity">Opacity</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_text_shadow_opacity" class="form-control" min="0" max="100" step="1" value="20">
                                                                                <span class="input-group-text">%</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="effects-helper-form settings-hidden" id="effects_helper_transition">
                                                                    <div class="effects-helper-grid effects-helper-grid-double">
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_transition_property">Property</label>
                                                                            <select id="effects_transition_property" class="form-select form-select-sm effects-helper-select">
                                                                                <option value="all">All</option>
                                                                                <option value="opacity">Opacity</option>
                                                                                <option value="transform">Transform</option>
                                                                                <option value="box-shadow">Box shadow</option>
                                                                                <option value="text-shadow">Text shadow</option>
                                                                                <option value="background-color">Background color</option>
                                                                                <option value="color">Text color</option>
                                                                                <option value="filter">Filter</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_transition_easing">Easing</label>
                                                                            <select id="effects_transition_easing" class="form-select form-select-sm effects-helper-select">
                                                                                <option value="ease">Ease</option>
                                                                                <option value="linear">Linear</option>
                                                                                <option value="ease-in">Ease in</option>
                                                                                <option value="ease-out">Ease out</option>
                                                                                <option value="ease-in-out">Ease in out</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_transition_duration">Duration (s)</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_transition_duration" class="form-control" min="0" step="0.05" value="0.18">
                                                                                <span class="input-group-text">s</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="setting-row mb-0">
                                                                            <label class="form-label mb-1" for="effects_transition_delay">Delay (s)</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_transition_delay" class="form-control" min="0" step="0.05" value="0">
                                                                                <span class="input-group-text">s</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="effects-helper-form settings-hidden" id="effects_helper_transform">
                                                                    <div class="effects-helper-grid effects-helper-grid-double">
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_transform_type">Type</label>
                                                                            <select id="effects_transform_type" class="form-select form-select-sm effects-helper-select">
                                                                                <option value="translateX">Move X</option>
                                                                                <option value="translateY">Move Y</option>
                                                                                <option value="scale">Scale</option>
                                                                                <option value="rotate">Rotate</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="setting-row mb-0 effects-helper-grid-span">
                                                                            <label class="form-label mb-1" for="effects_transform_value">Value</label>
                                                                            <div class="input-group input-group-sm">
                                                                                <input type="number" id="effects_transform_value" class="form-control" step="0.1" value="-2">
                                                                                <span class="input-group-text" id="effects_transform_unit_label">px</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="effects-helper-actions">
                                                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="effects_helper_cancel_btn">Cancel</button>
                                                                    <button type="button" class="btn btn-sm btn-primary" id="effects_helper_save_btn">Add Effect</button>
                                                                </div>
                                                            </aside>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="accordion-item settings-group settings-group-layout" data-settings-section="styles-layout">
                                                <h2 class="accordion-header" id="heading_settings_layout">
                                                    <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse_settings_layout" aria-expanded="false"
                                                            aria-controls="collapse_settings_layout">
                                                        <span class="settings-section-title">Layout</span>
                                                        <span class="bi bi-info-circle settings-section-info settings-hidden" data-settings-section-info role="button" tabindex="0" aria-label="Layout help"></span>
                                                    </button>
                                                </h2>
                                                <div id="collapse_settings_layout" class="accordion-collapse collapse"
                                                     aria-labelledby="heading_settings_layout" data-bs-parent="#block_styles_accordion">
                                                    <div class="accordion-body">
                                                        <?php $this->load->view(
                                                            "cms/content_block/controls/_style_section_tools",
                                                            [
                                                                "style_section" =>
                                                                    "layout",
                                                                "style_section_label" =>
                                                                    "Layout and position",
                                                            ],
                                                        ); ?>
                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                in_array(
                                                                    $arrControl[
                                                                        "handle"
                                                                    ] ?? "",
                                                                    [
                                                                        "maxWidth",
                                                                        "customAccentWidth",
                                                                    ],
                                                                    true,
                                                                )
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "properties_general"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "objectFit"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "buttonSizeMode"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <!-- Match layout sizing controls to the compact slider pattern used elsewhere. -->
                                                        <div class="setting-row-grid" data-layout-section="size">
                                                            <div class="compact-dimension-group">
                                                                <div class="compact-dimension-head">
                                                                    <div>
                                                                        <p class="compact-dimension-title">Size <span class="bi bi-info-circle text-muted setting-label-info" role="button" tabindex="0" data-help-title="Size Tips" data-help-content="Drag the handle or type an exact value." aria-label="Size help"></span></p>
                                                                    </div>
                                                                </div>
                                                                <div class="compact-dimension-stack compact-dimension-stack-paired compact-dimension-stack-size" id="setting_size_controls_row">
                                                                    <div class="compact-dimension-row compact-dimension-row-prototype">
                                                                        <div class="compact-dimension-label-row">
                                                                            <label class="compact-dimension-label" for="setting_width">Width</label>
                                                                            <button type="button" class="btn-clear-setting compact-reset-btn settings-hidden" data-reset-target="setting_width" data-reset-value="" title="Reset width to auto" aria-label="Reset width to auto"><i class="bi bi-x" aria-hidden="true"></i></button>
                                                                        </div>
                                                                        <input type="range" id="setting_width_slider" class="form-range compact-dimension-range" min="0" max="1200" step="1" value="0" data-layout-target="setting_width" data-layout-control="slider" data-layout-allow-empty="true">
                                                                        <div class="compact-dimension-row-body">
                                                                            <div class="input-group input-group-sm compact-dimension-scrub-wrap">
                                                                                <input type="number" id="setting_width"
                                                                                       class="form-control form-control-sm compact-dimension-number" min="0" max="1200"
                                                                                       step="1" placeholder="Auto" data-layout-target="setting_width" data-layout-control="number" data-layout-allow-empty="true">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="compact-dimension-row compact-dimension-row-prototype">
                                                                        <div class="compact-dimension-label-row">
                                                                            <label class="compact-dimension-label" for="setting_height">Height</label>
                                                                            <button type="button" class="btn-clear-setting compact-reset-btn settings-hidden" data-reset-target="setting_height" data-reset-value="" title="Reset height to auto" aria-label="Reset height to auto"><i class="bi bi-x" aria-hidden="true"></i></button>
                                                                        </div>
                                                                        <input type="range" id="setting_height_slider" class="form-range compact-dimension-range" min="0" max="2400" step="1" value="0" data-layout-target="setting_height" data-layout-control="slider" data-layout-allow-empty="true">
                                                                        <div class="compact-dimension-row-body">
                                                                            <div class="input-group input-group-sm compact-dimension-scrub-wrap">
                                                                                <input type="number" id="setting_height"
                                                                                       class="form-control form-control-sm compact-dimension-number" min="0" max="2400"
                                                                                       step="1" placeholder="Auto" data-layout-target="setting_height" data-layout-control="number" data-layout-allow-empty="true">
                                                                                <span class="input-group-text">px</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button"
                                                                            id="setting_image_aspect_ratio_lock"
                                                                            class="btn btn-outline-secondary btn-sm image-aspect-ratio-lock settings-hidden"
                                                                            aria-pressed="true"
                                                                            aria-label="Unlock aspect ratio"
                                                                            title="Unlock aspect ratio">
                                                                        <i class="bi bi-lock-fill" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                in_array(
                                                                    $arrControl[
                                                                        "handle"
                                                                    ] ?? "",
                                                                    [
                                                                        "layoutDirection",
                                                                        "layoutJustify",
                                                                        "layoutAlign",
                                                                    ],
                                                                    true,
                                                                )
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                in_array(
                                                                    $arrControl[
                                                                        "handle"
                                                                    ] ?? "",
                                                                    [
                                                                        "layoutGap",
                                                                        "gridGapClampEnabled",
                                                                    ],
                                                                    true,
                                                                )
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                in_array(
                                                                    $arrControl[
                                                                        "handle"
                                                                    ] ?? "",
                                                                    [
                                                                        "rowGap",
                                                                        "rowGapClampEnabled",
                                                                        "rowChildPadding",
                                                                        "rowChildMargin",
                                                                        "rowHostGap",
                                                                    ],
                                                                    true,
                                                                )
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "gridContainerQueryWidths"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "layoutWrap"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "layoutMinHeight"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_button_group"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                ($arrControl[
                                                                    "handle"
                                                                ] ??
                                                                    "") ===
                                                                "contentAlign"
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>

                                                        <?php foreach (
                                                            $arrEditorRenderSlots[
                                                                "layout_primary"
                                                            ] ?? []
                                                            as $arrControl
                                                        ) { ?>
                                                            <?php if (
                                                                in_array(
                                                                    $arrControl[
                                                                        "handle"
                                                                    ] ?? "",
                                                                    [
                                                                        "absAnchor",
                                                                        "left",
                                                                        "z",
                                                                    ],
                                                                    true,
                                                                )
                                                            ) { ?>
                                                                <?php $this->load->view(
                                                                    "cms/content_block/controls/_schema_control_renderer",
                                                                    [
                                                                        "control" => $arrControl,
                                                                    ],
                                                                ); ?>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php foreach (
                                                $arrEditorRenderSlots[
                                                    "dyn_groups"
                                                ] ?? []
                                                as $arrDynGroup
                                            ) { ?>
                                                <?php
                                                $strDynSlotKey =
                                                    (string) ($arrDynGroup[
                                                        "slotKey"
                                                    ] ?? "");
                                                $strDynHandle =
                                                    (string) ($arrDynGroup[
                                                        "handle"
                                                    ] ?? "");
                                                $strDynLabel =
                                                    (string) ($arrDynGroup[
                                                        "label"
                                                    ] ?? $strDynHandle);
                                                $arrDynControls =
                                                    $arrEditorRenderSlots[
                                                        $strDynSlotKey
                                                    ] ?? [];
                                                $strDynCollapseId =
                                                    "collapse_dyn_" .
                                                    $strDynHandle;
                                                $strDynHeadingId =
                                                    "heading_dyn_" .
                                                    $strDynHandle;
                                                $strDynSectionKey =
                                                    "dyn__" . $strDynHandle;
                                                ?>
                                                <?php if (
                                                    !empty($arrDynControls)
                                                ) { ?>
                                                    <div class="accordion-item settings-hidden" data-settings-section="<?php echo htmlspecialchars(
                                                        $strDynSectionKey,
                                                        ENT_QUOTES,
                                                        "UTF-8",
                                                    ); ?>">
                                                        <h2 class="accordion-header" id="<?php echo htmlspecialchars(
                                                            $strDynHeadingId,
                                                            ENT_QUOTES,
                                                            "UTF-8",
                                                        ); ?>">
                                                            <button class="accordion-button collapsed py-2" type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#<?php echo htmlspecialchars(
                                                                        $strDynCollapseId,
                                                                        ENT_QUOTES,
                                                                        "UTF-8",
                                                                    ); ?>"
                                                                    aria-expanded="false"
                                                                    aria-controls="<?php echo htmlspecialchars(
                                                                        $strDynCollapseId,
                                                                        ENT_QUOTES,
                                                                        "UTF-8",
                                                                    ); ?>">
                                                                <span class="settings-section-title"><?php echo htmlspecialchars(
                                                                    $strDynLabel,
                                                                    ENT_QUOTES,
                                                                    "UTF-8",
                                                                ); ?></span>
                                                                <span class="bi bi-info-circle settings-section-info settings-hidden"
                                                                      data-settings-section-info role="button" tabindex="0"
                                                                      aria-label="<?php echo htmlspecialchars(
                                                                          $strDynLabel,
                                                                          ENT_QUOTES,
                                                                          "UTF-8",
                                                                      ); ?> help"></span>
                                                            </button>
                                                        </h2>
                                                        <div id="<?php echo htmlspecialchars(
                                                            $strDynCollapseId,
                                                            ENT_QUOTES,
                                                            "UTF-8",
                                                        ); ?>"
                                                             class="accordion-collapse collapse"
                                                             aria-labelledby="<?php echo htmlspecialchars(
                                                                 $strDynHeadingId,
                                                                 ENT_QUOTES,
                                                                 "UTF-8",
                                                             ); ?>"
                                                             data-bs-parent="#block_styles_accordion">
                                                            <div class="accordion-body">
                                                                <?php foreach (
                                                                    $arrDynControls
                                                                    as $arrControl
                                                                ) { ?>
                                                                    <?php $this->load->view(
                                                                        "cms/content_block/controls/_schema_control_renderer",
                                                                        [
                                                                            "control" => $arrControl,
                                                                        ],
                                                                    ); ?>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        </aside>
                    </div>
                </div>
            </div>

            <div class="form-group row py-2 d-none">
                <label for="import_html" class="col-sm-2 col-form-label">Import HTML *</label>
                <div class="col-sm-10">
                            <textarea id="import_html" class="form-control" name="import_html"
                                      rows="4"><?php echo htmlspecialchars(
                                          $content_block_html ?? "",
                                          ENT_QUOTES,
                                          "UTF-8",
                                      ); ?></textarea>
                </div>
            </div>

            <div class="form-group row py-2 d-none">
                <label for="import_css" class="col-sm-2 col-form-label">Import CSS *</label>
                <div class="col-sm-10">
                            <textarea id="import_css" class="form-control" name="import_css"
                                      rows="4"><?php echo htmlspecialchars(
                                          $content_block_css ?? "",
                                          ENT_QUOTES,
                                          "UTF-8",
                                      ); ?></textarea>
                </div>
            </div>

            <input type="hidden" id="import_html_b64" name="import_html_b64" value=""/>
            <input type="hidden" id="import_css_b64" name="import_css_b64" value=""/>
            <input type="hidden" id="content_block_editor_id" name="id" value="<?php echo $content_block_editor_id ??
                "temp" . uniqid(); ?>"/>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-bottom developer-code-offcanvas" tabindex="-1" id="developer_code_offcanvas" aria-label="Content block code panel" data-bs-backdrop="true" data-bs-scroll="false">
    <div class="offcanvas-body developer-code-offcanvas-body">
        <div class="developer-code-toolbar">
            <div class="developer-code-toolbar-main">
                <div class="developer-code-heading">
                    <span class="developer-code-kicker">Developer Output</span>
                    <span class="developer-code-title">Content Block Export</span>
                </div>
                <div class="developer-code-switch" id="developer_code_tabs" role="tablist" aria-label="Code type">
                    <button class="developer-code-switch-btn" id="developer_code_json_tab" data-bs-toggle="tab" data-bs-target="#developer_code_json_panel" type="button" role="tab" aria-controls="developer_code_json_panel" aria-selected="false">JSON</button>
                    <button class="developer-code-switch-btn active" id="developer_code_html_tab" data-bs-toggle="tab" data-bs-target="#developer_code_html_panel" type="button" role="tab" aria-controls="developer_code_html_panel" aria-selected="true">HTML</button>
                    <button class="developer-code-switch-btn" id="developer_code_css_tab" data-bs-toggle="tab" data-bs-target="#developer_code_css_panel" type="button" role="tab" aria-controls="developer_code_css_panel" aria-selected="false">CSS</button>
                </div>
            </div>
            <div class="developer-code-toolbar-actions">
                <button type="button" class="developer-code-toolbar-btn" id="developer_code_copy_btn" aria-label="Copy active code panel" title="Copy active code panel">
                    <i class="bi bi-clipboard" aria-hidden="true"></i>
                    <span>Copy</span>
                </button>
                <button type="button" class="developer-code-toolbar-btn developer-code-toolbar-btn-close" data-bs-dismiss="offcanvas" aria-label="Close code panel" title="Close code panel">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>
            </div>
        </div>
        <div class="tab-content developer-code-tab-content">
            <section class="tab-pane fade" id="developer_code_json_panel" role="tabpanel" aria-labelledby="developer_code_json_tab">
                <div class="developer-code-frame" id="developer_code_json"></div>
            </section>
            <section class="tab-pane fade show active" id="developer_code_html_panel" role="tabpanel" aria-labelledby="developer_code_html_tab">
                <div class="developer-code-frame" id="developer_code_html"></div>
            </section>
            <section class="tab-pane fade" id="developer_code_css_panel" role="tabpanel" aria-labelledby="developer_code_css_tab">
                <div class="developer-code-frame" id="developer_code_css"></div>
            </section>
        </div>
    </div>
</div>

    <div class="modal fade" id="fresh_start_wizard_modal" tabindex="-1" aria-labelledby="fresh_start_wizard_title" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content editor-onboarding-modal">
                <div class="modal-body">
                    <div class="editor-onboarding-shell">
                        <aside class="editor-onboarding-guide" aria-label="Editor guide">
                            <div class="editor-onboarding-guide-kicker">Before you start</div>
                            <h3 class="editor-onboarding-guide-title">Build with a clear setup</h3>
                            <p class="editor-onboarding-guide-copy">This quick setup names the content block, picks the layout mode, and sets the desktop canvas width before the first root layout is created.</p>
                            <ol class="editor-onboarding-guide-list">
                                <li>Name the content block so it is easy to identify later.</li>
                                <li>Choose <strong>Freeform</strong> for art-directed placement or <strong>Stacked</strong> for structured content flow.</li>
                                <li>Set the desktop width to match the design space you expect to build against.</li>
                                <li>After setup, drag blocks from the left sidebar into the new layout and edit content from the settings panel.</li>
                                <li>Use Desktop, Tablet, and Mobile preview buttons to refine each breakpoint.</li>
                                <li>In Freeform layouts, drag items on the canvas and use Layers to control order without accidental movement.</li>
                            </ol>
                        </aside>

                        <div class="editor-onboarding-main">
                            <div class="editor-onboarding-steps">
                                <section class="editor-onboarding-step" data-onboarding-step="name">
                                    <div class="editor-onboarding-intro">
                                        <div class="editor-onboarding-kicker">Step 1 of 3</div>
                                        <h2 class="editor-onboarding-title" id="fresh_start_wizard_title">Name this content block</h2>
                                        <p class="editor-onboarding-copy mb-0">Add the block name now so the editor starts with a clear label before you choose the layout and desktop width.</p>
                                    </div>
                                    <div class="editor-onboarding-name-card">
                                        <label class="editor-onboarding-field-label" for="fresh_start_wizard_name">Content block name</label>
                                        <input
                                                type="text"
                                                class="form-control editor-onboarding-name-input"
                                                id="fresh_start_wizard_name"
                                                maxlength="50"
                                                placeholder="Example: Homepage Hero Banner"
                                                autocomplete="off"
                                        />
                                        <div class="editor-onboarding-error settings-hidden" id="fresh_start_wizard_name_error" aria-live="polite">
                                            Please enter a content block name before continuing.
                                        </div>
                                    </div>
                                </section>

                                <section class="editor-onboarding-step settings-hidden" data-onboarding-step="layout" aria-hidden="true">
                                    <div class="editor-onboarding-intro">
                                        <div class="editor-onboarding-kicker">Step 2 of 3</div>
                                        <h2 class="editor-onboarding-title">Choose a layout type</h2>
                                        <p class="editor-onboarding-copy mb-0">Pick the editing mode that fits how you want to build this content block.</p>
                                    </div>
                                    <div class="editor-onboarding-grid" role="group" aria-label="Layout type">
                                        <button type="button" class="editor-onboarding-option" data-onboarding-layout="absolute">
                                            <span class="editor-onboarding-option-icon"><i class="bi bi-bounding-box-circles" aria-hidden="true"></i></span>
                                            <span class="editor-onboarding-option-title">Freeform</span>
                                            <span class="editor-onboarding-option-copy">Place elements anywhere on the canvas, layer them visually, and drag items to exact positions. Best for hero scenes, posters, and highly art-directed layouts.</span>
                                        </button>
                                        <button type="button" class="editor-onboarding-option" data-onboarding-layout="grid">
                                            <span class="editor-onboarding-option-icon"><i class="bi bi-layout-three-columns" aria-hidden="true"></i></span>
                                            <span class="editor-onboarding-option-title">Stacked</span>
                                            <span class="editor-onboarding-option-copy">Build in a structured flow with rows and blocks that naturally stack and respond. Best for sections, articles, promos, and modular content.</span>
                                        </button>
                                    </div>
                                </section>

                                <?php
                                $arrOnboardingPresets = [];
                                foreach (
                                    $arrContentBlockSchema["canvasPresets"] ??
                                        []
                                    as $arrCPreset
                                ) {
                                    if (empty($arrCPreset["isActive"])) {
                                        continue;
                                    }
                                    $iCWidth =
                                        (int) ($arrCPreset["desktopWidth"] ??
                                            0);
                                    if ($iCWidth <= 0) {
                                        continue;
                                    }
                                    $strCLayout =
                                        (string) ($arrCPreset["layoutType"] ??
                                            "grid");
                                    $arrOnboardingPresets[] = [
                                        "desktopWidth" => $iCWidth,
                                        "layoutType" => $strCLayout,
                                        "label" =>
                                            (string) ($arrCPreset["label"] ??
                                                ""),
                                    ];
                                }
                                $arrOnboardingPresetsDeduped = [];
                                $arrOnboardingSeenKeys = [];
                                foreach ($arrOnboardingPresets as $arrOP) {
                                    $strOpKey =
                                        $arrOP["desktopWidth"] .
                                        "|" .
                                        $arrOP["layoutType"];
                                    if (
                                        !isset(
                                            $arrOnboardingSeenKeys[$strOpKey],
                                        )
                                    ) {
                                        $arrOnboardingPresetsDeduped[] = $arrOP;
                                        $arrOnboardingSeenKeys[
                                            $strOpKey
                                        ] = true;
                                    }
                                }
                                if (empty($arrOnboardingPresetsDeduped)) {
                                    foreach (
                                        $desktop_width_options ?? []
                                        as $iFbWidth
                                    ) {
                                        $arrOnboardingPresetsDeduped[] = [
                                            "desktopWidth" => (int) $iFbWidth,
                                            "layoutType" => "",
                                            "label" => "",
                                        ];
                                    }
                                }
                                ?>
                                <section class="editor-onboarding-step settings-hidden" data-onboarding-step="desktop-width" aria-hidden="true">
                                    <div class="editor-onboarding-intro">
                                        <div class="editor-onboarding-kicker">Step 3 of 3</div>
                                        <h2 class="editor-onboarding-title">Choose a desktop width</h2>
                                        <p class="editor-onboarding-copy mb-0">This sets the desktop preview width for this content block before the first layout is created. In the MerchOS front end, 1230px is the store's default size. Any other widths shown here come from the current content block canvas settings.</p>
                                    </div>
                                    <div class="editor-onboarding-grid" role="group" aria-label="Desktop width">
                                        <?php foreach (
                                            $arrOnboardingPresetsDeduped
                                            as $arrOP
                                        ) { ?>
                                            <?php
                                            $iOnboardingWidth =
                                                (int) $arrOP["desktopWidth"];
                                            $strOnboardingLayoutType = htmlspecialchars(
                                                (string) $arrOP["layoutType"],
                                                ENT_QUOTES,
                                                "UTF-8",
                                            );
                                            ?>
                                            <button type="button"
                                                    class="editor-onboarding-option"
                                                    data-onboarding-desktop-width="<?php echo $iOnboardingWidth; ?>"
                                                    data-preset-layout-type="<?php echo $strOnboardingLayoutType; ?>">
                                                <span class="editor-onboarding-option-title"><?php echo $iOnboardingWidth; ?>px</span>
                                            </button>
                                        <?php } ?>
                                    </div>
                                </section>
                            </div>

                            <div class="editor-onboarding-footer">
                                <button
                                        type="button"
                                        class="btn btn-outline-secondary editor-onboarding-cancel"
                                        id="fresh_start_wizard_cancel_btn"
                                        data-cancel-href="<?php echo $domain_extn; ?>/cms/Content_block/view"
                                >
                                    Cancel
                                </button>
                                <button
                                        type="button"
                                        class="btn btn-dark editor-onboarding-footer-action editor-onboarding-continue"
                                        id="fresh_start_wizard_step_action_btn"
                                >
                                    Continue
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="editor_media_modal" tabindex="-1" aria-labelledby="editor_media_modal_title" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content editor-media-modal">
                <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="editor_media_modal_title">Select Image</h5>
                    <p class="editor-media-subtitle mb-0" id="editor_media_modal_hint">Choose an image for the selected block.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="editor-media-toolbar editor-media-toolbar-modal">
                    <div class="editor-media-actions">
                        <input type="search" class="form-control form-control-sm" id="editor_media_search_input" placeholder="Search images">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="editor_media_upload_btn">Upload</button>
                    </div>
                    <div class="editor-media-selected-meta" id="editor_media_selected_meta">No image selected.</div>
                    <div class="editor-media-upload-status settings-hidden" id="editor_media_upload_status" aria-live="polite"></div>
                </div>

                <div class="editor-media-upload-panel settings-hidden" id="editor_media_upload_container">
                    <form action="/cms/Media_library/file_upload" id="editor_media_upload_form" ondrop>
                        <fieldset class="upload-dropzone editor-upload-dropzone text-center mb-3 p-4" id="editor_media_upload_drop_zone">
                            <legend class="visually-hidden">Media uploader</legend>
                            <i class="fa fa-upload editor-media-upload-icon"></i>
                            <p class="small my-2">Add files inside dashed region<br><i>or</i></p>
                            <input id="editor_media_upload_input" class="position-absolute invisible" type="file" accept="image/*" multiple="multiple" />
                            <label class="btn btn-upload mb-0" for="editor_media_upload_input">Choose file(s)</label>
                        </fieldset>
                    </form>

                    <div class="d-flex justify-content-center align-items-center gap-3 mb-3">
                        <div class="spinner-border settings-hidden" id="editor_media_upload_spinner" role="status">
                            <span class="visually-hidden">Transferring files to S3</span>
                        </div>
                        <div id="editor_media_upload_spinner_text" class="settings-hidden">Transferring files to S3</div>
                        <div class="progress flex-grow-1 settings-hidden" id="editor_media_upload_progress_wrap">
                            <div class="progress-bar justify-content-center editor-media-upload-progress-bar" id="editor_media_upload_progress_bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>
                </div>

                <div class="editor-media-gallery-shell editor-media-gallery-shell-modal">
                    <div class="upload-gallery d-flex flex-wrap justify-content-start" id="editor_media_gallery">
                        <?php echo $media_selector_image_html ?? ""; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<template id="scrub_number_handle_template">
    <button type="button" class="scrub-number-handle" aria-label="Drag to adjust value">
        <?php $this->load->view(
            "cms/content_block/controls/_scrub_handle_icon",
        ); ?>
    </button>
</template>

<template id="scrub_number_field_template">
    <?php $this->load->view(
        "cms/content_block/controls/_scrub_number_field_shell",
    ); ?>
</template>

<template id="image_aspect_ratio_lock_button_template">
    <?php $this->load->view(
        "cms/content_block/controls/_image_aspect_ratio_lock_button",
    ); ?>
</template>

<template id="editor_media_loading_template">
    <?php $this->load->view("cms/content_block/controls/_editor_empty_state", [
        "strClass" => "editor-media-empty",
        "strMessage" => "Loading media...",
    ]); ?>
</template>

<template id="editor_media_empty_template">
    <?php $this->load->view("cms/content_block/controls/_editor_empty_state", [
        "strClass" => "editor-media-empty",
        "strMessage" => "No media available.",
    ]); ?>
</template>

<template id="editor_sidebar_empty_template">
    <?php $this->load->view("cms/content_block/controls/_editor_empty_state", [
        "strClass" => "hint",
        "strMessage" => "No columns yet. Use Add column.",
    ]); ?>
</template>

<template id="editor_palette_empty_template">
    <?php $this->load->view("cms/content_block/controls/_editor_empty_state", [
        "strClass" => "text-muted small mb-0",
        "strMessage" => "No schema block types are available.",
    ]); ?>
</template>

<script type="text/javascript">
window.CB_CANVAS_DESKTOP_CONTAINER_WIDTH = <?php echo CONTENT_BLOCK_CANVAS_DESKTOP_CONTAINER_WIDTH; ?>;
window.CB_CANVAS_DESKTOP_FULL_WIDTH = <?php echo CONTENT_BLOCK_CANVAS_DESKTOP_FULL_WIDTH; ?>;
window.CB_DESKTOP_CONTAINER_WIDTH = window.CB_CANVAS_DESKTOP_CONTAINER_WIDTH;
window.CB_DESKTOP_FULL_WIDTH = window.CB_CANVAS_DESKTOP_FULL_WIDTH;
window.CB_DESKTOP_WIDTH_OPTIONS = <?php echo json_encode(
    array_values($desktop_width_options ?? []),
); ?>;
window.CB_VIEWPORT_PRESETS = <?php echo json_encode($viewport_presets); ?>;
</script>
<?php if (
    !empty($feature_cqw_scaling_enabled) &&
    !empty($path_cqw_scaling_js)
): ?>
<script type="text/javascript" src="<?php echo $path_cqw_scaling_js; ?>?filever=<?php echo $strFileVersion; ?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo $path_editor_js; ?>?filever=<?php echo $strFileVersion; ?>"></script>
<script type="text/javascript" src="<?php echo $path_sortable_js; ?>?filever=<?php echo $strFileVersion; ?>"></script>
