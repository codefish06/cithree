<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create Content Block - <?php echo APP_NAME; ?></title>
    <link href="<?php echo base_url('application/assets/css/output.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('application/assets/css/grid-layout.css'); ?>" rel="stylesheet">
</head>
<body class="app-body">
    <div class="grid-container">
        <?php $this->load->view('template/header_menu'); ?>
        <main>
            <div class="page-header-row">
                <h1 class="page-title-inline">Create New Content Block</h1>
            </div>

            <div class="page-content">
                <div class="builder-grid">
                    <div class="block-item block-item-button" draggable="true" data-type="button">
                        <svg class="block-icon block-icon-button" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path></svg>
                        <p class="block-label block-label-button">Button</p>
                    </div>
                    <div class="block-item block-item-text" draggable="true" data-type="text">
                        <svg class="block-icon block-icon-text" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path></svg>
                        <p class="block-label block-label-text">Text</p>
                    </div>
                    <div class="block-item block-item-image" draggable="true" data-type="image">
                        <svg class="block-icon block-icon-image" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path></svg>
                        <p class="block-label block-label-image">Image</p>
                    </div>
                    <div class="block-item block-item-paragraph" draggable="true" data-type="paragraph">
                        <svg class="block-icon block-icon-paragraph" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path></svg>
                        <p class="block-label block-label-paragraph">Paragraph</p>
                    </div>
                    <div class="block-item block-item-divider" draggable="true" data-type="divider">
                        <svg class="block-icon block-icon-divider" fill="currentColor" viewBox="0 0 20 20"><path d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path></svg>
                        <p class="block-label block-label-divider">Divider</p>
                    </div>
                </div>

                <h3 class="section-title">Canvas</h3>
                <div id="canvas" class="canvas-area">
                </div>

                <h3 class="section-title section-title-gap">Generated HTML</h3>
                <div class="code-shell">
                    <div class="code-shell-header">
                        <span class="code-filename">index.html</span>
                        <button id="copy-btn" class="btn btn-copy">Copy</button>
                    </div>
                    <pre class="code-pre"><code id="html-output" class="code-output"></code></pre>
                </div>

                <script>
                    function formatHtml(html) {
                        let formatted = '';
                        let indent = 0;
                        const tags = html.match(/<\/?[^>]+>/g) || [];
                        let lastIndex = 0;

                        tags.forEach(tag => {
                            const index = html.indexOf(tag, lastIndex);
                            const text = html.substring(lastIndex, index).trim();
                            
                            if (text) formatted += '  '.repeat(indent) + text + '\n';
                            if (tag.startsWith('</')) indent--;
                            
                            formatted += '  '.repeat(indent) + tag + '\n';
                            if (!tag.startsWith('</') && !tag.endsWith('/>')) indent++;
                            
                            lastIndex = index + tag.length;
                        });

                        return formatted;
                    }

                    function updateHtmlOutput() {
                        const canvas = document.getElementById('canvas');
                        const html = canvas.innerHTML.replace(/<button class="delete-btn"[\s\S]*?<\/button>/g, '');
                        document.getElementById('html-output').textContent = formatHtml(html);
                    }

                    document.getElementById('copy-btn').addEventListener('click', function() {
                        const code = document.getElementById('html-output').textContent;
                        navigator.clipboard.writeText(code);
                        this.textContent = 'Copied!';
                        setTimeout(() => this.textContent = 'Copy', 2000);
                    });
                </script>
            </div>
        </main>
        <?php $this->load->view('template/footer'); ?>
    </div>
</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const blocks = document.querySelectorAll('.block-item');
        const canvas = document.getElementById('canvas');

        blocks.forEach(block => {
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
            const blockType = e.dataTransfer.getData('blockType');
            addBlockToCanvas(blockType);
        });

        function addBlockToCanvas(type) {
            const row = document.createElement('div');
            row.className = 'row quick-drag';
            
            const block = createBlock(type);
            row.appendChild(block);
            canvas.appendChild(row);
            updateHtmlOutput();
        }

        function createBlock(type) {
            const div = document.createElement('div');
            div.className = 'canvas-block';
            div.innerHTML = `<button class="delete-btn">×</button>`;

            if (type === 'button') {
                div.innerHTML += '<button class="canvas-action-btn">Button</button>';
            } else if (type === 'text') {
                div.innerHTML += '<p class="canvas-text">Text Block</p>';
            } else if (type === 'image') {
                div.innerHTML += '<img src="https://via.placeholder.com/300" alt="Image" class="canvas-image">';
            } else if (type === 'paragraph') {
                div.innerHTML += '<p class="canvas-paragraph">Paragraph content goes here...</p>';
            } else if (type === 'divider') {
                div.innerHTML += '<hr class="canvas-divider">';
            }

            div.querySelector('.delete-btn').addEventListener('click', function() {
                div.parentElement.remove();
                updateHtmlOutput();
            });

            return div;
        }

    });
</script>
