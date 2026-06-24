<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <title>IskoLib - Book Returns</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Book Returns</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/BorrowAssets/pendingRequestIcon.svg') }}" alt="Pending Returns" class="icon-wrapper">
                        <div class="sum-value">87</div>
                        <div class="sum-label">Pending Returns</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/BorrowAssets/approvedTodayIcon.svg') }}" alt="Returned Today" class="icon-wrapper">
                        <div class="sum-value">12</div>
                        <div class="sum-label">Returned Today</div> 
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalPenaltiesIcon.svg') }}" alt="Overdue" class="icon-wrapper">
                        <div class="sum-value">23</div>
                        <div class="sum-label">Overdue</div>
                    </div>
                </div>

                <div class="queue-panel">
                    
                    <div class="table-responsive-wrapper">
                        <table class="queue-data-table">
                            <thead>
                                <tr>
                                    <th>REQUEST ID</th>
                                    <th>MEMBER</th>
                                    <th>BOOK TITLE</th>
                                    <th>RETURN DATE</th>
                                    <th>PENALTY</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="mono-text">RET-2024-001</td>
                                    <td class="member-name-text">Juan dela Cruz</td>
                                    <td class="book-title-text">Computer Networks</td>
                                    <td class="date-text">Dec 10, 2024</td>
                                    <td class="penalty-text penalty-active">₱25.00</td>
                                    <td><span class="status-badge badge-due">Late</span></td>
                                </tr>
                                <tr>
                                    <td class="mono-text">RET-2024-002</td>
                                    <td class="member-name-text">Maria Santos</td>
                                    <td class="book-title-text">Clean Code</td>
                                    <td class="date-text">Dec 9, 2024</td>
                                    <td class="penalty-text penalty-none">₱0.00</td>
                                    <td><span class="status-badge badge-success">On Time</span></td>
                                </tr>
                                <tr>
                                    <td class="mono-text">RET-2024-003</td>
                                    <td class="member-name-text">Pedro Reyes</td>
                                    <td class="book-title-text">Cybersecurity Essentials</td>
                                    <td class="date-text">Dec 8, 2024</td>
                                    <td class="penalty-text penalty-active">₱10.00</td>
                                    <td><span class="status-badge badge-due">Late</span></td>
                                </tr>
                                <tr>
                                    <td class="mono-text">RET-2024-004</td>
                                    <td class="member-name-text">Carlos Cruz</td>
                                    <td class="book-title-text">Database System Concepts</td>
                                    <td class="date-text">Dec 7, 2024</td>
                                    <td class="penalty-text penalty-none">₱0.00</td>
                                    <td><span class="status-badge badge-success">On Time</span></td>
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

    /* Core Main Canvas Viewport Layout */
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
        flex-wrap: wrap; /* Standard flex wrapping for small viewports */
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

    /* Summary Analytic Metric Cards Responsive Auto-Fit Grid (No Media Queries) */
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

    /* Row Content Typography Modifiers */
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
    .penalty-text {
        font-weight: 800!important;
    }
    .penalty-active {
        color: #F1580A!important; 
    }
    .penalty-none {
        color: #16A34A!important; 
    }

    /* Custom System Status Badge Components */
    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-success { background-color: #DCFCE7; color: #008236; } 
    .badge-due { background-color: #FFE2E2; color: #C10007; }

    .icon-wrapper {
        width: 42px;
        height: 42px;
        margin-bottom: 16px;
    }
</style>