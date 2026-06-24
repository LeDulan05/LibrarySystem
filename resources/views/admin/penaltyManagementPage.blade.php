<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts Imports for IskoLib Design System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <title>IskoLib - Penalty Management</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Penalty Management</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalPenaltiesIcon.svg') }}" alt="Total Outstanding" class="icon-wrapper">
                        <div class="sum-value">₱75.00</div>
                        <div class="sum-label">Total Outstanding</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/BorrowAssets/approvedTodayIcon.svg') }}" alt="Collected This Month" class="icon-wrapper">
                        <div class="sum-value">₱245.00</div>
                        <div class="sum-label">Collected This Month</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/PenaltyAssets/activePenaltiesIcon.svg') }}" alt="Active Penalties" class="icon-wrapper">
                        <div class="sum-value">2</div>
                        <div class="sum-label">Active Penalties</div>
                    </div>
                </div>

                <div class="member-search-container">
                    <div class="search-box-wrapper">
                        <i class="bi bi-search search-icon-inside"></i>
                        <input type="text" class="search-input" placeholder="Search penalties...">
                    </div>
                </div>

                <div class="queue-panel">
                    
                    <div class="table-responsive-wrapper">
                        <table class="queue-data-table">
                            <thead>
                                <tr>
                                    <th>PENALTY ID</th>
                                    <th>MEMBER</th>
                                    <th>STUDENT NO.</th>
                                    <th>BOOK</th>
                                    <th style="text-align: center;">DAYS LATE</th>
                                    <th>AMOUNT</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                    <th style="width: 80px; text-align: center;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="mono-text">PEN-2024-001</td>
                                    <td class="member-name-text">Juan dela Cruz</td>
                                    <td class="mono-text">2024-00001</td>
                                    <td class="book-title-text">Database Concepts</td>
                                    <td class="days-late-text" style="text-align: center;">5</td>
                                    <td class="penalty-text penalty-active">₱25.00</td>
                                    <td class="date-text">Nov 15, 2024</td>
                                    <td><span class="status-badge badge-success">Paid</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn-view"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mono-text">PEN-2024-002</td>
                                    <td class="member-name-text">Ana Lim</td>
                                    <td class="mono-text">2022-00134</td>
                                    <td class="book-title-text">Research Methodol...</td>
                                    <td class="days-late-text" style="text-align: center;">12</td>
                                    <td class="penalty-text penalty-active">₱60.00</td>
                                    <td class="date-text">Dec 8, 2024</td>
                                    <td><span class="status-badge badge-due">Unpaid</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn-view"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mono-text">PEN-2024-003</td>
                                    <td class="member-name-text">Carlos Cruz</td>
                                    <td class="mono-text">2023-00089</td>
                                    <td class="book-title-text">Cybersecurity</td>
                                    <td class="days-late-text" style="text-align: center;">3</td>
                                    <td class="penalty-text penalty-active">₱15.00</td>
                                    <td class="date-text">Dec 1, 2024</td>
                                    <td><span class="status-badge badge-due">Unpaid</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn-view"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mono-text">PEN-2024-004</td>
                                    <td class="member-name-text">Pedro Reyes</td>
                                    <td class="mono-text">2023-00045</td>
                                    <td class="book-title-text">Python for DS</td>
                                    <td class="days-late-text" style="text-align: center;">8</td>
                                    <td class="penalty-text penalty-active">₱40.00</td>
                                    <td class="date-text">Nov 28, 2024</td>
                                    <td><span class="status-badge badge-success">Paid</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn-view"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>
</body>
</html>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    body {
        font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        background-color: #1C1C1C;
        -webkit-font-smoothing: antialiased;
    }
    .layout-container {
        display: flex;
        height: 100vh;
        width: 100vw;
        overflow: hidden;
    }

    /* Main Content */
    .main-canvas {
        flex: 1;
        background-color: #F9F6F0;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #FFFFFF;
        padding: 20px 40px;
        border-bottom: 1px solid #EAE6DF;
        flex-wrap: wrap; 
        gap: 16px;
    }
    .canvas-content {
        padding: 32px 40px;
        flex: 1;
    }
    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.02em;
    }
    .profile-avatar {
        width: 40px;
        height: 40px;
        background-color: #212B05;
        color: white;
        font-weight: 700;
        font-size: 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Summary Analytic Metric Cards */
    .summary-metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }
    .summary-card {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
    }
    .icon-wrapper {
        width: 42px;
        height: 42px;
        margin-bottom: 16px;
    }

    .sum-value {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.75rem;
        font-weight: 800;
        color: #1A1A1A;
        line-height: 1.1;
        margin-bottom: 2px;
        letter-spacing: -0.02em;
    }
    .sum-label {
        font-size: 0.8rem;
        color: #71717A;
        font-weight: 600;
    }

    .member-search-container {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 16px 24px;
        margin-bottom: 24px;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
    }
    .search-box-wrapper {
        width: 100%;
        position: relative;
        display: flex;
        align-items: center;
    }
    .search-icon-inside {
        position: absolute;
        left: 18px;
        font-size: 1.1rem;
        color: #A1A1AA;
        pointer-events: none;
    }
    .search-input {
        width: 100%;
        padding: 12px 16px 12px 46px;
        background-color: #F4F1EA;
        border: none;
        border-radius: 12px;
        font-size: 0.925rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1A1A1A;
        font-weight: 500;
        outline: none;
    }

    /* Core Panel Presentation Card Elements */
    .queue-panel {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .queue-data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1050px; 
    }
    .queue-data-table th {
        background-color: #FDFBF7;
        font-size: 0.75rem;
        font-weight: 700;
        color: #71717A;
        letter-spacing: 0.06em;
        padding: 16px;
        border-bottom: 1px solid #F4F1EA;
        text-align: left;
    }
    .queue-data-table td {
        padding: 16px;
        font-size: 0.875rem;
        color: #71717A;
        border-bottom: 1px solid #F4F1EA;
        font-weight: 600;
        vertical-align: middle;
    }
    .queue-data-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Row Content Typography */
    .mono-text {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 400;
        font-size: 0.825rem;
        color: #71717A;
    }
    .member-name-text {
        color: #1A1A1A;
        font-weight: 700;
    }
    .book-title-text {
        color: #4B5563;
        font-weight: 600;
    }
    .days-late-text {
        color: #C10007!important;
        font-weight: 800!important;
    }
    .date-text {
        color: #71717A;
    }
    .penalty-text {
        font-weight: 800!important;
    }
    .penalty-active {
        color: #F1580A!important; 
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-success { background-color: #DCFCE7; color: #008236; } 
    .badge-due { background-color: #FFE2E2; color: #C10007; }

    .actions-cell-row {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .action-btn-view {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.15s ease;
    }
    .action-btn-view:hover {
        opacity: 0.7;
    }
    .action-btn-view img {
        width: 20px;
        height: 20px;
    }
</style>