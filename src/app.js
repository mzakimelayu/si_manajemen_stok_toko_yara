let sidebarState = localStorage.getItem('sidebarState') || 'expanded';
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');
const adminTitle = document.getElementById('adminTitle');
const mainContainer = document.getElementById('mainContainer');

function updateMainContentMargin() {
    if (window.innerWidth >= 768) {
        mainContainer.style.marginLeft = sidebar.classList.contains('sidebar-expanded') ? '256px' : '100px';
    } else {
        mainContainer.style.marginLeft = '0';
    }
}

function initSidebar() {
    if (sidebarState === 'collapsed') {
        sidebar.classList.remove('sidebar-expanded');
        sidebar.classList.add('sidebar-collapsed');
        adminTitle.textContent = 'A';
    }
    if (window.innerWidth < 768) {
        sidebar.classList.add('-translate-x-full');
    }
    updateMainContentMargin();
}

function toggleSidebar() {
    if (sidebar.classList.contains('sidebar-expanded')) {
        sidebar.classList.remove('sidebar-expanded');
        sidebar.classList.add('sidebar-collapsed');
        adminTitle.textContent = 'A';
        sidebarState = 'collapsed';
    } else {
        sidebar.classList.remove('sidebar-collapsed');
        sidebar.classList.add('sidebar-expanded');
        adminTitle.textContent = 'Admin Panel';
        sidebarState = 'expanded';
    }
    localStorage.setItem('sidebarState', sidebarState);
    updateMainContentMargin();
}

function toggleSidebarMobile() {
    sidebar.classList.toggle('-translate-x-full');
    sidebarOverlay.classList.toggle('active');
    updateMainContentMargin();
}

function closeSidebarMobile() {
    sidebar.classList.add('-translate-x-full');
    sidebarOverlay.classList.remove('active');
    updateMainContentMargin();
}

document.getElementById('menuBtn').addEventListener('click', toggleSidebarMobile);
document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);

window.addEventListener('resize', function() {
    if (window.innerWidth >= 768) {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('active');
    } else {
        sidebar.classList.add('-translate-x-full');
    }
    updateMainContentMargin();
});

document.addEventListener('DOMContentLoaded', initSidebar);

    // Enhanced Profile Menu with Click Outside
    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        menu.classList.toggle('hidden');
        
        // Close menu when clicking outside
        const closeMenu = (e) => {
            if (!menu.contains(e.target) && !e.target.closest('button')) {
                menu.classList.add('hidden');
                document.removeEventListener('click', closeMenu);
            }
        };
        
        if (!menu.classList.contains('hidden')) {
            setTimeout(() => {
                document.addEventListener('click', closeMenu);
            }, 0);
        }
    }

    // Enhanced Submenu Toggle
    function toggleSubmenu(submenuId) {
        const submenu = document.getElementById(submenuId);
        const arrow = document.getElementById(submenuId + 'Arrow');
        const isHidden = submenu.classList.contains('hidden');
        
        if (isHidden) {
            submenu.classList.remove('hidden');
            requestAnimationFrame(() => {
                submenu.style.maxHeight = submenu.scrollHeight + 'px';
                arrow.style.transform = 'rotate(180deg)';
            });
        } else {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
            requestAnimationFrame(() => {
                submenu.style.maxHeight = '0px';
                arrow.style.transform = 'rotate(0deg)';
            });
            submenu.addEventListener('transitionend', () => {
                if (!isHidden) {
                    submenu.classList.add('hidden');
                }
            }, { once: true });
        }
    }

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth < 768) {
            mainContent.style.marginLeft = '0';
        } else {
            mainContent.style.marginLeft = isSidebarExpanded ? '256px' : '70px';
        }
    });