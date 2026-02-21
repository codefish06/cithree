<header>
    <div class="header-row">
        <button id="menu-toggle" class="menu-toggle-btn" title="Toggle Menu">
            <svg id="menu-icon" class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="close-icon" class="menu-icon is-hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>
        <h1 class="brand-title">
            <svg role="img" aria-labelledby="coalLogoTitle" class="brand-icon" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <title id="coalLogoTitle">Coal - charcoal logo</title>
                <defs>
                    <radialGradient id="charcoalGrad" cx="40%" cy="40%">
                        <stop offset="0%" stop-color="#4B5563"/>
                        <stop offset="100%" stop-color="#1F2937"/>
                    </radialGradient>
                </defs>
                <circle cx="20" cy="20" r="8" fill="url(#charcoalGrad)" stroke="#111827" stroke-width="0.5"/>
                <circle cx="42" cy="18" r="7" fill="url(#charcoalGrad)" opacity="0.9" stroke="#111827" stroke-width="0.5"/>
                <circle cx="32" cy="38" r="9" fill="url(#charcoalGrad)" stroke="#111827" stroke-width="0.5"/>
                <circle cx="52" cy="36" r="6" fill="url(#charcoalGrad)" opacity="0.85" stroke="#111827" stroke-width="0.5"/>
            </svg>
            <span><?php echo defined('APP_NAME') ? APP_NAME : 'Coal'; ?></span>
        </h1>
        
    </div>
</header>

<!-- Menu overlay for tablet/mobile -->
<div id="menu-overlay" class="menu-overlay is-hidden"></div>

<aside id="menu-sidebar" class="menu-sidebar" aria-label="Sidebar">
    <div class="sidebar-inner">
        <nav>
            <ul class="sidebar-list">
                <li>
                    <a href="/" class="sidebar-link">
                        <span>Home</span>
                    </a>
                </li>

                <li>
                    <button class="sidebar-button submenu-toggle" aria-expanded="false" data-target="submenu-vendor">
                        <span class="sidebar-button-label">
                            <span>Vendor</span>
                        </span>
                        <svg class="chevron-icon" data-chevron viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 8l4 4 4-4"/></svg>
                    </button>
                    <ul id="submenu-vendor" class="sidebar-submenu is-hidden">
                        <li>
                            <a href="/vendor" class="sidebar-sublink">All</a>
                        <li>
                            <a href="/vendor/select2" class="sidebar-sublink">Select2</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="/appearance" class="sidebar-link">
                        <span>Appearance</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
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
        menuSidebar.classList.add('is-hidden');
        menuIcon.classList.remove('is-hidden');
        closeIcon.classList.add('is-hidden');
        if (gridContainer) gridContainer.classList.add('menu-collapsed');
    } else {
        if (gridContainer) gridContainer.classList.remove('menu-collapsed');
    }
    
    // Toggle menu visibility
    menuToggle.addEventListener('click', function() {
        menuSidebar.classList.toggle('is-hidden');
        menuIcon.classList.toggle('is-hidden');
        closeIcon.classList.toggle('is-hidden');

        // On desktop, make main occupy remaining space when menu hidden
        if (gridContainer && window.innerWidth >= 1024) {
            const isHidden = menuSidebar.classList.contains('is-hidden');
            gridContainer.classList.toggle('menu-collapsed', isHidden);
        }

        // Save preference to localStorage
        const isHidden = menuSidebar.classList.contains('is-hidden');
        localStorage.setItem('menuHidden', isHidden);
    });

    // Submenu toggle handling for multi-level sidebar
    function setupSubmenus() {
        const toggles = document.querySelectorAll('.submenu-toggle');
        toggles.forEach(btn => {
            const targetId = btn.getAttribute('data-target');
            const submenu = document.getElementById(targetId);
            const chevron = btn.querySelector('[data-chevron]');
            // Ensure initial aria state
            btn.setAttribute('aria-expanded', 'false');

            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const isOpen = !submenu.classList.contains('is-hidden');
                submenu.classList.toggle('is-hidden');
                btn.setAttribute('aria-expanded', String(!isOpen));
                if (chevron) chevron.style.transform = !isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
            });
        });
    }

    setupSubmenus();
    
    // Auto-hide menu on tablet and phone
    function handleResponsive() {
        const isSmallScreen = window.innerWidth < 1024; // tablet breakpoint
        const menuOverlay = document.getElementById('menu-overlay');
        
        if (isSmallScreen) {
            // On mobile/tablet, use modal behavior and ensure menu is hidden
            menuSidebar.classList.add('menu-modal');
            menuSidebar.classList.add('is-hidden');
            menuIcon.classList.remove('is-hidden');
            closeIcon.classList.add('is-hidden');
            menuOverlay.classList.add('is-hidden');
            if (gridContainer) gridContainer.classList.remove('menu-collapsed');
            localStorage.setItem('menuHidden', 'true');
        } else {
            // On desktop, restore sidebar state from localStorage
            menuSidebar.classList.remove('menu-modal');
            const storedHidden = localStorage.getItem('menuHidden') === 'true';
            if (storedHidden) {
                menuSidebar.classList.add('is-hidden');
                menuIcon.classList.remove('is-hidden');
                closeIcon.classList.add('is-hidden');
                if (gridContainer) gridContainer.classList.add('menu-collapsed');
            } else {
                menuSidebar.classList.remove('is-hidden');
                menuIcon.classList.add('is-hidden');
                closeIcon.classList.remove('is-hidden');
                if (gridContainer) gridContainer.classList.remove('menu-collapsed');
            }
            menuOverlay.classList.add('is-hidden');
        }
    }
    
    // Close menu when overlay is clicked
    const menuOverlay = document.getElementById('menu-overlay');
    menuOverlay.addEventListener('click', function() {
        menuSidebar.classList.add('is-hidden');
        menuIcon.classList.remove('is-hidden');
        closeIcon.classList.add('is-hidden');
        menuOverlay.classList.add('is-hidden');
        localStorage.setItem('menuHidden', 'true');
    });
    
    // Update overlay state when menu is toggled
    const originalToggle = menuToggle.onclick;
    menuToggle.addEventListener('click', function() {
        const isHidden = menuSidebar.classList.contains('is-hidden');
        if (!isHidden && window.innerWidth < 1024) {
            menuOverlay.classList.remove('is-hidden');
        } else if (isHidden && window.innerWidth < 1024) {
            menuOverlay.classList.add('is-hidden');
        }
    });
    
    // Update overlay visibility on first load
    if (!isMenuHidden && window.innerWidth < 1024) {
        menuOverlay.classList.remove('is-hidden');
    }
    
    // Initial check
    handleResponsive();
    
    // Listen for window resize
    window.addEventListener('resize', handleResponsive);
});
</script>
