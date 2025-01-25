<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar toggle
        const sidebarToggle = document.querySelector('.sidebar-toggle');
        const sidebar = document.querySelector('.main-sidebar');
        const contentWrapper = document.querySelector('.content-wrapper');
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            contentWrapper.classList.toggle('collapsed');
        });

        // User dropdown
        const userMenu = document.querySelector('.user-menu');
        const userDropdown = document.querySelector('.user-dropdown');

        userMenu.addEventListener('click', function(e) {
            e.preventDefault();
            userDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove('show');
            }
        });

        // Sidebar dropdown functionality
        const dropdownBtns = document.querySelectorAll('.sidebar-dropdown > a');
        
        dropdownBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Toggle active class
                const parentLi = this.parentElement;
                parentLi.classList.toggle('active');
                
                // Get submenu
                const submenu = this.nextElementSibling;
                
                // Toggle submenu
                if (submenu.style.maxHeight) {
                    submenu.style.maxHeight = null;
                } else {
                    // Close other open dropdowns
                    dropdownBtns.forEach(otherBtn => {
                        if (otherBtn !== btn) {
                            otherBtn.parentElement.classList.remove('active');
                            if (otherBtn.nextElementSibling.style.maxHeight) {
                                otherBtn.nextElementSibling.style.maxHeight = null;
                            }
                        }
                    });
                    
                    // Open this submenu
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                }

                // Rotate arrow icon
                const arrow = this.querySelector('.dropdown-icon');
                if (arrow) {
                    arrow.style.transform = parentLi.classList.contains('active') 
                        ? 'rotate(180deg)' 
                        : 'rotate(0)';
                }
            });
        });

        // Handle hover for collapsed state
        const dropdownItems = document.querySelectorAll('.sidebar-dropdown');
        
        dropdownItems.forEach(item => {
            item.addEventListener('mouseenter', function() {
                if (sidebar.classList.contains('collapsed')) {
                    const submenu = this.querySelector('.sidebar-submenu');
                    if (submenu) {
                        const rect = this.getBoundingClientRect();
                        submenu.style.top = rect.top + 'px';
                    }
                }
            });
        });
    });
</script>

