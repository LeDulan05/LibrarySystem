<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <title>IskoLib - Reservation Requests</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Reservations</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReservationAssets/reservationIcon.svg') }}" alt="Total Reservations" class="icon-wrapper">
                        <div class="sum-value">487</div>
                        <div class="sum-label">Total Reservations</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReservationAssets/pendingIcon.svg') }}" alt="Pending Approval" class="icon-wrapper">
                        <div class="sum-value">2</div>
                        <div class="sum-label">Pending Approval</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReservationAssets/approvedIcon.svg') }}" alt="Approved" class="icon-wrapper">
                        <div class="sum-value">485</div>
                        <div class="sum-label">Approved</div>
                    </div>
                </div>

                <div class="queue-panel">
                    
                    <div class="table-responsive-wrapper">
                        <table class="queue-data-table">
                            <thead>
                                <tr>
                                    <th>RES. ID</th>
                                    <th>MEMBER</th>
                                    <th>BOOK</th>
                                    <th>RESERVED ON</th>
                                    <th>PICKUP DATE</th>
                                    <th>STATUS</th>
                                    <th style="width: 140px; text-align: center;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="mono-text">RES-2024-001</td>
                                    <td class="member-name-text">Pedro Reyes</td>
                                    <td class="book-title-text">Machine Learning Yearning</td>
                                    <td class="date-text">Dec 12, 2024</td>
                                    <td class="date-text">Dec 15, 2024</td>
                                    <td><span class="status-badge badge-pending">Pending</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn-view"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                        <button class="action-btn-approve"><img src="{{ asset('AdminAssets/BorrowAssets/approveIcon.svg') }}" alt="Approve"></button>
                                        <button class="action-btn-reject"><img src="{{ asset('AdminAssets/BorrowAssets/rejectIcon.svg') }}" alt="Reject"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mono-text">RES-2024-002</td>
                                    <td class="member-name-text">Ana Lim</td>
                                    <td class="book-title-text">Python for Data Analysis</td>
                                    <td class="date-text">Dec 10, 2024</td>
                                    <td class="date-text">Dec 18, 2024</td>
                                    <td><span class="status-badge badge-success">Approved</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn-view"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                        <button class="action-btn-approve"><img src="{{ asset('AdminAssets/BorrowAssets/approveIcon.svg') }}" alt="Approve"></button>
                                        <button class="action-btn-reject"><img src="{{ asset('AdminAssets/BorrowAssets/rejectIcon.svg') }}" alt="Reject"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="mono-text">RES-2024-003</td>
                                    <td class="member-name-text">Carlos Cruz</td>
                                    <td class="book-title-text">Cybersecurity Essentials</td>
                                    <td class="date-text">Dec 8, 2024</td>
                                    <td class="date-text">Dec 20, 2024</td>
                                    <td><span class="status-badge badge-pending">Pending</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn-view"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                        <button class="action-btn-approve"><img src="{{ asset('AdminAssets/BorrowAssets/approveIcon.svg') }}" alt="Approve"></button>
                                        <button class="action-btn-reject"><img src="{{ asset('AdminAssets/BorrowAssets/rejectIcon.svg') }}" alt="Reject"></button>
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
    /* Baseline Overrides & Viewport Resets */
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
        min-width: 900px; 
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
    .date-text {
        color: #71717A;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-pending { background-color: #FEF3C6; color: #BB4D00; } 
    .badge-success { background-color: #DCFCE7; color: #008236; } 

    .actions-cell-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
    }
    .action-btn-view, .action-btn-approve, .action-btn-reject {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.15s ease;
    }
    .action-btn-view:hover, .action-btn-approve:hover, .action-btn-reject:hover {
        opacity: 0.7;
    }
    .action-btn-view img, .action-btn-approve img, .action-btn-reject img {
        width: 20px;
        height: 20px;
    }
</style>