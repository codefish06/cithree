<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$page_title = 'Create Content Block';
$active_nav = 'content_block';
$this->load->view('template/app_start');
?>

<div class="app-page-header">
    <p class="app-page-kicker">Builder</p>
    <div class="d-flex flex-column flex-lg-row justify-content-lg-between align-items-lg-end gap-3">
        <div>
            <h1 class="h2 mb-2">Create new content block</h1>
            <p class="text-secondary mb-0">Drag starter elements onto the canvas and copy the generated HTML when you are done.</p>
        </div>
        <a href="<?php echo site_url('content_block'); ?>" class="btn btn-outline-secondary">Back to blocks</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Starter elements</h2>
                <div class="app-builder-grid">
                    <div class="app-builder-tile block-item" draggable="true" data-type="button">
                        <span class="app-builder-icon">
                            <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M2.5 4A1.5 1.5 0 0 0 1 5.5v5A1.5 1.5 0 0 0 2.5 12h11a1.5 1.5 0 0 0 1.5-1.5v-5A1.5 1.5 0 0 0 13.5 4h-11z"></path>
                            </svg>
                        </span>
                        <div class="fw-semibold">Button</div>
                    </div>
                    <div class="app-builder-tile block-item" draggable="true" data-type="text">
                        <span class="app-builder-icon">
                            <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M2 4.5A1.5 1.5 0 0 1 3.5 3h9A1.5 1.5 0 0 1 14 4.5v1A1.5 1.5 0 0 1 12.5 7h-9A1.5 1.5 0 0 1 2 5.5v-1zm0 5A1.5 1.5 0 0 1 3.5 8h5A1.5 1.5 0 0 1 10 9.5v1A1.5 1.5 0 0 1 8.5 12h-5A1.5 1.5 0 0 1 2 10.5v-1z"></path>
                            </svg>
                        </span>
                        <div class="fw-semibold">Text</div>
                    </div>
                    <div class="app-builder-tile block-item" draggable="true" data-type="image">
                        <span class="app-builder-icon">
                            <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M4.502 1a1.5 1.5 0 0 0-1.5 1.5v11a1.5 1.5 0 0 0 1.5 1.5h7a1.5 1.5 0 0 0 1.5-1.5v-11a1.5 1.5 0 0 0-1.5-1.5h-7zm6.998 12.5a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5V11l2.5-2.5 1.5 1.5 2.5-3 1.5 2v4.5zM5.5 6.5A1.5 1.5 0 1 0 5.5 3a1.5 1.5 0 0 0 0 3.5z"></path>
                            </svg>
                        </span>
                        <div class="fw-semibold">Image</div>
                    </div>
                    <div class="app-builder-tile block-item" draggable="true" data-type="paragraph">
                        <span class="app-builder-icon">
                            <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M2 2.5A1.5 1.5 0 0 1 3.5 1H12v1H8v13H7V2H3.5a.5.5 0 0 0 0 1H6v1H3.5A1.5 1.5 0 0 1 2 2.5z"></path>
                            </svg>
                        </span>
                        <div class="fw-semibold">Paragraph</div>
                    </div>
                    <div class="app-builder-tile block-item" draggable="true" data-type="divider">
                        <span class="app-builder-icon">
                            <svg class="bi" width="20" height="20" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M1 8a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13A.5.5 0 0 1 1 8z"></path>
                            </svg>
                        </span>
                        <div class="fw-semibold">Divider</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h2 class="h5 mb-3">Canvas</h2>
                <div id="canvas" class="canvas-area"></div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="code-shell">
                    <div class="code-shell-header">
                        <span class="fw-semibold">Generated HTML</span>
                        <button id="copy-btn" class="btn btn-outline-light btn-sm">Copy</button>
                    </div>
                    <pre class="code-pre"><code id="html-output" class="code-output"></code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function formatHtml(html) {
    var formatted = '';
    var indent = 0;
    var tags = html.match(/<\/?[^>]+>/g) || [];
    var lastIndex = 0;

    tags.forEach(function(tag) {
        var index = html.indexOf(tag, lastIndex);
        var text = html.substring(lastIndex, index).trim();

        if (text) {
            formatted += '  '.repeat(indent) + text + '\n';
        }
        if (tag.startsWith('</')) {
            indent--;
        }

        formatted += '  '.repeat(indent) + tag + '\n';
        if (!tag.startsWith('</') && !tag.endsWith('/>')) {
            indent++;
        }

        lastIndex = index + tag.length;
    });

    return formatted;
}

function updateHtmlOutput() {
    var canvas = document.getElementById('canvas');
    var html = canvas.innerHTML.replace(/<button class="delete-btn"[\s\S]*?<\/button>/g, '');
    document.getElementById('html-output').textContent = formatHtml(html);
}

document.addEventListener('DOMContentLoaded', function() {
    var blocks = document.querySelectorAll('.block-item');
    var canvas = document.getElementById('canvas');
    var copyButton = document.getElementById('copy-btn');

    blocks.forEach(function(block) {
        block.addEventListener('dragstart', function(e) {
            e.dataTransfer.effectAllowed = 'copy';
            e.dataTransfer.setData('blockType', this.dataset.type);
        });
    });

    canvas.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
        canvas.classList.add('drag-over');
    });

    canvas.addEventListener('dragleave', function() {
        canvas.classList.remove('drag-over');
    });

    canvas.addEventListener('drop', function(e) {
        e.preventDefault();
        canvas.classList.remove('drag-over');
        addBlockToCanvas(e.dataTransfer.getData('blockType'));
    });

    copyButton.addEventListener('click', function() {
        var code = document.getElementById('html-output').textContent;
        navigator.clipboard.writeText(code);
        copyButton.textContent = 'Copied';
        setTimeout(function() {
            copyButton.textContent = 'Copy';
        }, 2000);
    });

    function addBlockToCanvas(type) {
        var row = document.createElement('div');
        row.className = 'quick-drag';
        row.appendChild(createBlock(type));
        canvas.appendChild(row);
        updateHtmlOutput();
    }

    function createBlock(type) {
        var div = document.createElement('div');
        div.className = 'canvas-block';
        div.innerHTML = '<button class="delete-btn" type="button">&times;</button>';

        if (type === 'button') {
            div.innerHTML += '<button class="btn btn-primary">Button</button>';
        } else if (type === 'text') {
            div.innerHTML += '<p class="mb-0">Text Block</p>';
        } else if (type === 'image') {
            div.innerHTML += '<img src="https://via.placeholder.com/300" alt="Image" class="img-fluid rounded">';
        } else if (type === 'paragraph') {
            div.innerHTML += '<p class="mb-0">Paragraph content goes here...</p>';
        } else if (type === 'divider') {
            div.innerHTML += '<hr class="my-1">';
        }

        div.querySelector('.delete-btn').addEventListener('click', function() {
            div.parentElement.remove();
            updateHtmlOutput();
        });

        return div;
    }
});
</script>

<?php $this->load->view('template/app_end'); ?>
