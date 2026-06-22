<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IskoLib - Admin Panel</title>
    <style>
        /* Base Page Configurations */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #1C1C1C;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
        }

        /* Core Layout Architecture */
        .layout-container {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* Sidebar Containers */
        .sidebar {
            display: flex;
            flex-direction: column;
            width: 288px; /* equivalent to Tailwind w-72 */
            height: 100%;
            background-color: #2E3A14; /* Mockup Brand Green */
            color: #FFFFFF;
            user-select: none;
            flex-shrink: 0;
            border-right: 1px solid rgba(62, 76, 28, 0.4);
        }

        /* Header Section Styles */
        .sidebar-header {
            padding: 24px;
        }
        .brand-logo-container {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .brand-logo-container i {
            color: #FF5722; /* Mockup Accent Orange */
            font-size: 1.5rem;
        }
        .brand-title {
            font-family: Georgia, Cambria, "Times New Roman", Times, serif;
            font-size: 1.875rem;
            font-weight: 700;
            letter-spacing: -0.05em;
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
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #A4C439;
            font-weight: 600;
            opacity: 0.9;
        }
        .divider {
            margin-top: 20px;
            border: 0;
            border-top: 1px solid rgba(62, 76, 28, 0.6);
        }

        /* Navigation List Styles */
        .sidebar-nav {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 14px 16px;
            font-size: 15px;
            font-weight: 500;
            border-radius: 9999px; /* full capsule shape */
            color: #D1D5DB;
            transition: background-color 0.2s ease, color 0.2s ease;
            cursor: pointer;
            margin-bottom: 4px;
        }
        .nav-item i {
            font-size: 1.125rem;
            color: #9CA3AF;
            transition: color 0.2s ease;
        }
        
        /* Interactive Hovers (Non-active items) */
        .nav-item:hover {
            background-color: #3E4C1C;
            color: #FFFFFF;
        }
        .nav-item:hover i {
            color: #FFFFFF;
        }

        /* Active State (Overview active - matching image_62e1e4.png) */
        .nav-item.active {
            background-color: #FF5722;
            color: #FFFFFF;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .nav-item.active i {
            color: #FFFFFF;
        }

        /* Bottom Action Footer Styles */
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #3E4C1C;
        }
        .btn-signout:hover {
            background-color: rgba(127, 29, 29, 0.4);
            color: #F87171;
        }
        .btn-signout:hover i {
            color: #F87171;
        }

        /* Main Dashboard Window Content Canvas */
        .main-canvas {
            flex: 1;
            background-color: #F9F6F0; /* Off-white canvas tone */
            overflow-y: auto;
            padding: 32px;
        }
        .main-canvas h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1F2937;
        }
    </style>
</head>
<body>

    <!-- Main Layout Container -->
    <div class="layout-container">
        
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            
            <!-- Brand / Header Section -->
            <div class="sidebar-header">
                <div class="brand-logo-container">
                    <i class="bi bi-book-fill"></i>
                    <span class="brand-title">IskoLib</span>
                </div>
                <div class="admin-status">
                    <span class="status-dot"></span>
                    <span class="status-text">Admin Panel</span>
                </div>
                <hr class="divider">
            </div>

            <!-- Navigation Tabs (Layout mirroring image_62e1e4.png) -->
            <nav class="sidebar-nav">
                
                <!-- Overview Tab (Active Highlighted Capsule) -->
                <div class="nav-item active">
                    <i class="bi bi-grid-fill"></i>
                    <span>Overview</span>
                </div>

                <!-- Book Catalog Tab -->
                <div class="nav-item">
                    <i class="bi bi-book-half"></i>
                    <span>Book Catalog</span>
                </div>

                <!-- Categories Tab -->
                <div class="nav-item">
                    <i class="bi bi-tags-fill"></i>
                    <span>Categories</span>
                </div>

                <!-- Members Tab -->
                <div class="nav-item">
                    <i class="bi bi-people-fill"></i>
                    <span>Members</span>
                </div>

                <!-- Borrow Requests Tab -->
                <div class="nav-item">
                    <i class="bi bi-file-earmark-arrow-up-fill"></i>
                    <span>Borrow Requests</span>
                </div>

                <!-- Reservation Requests Tab -->
                <div class="nav-item">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span>Reservation Requests</span>
                </div>

                <!-- Book Returns Tab -->
                <div class="nav-item">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    <span>Book Returns</span>
                </div>

                <!-- Penalties Tab -->
                <div class="nav-item">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span>Penalties</span>
                </div>

                <!-- Reports Tab -->
                <div class="nav-item">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Reports</span>
                </div>

            </nav>

            <!-- Bottom Action Footer (Settings / Sign Out) -->
            <div class="sidebar-footer">
                
                <!-- Settings Button -->
                <div class="nav-item">
                    <i class="bi bi-gear-fill"></i>
                    <span>Settings</span>
                </div>

                <!-- Sign Out Button -->
                <div class="nav-item btn-signout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Sign Out</span>
                </div>

            </div>
        </aside>

        <!-- Main Workspace Area / Dashboard Content Canvas -->
        <main class="main-canvas">
            <h1>Dashboard Canvas Area</h1>
        </main>

    </div>

</body>
</html>