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
    <script src="<?php echo base_url('application/assets/js/dragdrop.js'); ?>"></script>
</head>
<body class="bg-white text-gray-600 font-sans">
    <div class="grid-container">
        <?php $this->load->view('template/header_menu'); ?>
        <main>
            <div class="mx-4 my-6 pb-2 border-b border-gray-300 flex items-center justify-between">
                <h1 class="text-2xl font-normal text-gray-700">Create New Content Block</h1>
            </div>

            <div class="mx-4 my-6">
                <div class="grid grid-cols-4 gap-4 mb-6">
                    <div class="block-item p-4 bg-blue-50 border-2 border-blue-300 rounded cursor-move hover:bg-blue-100 flex flex-col items-center gap-2" draggable="true" data-type="button">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path></svg>
                        <p class="font-semibold text-blue-600 text-sm">Button</p>
                    </div>
                    <div class="block-item p-4 bg-green-50 border-2 border-green-300 rounded cursor-move hover:bg-green-100 flex flex-col items-center gap-2" draggable="true" data-type="text">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"></path></svg>
                        <p class="font-semibold text-green-600 text-sm">Text</p>
                    </div>
                    <div class="block-item p-4 bg-purple-50 border-2 border-purple-300 rounded cursor-move hover:bg-purple-100 flex flex-col items-center gap-2" draggable="true" data-type="image">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"></path></svg>
                        <p class="font-semibold text-purple-600 text-sm">Image</p>
                    </div>
                    <div class="block-item p-4 bg-orange-50 border-2 border-orange-300 rounded cursor-move hover:bg-orange-100 flex flex-col items-center gap-2" draggable="true" data-type="paragraph">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4z"></path></svg>
                        <p class="font-semibold text-orange-600 text-sm">Paragraph</p>
                    </div>
                </div>

                <h3 class="text-xl font-semibold mb-4 text-gray-700">Canvas</h3>
                <div id="canvas" class="grid grid-cols-2 gap-4 p-6 bg-gray-50 border-2 border-dashed border-gray-400 rounded min-h-96">
                    <p class="col-span-2 text-gray-400 text-center">Drag blocks here to build your content</p>
                </div>

                <h3 class="text-xl font-semibold mt-6 mb-2 text-gray-700">Generated HTML</h3>
                <div class="bg-gray-900 rounded border border-gray-700 overflow-hidden shadow-lg">
                    <div class="bg-gray-800 px-4 py-2 border-b border-gray-700 flex items-center justify-between">
                        <span class="text-gray-400 text-sm font-mono">index.html</span>
                        <button id="copy-btn" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded">Copy</button>
                    </div>
                    <pre class="p-4 overflow-auto max-h-96"><code id="html-output" class="text-green-400 font-mono text-sm leading-relaxed"></code></pre>
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
            const block = createBlock(type);
            canvas.appendChild(block);
            updateHtmlOutput();
        }

        function createBlock(type) {
            const div = document.createElement('div');
            div.className = 'canvas-block p-4 bg-gray-100 border border-gray-300 relative group';
            div.innerHTML = `<button class="delete-btn absolute top-1 right-1 hidden group-hover:block bg-red-500 text-white px-2 py-1 rounded text-sm">×</button>`;

            if (type === 'button') {
                div.innerHTML += '<button class="px-4 py-2 bg-blue-500 text-white rounded">Button</button>';
            } else if (type === 'text') {
                div.innerHTML += '<p class="text-gray-700">Text Block</p>';
            } else if (type === 'image') {
                div.innerHTML += '<img src="https://via.placeholder.com/300" alt="Image" class="max-w-full">';
            } else if (type === 'paragraph') {
                div.innerHTML += '<p class="text-gray-600">Paragraph content goes here...</p>';
            }

            div.querySelector('.delete-btn').addEventListener('click', function() {
                div.remove();
                updateHtmlOutput();
            });

            return div;
        }

    });
</script>
