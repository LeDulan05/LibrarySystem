<aside class="sidebar">
    <div class="sidebar-header">
        <div class="brand-logo-container">
            <img src="{{ asset('AdminAssets/SidebarAssets/logoIcon.svg') }}" alt="IskoLib Logo" class="brand-logo" width="32" height="32">
            <span class="brand-title">IskoLib</span>
        </div>
        <div class="student-status">
            <span class="status-dot"></span>
            <span class="status-text">STUDENT PORTAL</span>
        </div>
        <hr class="divider">
    </div>

    <nav class="sidebar-nav">
        <div class="nav-item active">
            <i class="bi bi-grid sidebar-icon"></i>
            <span>Overview</span>
        </div>

        <div class="nav-item">
            <i class="bi bi-book sidebar-icon"></i>
            <span>Library</span>
        </div>

        <div class="nav-item">
            <i class="bi bi-journal-text sidebar-icon"></i>
            <span>Borrowed</span>
        </div>

        <div class="nav-item">
            <i class="bi bi-calendar-event sidebar-icon"></i>
            <span>Reservations</span>
        </div>

        <div class="nav-item">
            <i class="bi bi-exclamation-circle sidebar-icon"></i>
            <span>Penalties</span>
        </div>
    </nav>

    <div class="sidebar-footer">
        <div class="nav-item">
            <i class="bi bi-gear sidebar-icon"></i>
            <span>Settings</span>
        </div>
        <div class="nav-item btn-signout">
            <i class="bi bi-box-arrow-right sidebar-icon"></i>
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
        background-color: #212B05;
        color: #FFFFFF;
        user-select: none;
        flex-shrink: 0;
        border-right: 1px solid rgba(62, 76, 28, 0.4);
    }
    .sidebar-header {
        padding: 32px 24px 24px 24px; 
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
        color: #F8F4EC;
    }
    .student-status {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        padding-left: 2px;
    }
    .status-dot {
        width: 8px;
        height: 8px;
        background-color: #D4E157;
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
        margin-top: 24px;
        border: 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
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
        padding: 14px 20px;
        font-size: 14px;
        font-weight: 600;
        border-radius: 9999px;
        color: #D1D5DB;
        transition: background-color 0.15s ease, color 0.15s ease;
        cursor: pointer;
        margin-bottom: 6px;
    }
    .sidebar-icon {
        font-size: 18px;
        flex-shrink: 0;
    }
    .nav-item:hover {
        background-color: rgba(255, 255, 255, 0.05);
        color: #FFFFFF;
    }
    .nav-item.active {
        background-color: #FF6B2C;
        color: #FFFFFF;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }
    .sidebar-footer {
        padding: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    .btn-signout:hover {
        background-color: rgba(220, 38, 38, 0.2);
        color: #F87171;
    }
</style>
