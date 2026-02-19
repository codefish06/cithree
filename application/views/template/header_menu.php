<header>
    <div class="flex items-center">
        <button id="menu-toggle" class="menu-toggle-btn p-2 rounded hover:bg-gray-200 transition-colors" title="Toggle Menu">
            <svg id="menu-icon" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="close-icon" class="w-6 h-6 text-gray-700 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <h1 class="text-2xl font-bold text-gray-700 flex items-center gap-3">
            <svg role="img" aria-labelledby="coalLogoTitle" class="w-8 h-8" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <title id="coalLogoTitle">Coal - cola can logo</title>
                <defs>
                    <linearGradient id="canGrad" x1="0" x2="1" y1="0" y2="1">
                        <stop offset="0%" stop-color="#E53935"/>
                        <stop offset="100%" stop-color="#B71C1C"/>
                    </linearGradient>
                </defs>
                <rect x="10" y="6" width="44" height="52" rx="6" fill="url(#canGrad)" stroke="#7f1d1d" stroke-width="1"/>
                <rect x="18" y="12" width="28" height="6" rx="3" fill="#fff" opacity="0.12"/>
                <path d="M16 20c0 8 0 24 0 24h32s0-16 0-24c0-8-32-8-32 0z" fill="rgba(255,255,255,0.06)"/>
                <text x="32" y="38" font-family="Inter, Arial, sans-serif" font-size="10" fill="#fff" text-anchor="middle" font-weight="700">Coal</text>
            </svg>
            <span><?php echo defined('APP_NAME') ? APP_NAME : 'Coal'; ?></span>
        </h1>
        
    </div>
</header>

<!-- Menu overlay for tablet/mobile -->
<div id="menu-overlay" class="menu-overlay hidden"></div>

<aside id="menu-sidebar" class="menu-sidebar">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Navigation</h2>
    <ul class="space-y-2">
        <li><a href="/" class="text-blue-600 hover:text-orange-700">Home</a></li>
        <li>
            <a href="/vendor" class="text-blue-600 hover:text-orange-700 flex items-center">Vendor</a>
            <ul class="ml-6 mt-2 space-y-1 border-l-2 border-gray-300 pl-3">
                <li><a href="/vendor/select2" class="text-blue-600 hover:text-orange-700 flex items-center text-sm">Select2</a></li>
            </ul>
        </li>
    </ul>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const menuSidebar = document.getElementById('menu-sidebar');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    const gridContainer = document.querySelector('.grid-container');
    
    // Check if menu is hidden in localStorage
    const isMenuHidden = localStorage.getItem('menuHidden') === 'true';
    if (isMenuHidden) {
        menuSidebar.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        if (gridContainer) gridContainer.classList.add('menu-collapsed');
    } else {
        if (gridContainer) gridContainer.classList.remove('menu-collapsed');
    }
    
    // Toggle menu visibility
    menuToggle.addEventListener('click', function() {
        menuSidebar.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        // On desktop, make main occupy remaining space when menu hidden
        if (gridContainer && window.innerWidth >= 1024) {
            const isHidden = menuSidebar.classList.contains('hidden');
            gridContainer.classList.toggle('menu-collapsed', isHidden);
        }

        // Save preference to localStorage
        const isHidden = menuSidebar.classList.contains('hidden');
        localStorage.setItem('menuHidden', isHidden);
    });
    
    // Auto-hide menu on tablet and phone
    function handleResponsive() {
        const isSmallScreen = window.innerWidth < 1024; // tablet breakpoint
        const menuOverlay = document.getElementById('menu-overlay');
        
        if (isSmallScreen) {
            // On mobile/tablet, use modal behavior and ensure menu is hidden
            menuSidebar.classList.add('menu-modal');
            menuSidebar.classList.add('hidden');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            menuOverlay.classList.add('hidden');
            if (gridContainer) gridContainer.classList.remove('menu-collapsed');
            localStorage.setItem('menuHidden', 'true');
        } else {
            // On desktop, restore sidebar state from localStorage
            menuSidebar.classList.remove('menu-modal');
            const storedHidden = localStorage.getItem('menuHidden') === 'true';
            if (storedHidden) {
                menuSidebar.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                if (gridContainer) gridContainer.classList.add('menu-collapsed');
            } else {
                menuSidebar.classList.remove('hidden');
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                if (gridContainer) gridContainer.classList.remove('menu-collapsed');
            }
            menuOverlay.classList.add('hidden');
        }
    }
    
    // Close menu when overlay is clicked
    const menuOverlay = document.getElementById('menu-overlay');
    menuOverlay.addEventListener('click', function() {
        menuSidebar.classList.add('hidden');
        menuIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
        menuOverlay.classList.add('hidden');
        localStorage.setItem('menuHidden', 'true');
    });
    
    // Update overlay state when menu is toggled
    const originalToggle = menuToggle.onclick;
    menuToggle.addEventListener('click', function() {
        const isHidden = menuSidebar.classList.contains('hidden');
        if (!isHidden && window.innerWidth < 1024) {
            menuOverlay.classList.remove('hidden');
        } else if (isHidden && window.innerWidth < 1024) {
            menuOverlay.classList.add('hidden');
        }
    });
    
    // Update overlay visibility on first load
    if (!isMenuHidden && window.innerWidth < 1024) {
        menuOverlay.classList.remove('hidden');
    }
    
    // Initial check
    handleResponsive();
    
    // Listen for window resize
    window.addEventListener('resize', handleResponsive);
});
</script>
