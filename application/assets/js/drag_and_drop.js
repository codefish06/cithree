/**
 * DND Editor Module
 * Encapsulated to prevent global scope pollution
 */
const DndEditor = {
    // Configuration Constants
    config: {
        BLOCK_TOP: 50,
        BLOCK_LEFT: 50,
        INITIAL_Z_INDEX: 10,
        MIN_WIDTH: 50,
        MIN_HEIGHT: 50,
        SPACING: 15
    },

    // State Management
    state: {
        blockCount: 0,
        zIndexCounter: 10,
        originalPositions: {},
        domain: jQuery("#domain_extn").val() || ''
    },

    init: function() {
        this.state.zIndexCounter = this.config.INITIAL_Z_INDEX;
        this.bindGlobalEvents();
        console.log("DND Editor Initialized");
    },

    bindGlobalEvents: function() {
        // Example: Global click listeners or shortcuts
        // Handle window resizing or canvas-level events here
    },

    /**
     * AJAX: Create Block
     */
    createBlock: function(type) {
        this.state.blockCount++;
        this.state.zIndexCounter++;

        const blockId = `dnd-${jQuery("#dnd_id").val()}-block-${this.state.blockCount}`;

        jQuery.ajax({
            type: "POST",
            url: `${this.state.domain}/cms/Drag_and_drop_editor/get_block_template`,
            data: { type: type, count: this.state.blockCount },
            success: (content) => {
                const html = `
                    <div id="${blockId}" class="floating-block" data-block-type="${type}" 
                         style="top: ${this.config.BLOCK_TOP}px; left: ${this.config.BLOCK_LEFT}px; z-index: ${this.state.zIndexCounter};">
                        <div class="delete-btn" title="Remove">X</div>
                        <div class="edit-btn" title="Edit"><i class="fa fa-pencil"></i></div>
                        <div class="panel-v block-content" style="height: 100%; min-height: inherit;">${content}</div>
                    </div>`;

                const $block = jQuery(html).appendTo("#canvas");
                this.setupBlockInteraction($block);
                this.storePosition($block);
            },
            error: () => alert("Failed to create block")
        });
    },

    /**
     * Interaction Setup (Draggable/Resizable)
     */
    setupBlockInteraction: function($block) {
        // Cleanup existing if necessary
        if ($block.is('.ui-draggable')) $block.draggable('destroy');
        if ($block.is('.ui-resizable')) $block.resizable('destroy');

        $block.draggable({
            containment: "window", 
            stack: ".floating-block",
            cursor: "move",
            stop: () => this.storePosition($block)
        }).resizable({
            containment: "#canvas",
            minWidth: this.config.MIN_WIDTH,
            minHeight: this.config.MIN_HEIGHT,
            handles: "all",
            resize: (e, ui) => {
                $block.find(".block-content").css({
                    "height": ui.size.height + "px",
                    "width": ui.size.width + "px"
                });
            },
            stop: () => this.storePosition($block)
        });

        // Event Delegation for Buttons
        $block.on("click", ".delete-btn", (e) => {
            if (confirm("Delete this section?")) {
                delete this.state.originalPositions[$block.attr("id")];
                $block.remove();
            }
        });

        $block.on("click", ".edit-btn", (e) => this.openEditPanel($block));
        
        $block.on("mousedown", () => {
            this.state.zIndexCounter++;
            $block.css("z-index", this.state.zIndexCounter);
        });
    },

    /**
     * Edit Panel Logic
     */
    openEditPanel: function($block) {
        const type = $block.attr('data-block-type');
        const id = $block.attr('id');
        
        // Remove existing panel
        jQuery('.edit-panel').remove();

        // Data gathering logic
        const styles = {
            'background-color': this.safeHex($block.css('background-color')),
            'border-width': parseInt($block.css('border-width')) || 0,
            'border-color': this.safeHex($block.css('border-color')),
            'border-radius': parseInt($block.css('border-radius')) || 0
        };

        const contentData = this.getBlockContentData($block, type);
        const fonts = jQuery('.font-names').map((_, el) => jQuery(el).val()).get();

        jQuery.ajax({
            type: "POST",
            url: `${this.state.domain}/cms/Drag_and_drop_editor/get_edit_panel`,
            data: {
                type: this.unicodeBtoa(type),
                blockId: this.unicodeBtoa(id),
                blockStyles: this.unicodeBtoa(JSON.stringify(styles)),
                contentData: this.unicodeBtoa(JSON.stringify(contentData)),
                fonts: this.unicodeBtoa(JSON.stringify(fonts))
            },
            success: (html) => {
                const $panel = jQuery(html).appendTo('body');
                this.initPanelTools($panel, $block, type);
                this.positionPanel($panel, $block);
            }
        });
    },

    /**
     * Internal Helpers
     */
    getBlockContentData: function($block, type) {
        switch(type) {
            case 'text': return { text: $block.find('.text-content').html() };
            case 'button': 
                const $btn = $block.find('.block-button');
                return {
                    text: $btn.text(),
                    link: $btn.attr('data-link') || '',
                    style: $btn.attr('class').match(/btn-[a-z]+/)?.[0] || 'btn-primary'
                };
            case 'image':
                const $img = $block.find('img');
                return { src: $img.attr('src'), fit: $img.css('object-fit') };
            default: return {};
        }
    },

    initPanelTools: function($panel, $block, type) {
        // Summernote init for Text
        if (type === 'text') {
            const portalFonts = jQuery('.font-names').map((_, el) => jQuery(el).val()).get();
            $panel.find('.edit-text-content').summernote({
                height: 150,
                fontNames: portalFonts.concat(['Arial', 'Courier New', 'Merriweather']),
                fontNamesIgnoreCheck: portalFonts
            });
        }

        // Apply Logic
        $panel.on('click', '.btn-apply-edit', () => {
            this.applyChanges($panel, $block, type);
            if (type === 'text') $panel.find('.edit-text-content').summernote('destroy');
            $panel.remove();
        });

        // Close Logic
        $panel.on('click', '.btn-close-panel, .btn-close-edit', () => {
            if (type === 'text') $panel.find('.edit-text-content').summernote('destroy');
            $panel.remove();
        });
    },

    applyChanges: function($panel, $block, type) {
        // 1. Common Styles
        const isTrans = $panel.find('.edit-bg-transparent').is(':checked');
        $block.css({
            'background-color': isTrans ? 'transparent' : $panel.find('.edit-bg-color').val(),
            'border-width': $panel.find('.edit-border-width').val() + 'px',
            'border-color': $panel.find('.edit-border-color').val(),
            'border-radius': $panel.find('.edit-border-radius').val() + 'px',
            'border-style': 'solid'
        });

        // 2. Type Specific
        if (type === 'text') {
            const code = $panel.find('.edit-text-content').summernote('code');
            $block.find('.text-content').html(code);
        } else if (type === 'image') {
            const url = $panel.find('.edit-image-url').val();
            const fit = $panel.find('.edit-image-fit').val();
            $block.find('.image-block-wrapper').html(`<img src="${url}" style="width:100%; height:100%; object-fit:${fit}">`);
        }
    },

    storePosition: function($block) {
        const id = $block.attr("id");
        if (!id) return;
        this.state.originalPositions[id] = {
            top: $block.css("top"),
            left: $block.css("left"),
            width: $block.css("width"),
            height: $block.css("height")
        };
    },

    safeHex: function(color) {
        if (!color || color === 'transparent' || color.includes('rgba(0, 0, 0, 0)')) return 'transparent';
        if (color.startsWith('#')) return color;
        const rgb = color.match(/\d+/g);
        return rgb ? "#" + ((1 << 24) + (parseInt(rgb[0]) << 16) + (parseInt(rgb[1]) << 8) + parseInt(rgb[2])).toString(16).slice(1) : '#ffffff';
    },

    unicodeBtoa: (str) => btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, (m, p) => String.fromCharCode('0x' + p))),

    positionPanel: function($panel, $block) {
        const offset = $block.offset();
        $panel.css({
            top: offset.top,
            left: offset.left + $block.outerWidth() + 20,
            position: 'absolute',
            zIndex: 9999
        });
    }
};

// Initialize on Load
jQuery(function() {
    DndEditor.init();
});