<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }

    .wrapper {
        display: flex;
    }

    .main-sidebar {
        width: 250px;
        background-color: white;
        color: #333;
        height: 100vh;
        position: fixed;
        transition: all 0.3s ease;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .main-sidebar.collapsed {
        width: 60px;
    }

    .main-sidebar.collapsed .sidebar-header,
    .main-sidebar.collapsed .sidebar-nav ul li a span {
        display: none;
    }

    .sidebar-header {
        padding: 20px;
        text-align: center;
        background-color: #ffd900;
    }

    /* Logo Container Styling */
    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo-container img {
        max-width: 80%;
        height: auto;
    }

    .sidebar-nav {
        background-color: white;
    }

    .sidebar-nav ul {
        list-style-type: none;
    }

    .sidebar-nav ul li {
        padding: 10px 20px;
    }

    .sidebar-nav ul li a {
        color: #333;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .sidebar-nav ul li a i {
        margin-right: 10px;
    }

    .sidebar-nav ul li.active {
        background-color: #f0f0f0;
    }

    .sidebar-nav ul li a:hover {
        background-color: #f4f4f4;
    }

    .sidebar-footer {
        position: fixed;
        bottom: 0;
        width: 250px;
        padding: 20px;
        background-color: white;
        transition: all 0.3s ease;
    }

    .main-sidebar.collapsed .sidebar-footer {
        width: 60px;
    }

    .footer-logo {
        width: 100%;
        height: auto;
        filter: blur(1px);
        transition: all 0.3s ease;
    }

    .main-sidebar.collapsed .footer-logo {
        width: 40px;
    }

    .content-wrapper {
        flex: 1;
        margin-left: 250px;
        transition: all 0.3s ease;
    }

    .content-wrapper.collapsed {
        margin-left: 60px;
    }

    .main-header {
        background-color: #ffd700;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .navbar-left {
        display: flex;
        align-items: center;
    }

    .sidebar-toggle {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        margin-right: 15px;
        color: #333;
    }

    .navbar-left input {
        padding: 5px 10px;
        border: 1px solid #e6c200;
        border-radius: 4px;
        background-color: #fff;
    }

    .navbar-right {
        position: relative;
    }

    .navbar-right .nav-link {
        color: #333;
        text-decoration: none;
        margin-left: 15px;
        font-size: 20px;
    }

    .user-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background-color: #fff;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        min-width: 150px;
        display: none;
        z-index: 1000;
    }

    .user-dropdown.show {
        display: block;
    }

    .user-dropdown a {
        display: block;
        padding: 10px 15px;
        color: #333;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .user-dropdown a:hover {
        background-color: #f8f9fa;
    }

    .user-dropdown a i {
        margin-right: 8px;
    }

    .user-dropdown hr {
        margin: 5px 0;
        border: none;
        border-top: 1px solid #eee;
    }

    .content {
        padding: 20px;
    }

    .info-boxes {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .info-box {
        background-color: #fff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        flex: 1;
        margin-right: 15px;
        display: flex;
        align-items: center;
    }

    .info-box:last-child {
        margin-right: 0;
    }

    .info-box i {
        font-size: 40px;
        margin-right: 15px;
        color: #ffd700;
    }

    .chart-container {
        background-color: #fff;
        padding: 20px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }

    .chart-placeholder {
        width: 100%;
        height: 300px;
        background-color: #f8f9fa;
        border: 1px dashed #ddd;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        color: #999;
    }

    .chart-placeholder::after {
        content: 'Chart Placeholder';
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .main-sidebar {
            width: 60px;
        }

        .sidebar-header, .sidebar-nav ul li a span {
            display: none;
        }

        .content-wrapper {
            margin-left: 60px;
        }

        .info-boxes {
            flex-direction: column;
        }

        .info-box {
            margin-right: 0;
            margin-bottom: 15px;
        }

        .sidebar-footer {
            width: 60px;
        }

        .footer-logo {
            width: 40px;
        }
    }

    /* Add these new styles for the dropdown */
    .sidebar-dropdown > a {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dropdown-icon {
        transition: transform 0.3s ease;
        font-size: 1.2em;
    }

    .sidebar-dropdown.active > a .dropdown-icon {
        transform: rotate(180deg);
    }

    .sidebar-submenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
        background-color: #f8f9fa;
    }

    .sidebar-submenu li {
        padding: 8px 10px 8px 45px !important;
    }

    .sidebar-submenu li a {
        font-size: 0.9em;
        color: #555;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .sidebar-submenu li a:hover {
        opacity: 1;
        color: #333;
        background-color: transparent;
    }

    /* Handling collapsed state */
    .main-sidebar.collapsed .sidebar-submenu {
        position: absolute;
        left: 100%;
        top: 0;
        width: 200px;
        margin-top: 0;
        padding: 10px 0;
        border-radius: 0 4px 4px 0;
        background: white;
        box-shadow: 4px 0 5px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .main-sidebar.collapsed .sidebar-dropdown:hover .sidebar-submenu {
        opacity: 1;
        visibility: visible;
    }

    .main-sidebar.collapsed .sidebar-submenu li {
        padding: 8px 20px !important;
    }

    /* Active state styling */
    .sidebar-nav ul li.sidebar-dropdown.active {
        background-color: #f0f0f0;
    }

    .sidebar-nav ul li.sidebar-dropdown.active > a {
        color: #000;
        font-weight: 500;
    }

    .sidebar-submenu li.active a {
        color: #000;
        font-weight: 500;
    }

    /* Hover effects */
    .sidebar-nav ul li.sidebar-dropdown:hover {
        background-color: #f4f4f4;
    }

    .sidebar-submenu li:hover {
        background-color: #f0f0f0;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-sidebar.collapsed .sidebar-submenu {
            position: fixed;
            left: 60px;
            top: auto;
            z-index: 1000;
        }
    }
</style>