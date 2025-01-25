document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const contentWrapper = document.querySelector('.content-wrapper');
    
    // Toggle sidebar
    toggleButton.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        contentWrapper.classList.toggle('collapsed');
        
        // Save state
        localStorage.setItem('sidebarState', sidebar.classList.contains('collapsed'));
    });
    
    // Restore sidebar state on page load
    const sidebarState = localStorage.getItem('sidebarState');
    if (sidebarState === 'true') {
        sidebar.classList.add('collapsed');
        contentWrapper.classList.add('collapsed');
    }

    // New dropdown functionality
    const dropdownBtns = document.querySelectorAll('.sidebar-dropdown > a');
    
    dropdownBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Toggle active class on the button
            this.classList.toggle('active');
            
            // Get the submenu
            const submenu = this.nextElementSibling;
            
            // If submenu is already open, close it
            if (submenu.style.maxHeight) {
                submenu.style.maxHeight = null;
            } else {
                // Close other open submenus
                dropdownBtns.forEach(otherBtn => {
                    if (otherBtn !== btn) {
                        otherBtn.classList.remove('active');
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
                arrow.style.transform = this.classList.contains('active') 
                    ? 'rotate(180deg)' 
                    : 'rotate(0)';
            }
        });
    });
});