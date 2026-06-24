 <aside class="sidebar">
            <div class="sidebar-header">
                <div class="brand-logo-container">
                    <img src="{{ asset('AdminAssets/SidebarAssets/logoIcon.svg') }}" alt="IskoLib Logo" class="brand-logo" width="32" height="32">
                    <span class="brand-title">IskoLib</span>
                </div>
                <div class="admin-status">
                    <span class="status-dot"></span>
                    <span class="status-text">Admin Panel</span>
                </div>
                <hr class="divider">
            </div>

            <nav class="sidebar-nav">
                <div class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/overviewIcon.svg') }}" alt="Overview Icon" class="sidebar-svg-icon">
                    <span>Overview</span>
                </div>

                <div class="nav-item {{ request()->is('admin/catalog*') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/catalogIcon.svg') }}" alt="Book Catalog Icon" class="sidebar-svg-icon">
                    <span>Book Catalog</span>
                </div>

                <div class="nav-item {{ request()->is('admin/categories*', 'admin/add-book*', 'admin/edit-book*' ) ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/categoryIcon.svg') }}" alt="Categories Icon" class="sidebar-svg-icon">
                    <span>Categories</span>
                </div>

                <div class="nav-item {{ request()->is('admin/members*') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/memberIcon.svg') }}" alt="Members Icon" class="sidebar-svg-icon">
                    <span>Members</span>
                </div>

                <div class="nav-item {{ request()->is('admin/borrow*') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/borrowIcon.svg') }}" alt="Borrow Requests Icon" class="sidebar-svg-icon">
                    <span>Borrow Requests</span>
                </div>

                <div class="nav-item {{ request()->is('admin/reservation*') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/reservationIcon.svg') }}" alt="Reservation Requests Icon" class="sidebar-svg-icon">
                    <span>Reservation Requests</span>
                </div>

                <div class="nav-item {{ request()->is('admin/returns*') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/returnIcon.svg') }}" alt="Book Returns Icon" class="sidebar-svg-icon">
                    <span>Book Returns</span>
                </div>

                <div class="nav-item {{ request()->is('admin/penalties*') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/penaltyIcon.svg') }}" alt="Penalties Icon" class="sidebar-svg-icon">
                    <span>Penalties</span>
                </div>

                <div class="nav-item {{ request()->is('admin/reports*') ? 'active' : '' }}">
                    <img src="{{ asset('AdminAssets/SidebarAssets/reportIcon.svg') }}" alt="Reports Icon" class="sidebar-svg-icon">
                    <span>Reports</span>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="nav-item">
                    <img src="{{ asset('AdminAssets/SidebarAssets/settingIcon.svg') }}" alt="Settings Icon" class="sidebar-svg-icon">
                    <span>Settings</span>
                </div>
                <div class="nav-item btn-signout">
                    <img src="{{ asset('AdminAssets/SidebarAssets/signoutIcon.svg') }}" alt="Sign Out Icon" class="sidebar-svg-icon">
                    <span>Sign Out</span>
                </div>
            </div>
        </aside>

<style>
    /* Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        width: 288px;
        height: 100%;
        background-color: #2E3A14;
        color: #FFFFFF;
        user-select: none;
        flex-shrink: 0;
        border-right: 1px solid rgba(62, 76, 28, 0.4);
    }
    .sidebar-header {
        padding: 24px; 
    }
    .brand-logo-container { 
        display: flex; 
        align-items: center; 
        gap: 12px;
    }
    .brand-title { 
        font-family: 'Fraunces', Georgia, Cambria, serif; 
        font-size: 1.875rem; 
        font-weight: 700; 
        letter-spacing: -0.03em;
    }
    .admin-status {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
        padding-left: 2px;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        background-color: #A4C439;
        border-radius: 50%;
    }
    .status-text {
        font-size: 0.725rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #A4C439;
        font-weight: 700;
        opacity: 0.9;
    }
    .divider {
        margin-top: 20px;
        border: 0;
        border-top: 1px solid rgba(62, 76, 28, 0.6);
    }

    .sidebar-nav {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
    }
    .nav-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 9999px;
        color: #D1D5DB;
        transition: background-color 0.15s ease, color 0.15s ease;
        cursor: pointer;
        margin-bottom: 4px;
    }
    .sidebar-svg-icon {
        width: 20px;
        height: 20px;
        flex-shrink: 0;
    }
    .nav-item:hover {
        background-color: #3E4C1C;
        color: #FFFFFF;
    }
    .nav-item.active {
        background-color: #FF5722;
        color: #FFFFFF;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .sidebar-footer {
        padding: 16px;
        border-top: 1px solid rgba(62, 76, 28, 0.6);
    }
    .btn-signout:hover {
        background-color: rgba(220, 38, 38, 0.2);
        color: #F87171;
    }
</style>