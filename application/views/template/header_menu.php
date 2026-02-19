<header>
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-700"></h1>
        <button id="menu-toggle" class="menu-toggle-btn p-2 rounded hover:bg-gray-200 transition-colors" title="Toggle Menu">
            <svg id="menu-icon" class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="close-icon" class="w-6 h-6 text-gray-700 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
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
    
    // Check if menu is hidden in localStorage
    const isMenuHidden = localStorage.getItem('menuHidden') === 'true';
    if (isMenuHidden) {
        menuSidebar.classList.add('hidden');
        menuIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    }
    
    // Toggle menu visibility
    menuToggle.addEventListener('click', function() {
        menuSidebar.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
        
        // Save preference to localStorage
        const isHidden = menuSidebar.classList.contains('hidden');
        localStorage.setItem('menuHidden', isHidden);
    });
    
    // Auto-hide menu on tablet and phone
    function handleResponsive() {
        const isSmallScreen = window.innerWidth < 1024; // tablet breakpoint
        const menuOverlay = document.getElementById('menu-overlay');
        
        if (isSmallScreen) {
            // On mobile/tablet, use modal behavior
            menuSidebar.classList.add('menu-modal');
            if (isMenuHidden) {
                menuSidebar.classList.add('hidden');
            }
        } else {
            // On desktop, show as sidebar
            menuSidebar.classList.remove('menu-modal');
            menuSidebar.classList.remove('hidden');
            menuIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            menuOverlay.classList.add('hidden');
            localStorage.setItem('menuHidden', 'false');
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
