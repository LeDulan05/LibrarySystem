<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300&family=Fraunces:ital,opsz,wght@0,9..144,100..900;1,9..144,100..900&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    
    <title>IskoLib - Admin Panel</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Dashboard</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">
                <div class="metrics-grid">
                    <div class="metric-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalBooksIcon.svg') }}" alt="Books Icon" class="icon-wrapper">
                        <div class="metric-value">12,450</div>
                        <div class="metric-label">Total Books</div>
                    </div>

                    <div class="metric-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalMembersIcon.svg') }}" alt="Members Icon" class="icon-wrapper">
                        <div class="metric-value">3,820</div>
                        <div class="metric-label">Total Members</div>
                    </div>

                    <div class="metric-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalPenaltiesIcon.svg') }}" alt="Penalties Icon" class="icon-wrapper">
                        <div class="metric-value">₱2,450</div>
                        <div class="metric-label">Total Penalties</div>
                    </div>

                    <div class="metric-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/borrowTodayIcon.svg') }}" alt="Borrowed Icon" class="icon-wrapper">
                        <div class="metric-value">23</div>
                        <div class="metric-label">Borrowed Today</div>
                    </div>

                    <div class="metric-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/pendingReturnIcon.svg') }}" alt="Pending Returns Icon" class="icon-wrapper">
                        <div class="metric-value">87</div>
                        <div class="metric-label">Pending Returns</div>
                    </div>

                    <div class="metric-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalReservationIcon.svg') }}" alt="Book Reservations Icon" class="icon-wrapper">
                        <div class="metric-value">487</div>
                        <div class="metric-label">Book Reservations</div>
                    </div>
                </div>

                <div class="middle-section">
                    <div class="chart-container">
                        <div class="chart-header">
                            <h2>Borrowing Activity</h2>
                            <div class="chart-dropdown-placeholder"></div>
                        </div>
                        <div class="chart-body">
                            <canvas id="borrowingActivityChart"></canvas>
                        </div>
                    </div>

                    <div class="quick-actions-card">
                        <h2>Quick Actions</h2>
                        <div class="actions-list">
                            <a href="{{ route('admin.addBook') }}" class="action-row">
                                <div class="action-left"><img src="{{ asset('AdminAssets/OverviewAssets/newBookIcon.svg') }}" alt="New Book Icon">Add New Book</div>
                                <i class="bi bi-chevron-right" alignment="right"></i>
                            </a>
                            <a href="{{ route('admin.memberManagement') }}" class="action-row">
                                <div class="action-left"><img src="{{ asset('AdminAssets/OverviewAssets/regMemberIcon.svg') }}" alt="Register Member Icon">Member Management</div>
                                <i class="bi bi-chevron-right" alignment="right"></i>
                            </a>
                            <a href="{{ route('admin.borrowRequest') }}" class="action-row">
                                <div class="action-left"><img src="{{ asset('AdminAssets/OverviewAssets/borrowReqIcon.svg') }}" alt="Borrow Today Icon">View Borrow Requests</div>
                                <i class="bi bi-chevron-right" alignment="right"></i>
                            </a>
                            <a href="{{ route('admin.bookReturn') }}" class="action-row">
                                <div class="action-left"><img src="{{ asset('AdminAssets/OverviewAssets/mngReturnIcon.svg') }}" alt="Pending Return Icon">Manage Returns</div>
                                <i class="bi bi-chevron-right" alignment="right"></i>
                            </a>
                            <a href="{{ route('admin.report') }}" class="action-row">
                                <div class="action-left"><img src="{{ asset('AdminAssets/OverviewAssets/viewReportIcon.svg') }}" alt="View Reports Icon">View Reports</div>
                                <i class="bi bi-chevron-right" alignment="right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="transactions-panel">
                    <div class="panel-header">
                        <h2>Recent Transactions</h2>
                        <a href="#" class="view-all-link">View All</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                               <th>MEMBER</th>
                               <th>BOOK</th>
                               <th>ACTION</th>
                               <th>DATE</th>
                               <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Juan dela Cruz</td>
                                <td>Introduction to AI</td>
                                <td>Borrowed</td>
                                <td>Dec 10</td>
                                <td><span class="status-badge badge-success">Active</span></td>
                            </tr>
                            <tr>
                                <td>Maria Santos</td>
                                <td>Clean Code</td>
                                <td>Returned</td>
                                <td>Dec 9</td>
                                <td><span class="status-badge badge-success">Returned</span></td>
                            </tr>
                            <tr>
                                <td>Pedro Reyes</td>
                                <td>Python for DS</td>
                                <td>Borrow Request</td>
                                <td>Dec 8</td>
                                <td><span class="status-badge badge-pending">Pending</span></td>
                            </tr>
                            <tr>
                                <td>Ana Lim</td>
                                <td>Database Concepts</td>
                                <td>Penalty Paid</td>
                                <td>Dec 7</td>
                                <td><span class="status-badge badge-success">Paid</span></td>
                            </tr>
                            <tr>
                                <td>Carlos Cruz</td>
                                <td>Cybersecurity</td>
                                <td>Reservation</td>
                                <td>Dec 6</td>
                                <td><span class="status-badge badge-success">Approved</span></td>
                            </tr>
                        </tbody>
                    </table>
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
        overflow: hidden;
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

    /* Metrics Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .metric-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
    }
    .icon-wrapper {
        width: 42px;
        height: 42px;
        margin-bottom: 16px;
    }
    .metric-value {
        font-family: 'DM Mono', monospace;
        font-size: 2rem; 
        font-weight: 500;
        color: #1A1A1A;
        letter-spacing: -0.02em;
        line-height: 1;
        margin-bottom: 6px;
    }
    .metric-label {
        font-size: 0.875rem;
        color: #71717A;
        font-weight: 600;
    }

    /* Chart and Quick Actions */
    .middle-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }
    .chart-container, .quick-actions-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 29px;
    }
    .chart-header, .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .chart-header h2, .quick-actions-card h2, .panel-header h2 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1A1A1A;
        letter-spacing: -0.01em;
    }
    .chart-dropdown-placeholder {
        width: 48px;
        height: 30px;
        background-color: #F4F1EA;
        border-radius: 8px;
    }
    .chart-body {
        position: relative; 
        height: 220px; 
        width: 100%;
        margin-top: 12px;
    }

    /* Quick Action Rows Controls */
    .actions-list {
        display: flex;
        flex-direction: column;
        margin-top: 12px;
    }
    .action-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #F4F1EA;
        cursor: pointer;
        text-decoration: none; 
    }
    .action-row:last-child {
        border-bottom: none;
    }
    .action-left {
        display: flex;
        align-items: center;
        gap: 16px;
        font-size: 0.925rem;
        font-weight: 700;
        color: #27272A;
    }
    .action-left img {
        width: 32px;
        height: 32px;
    }
    .action-row .bi-chevron-right {
        color: #71717A;
    }

    /* Transactions Table */
    .transactions-panel {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
    }
    .view-all-link {
        font-size: 0.875rem;
        color: #71717A;
        font-weight: 700;
        text-decoration: none;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table th {
        background-color: #FDFBF7;
        font-size: 0.75rem;
        font-weight: 700;
        color: #71717A;
        letter-spacing: 0.06em;
        padding: 14px 16px;
        border-bottom: 1px solid #F4F1EA;
        text-align: left;
    }
    .data-table td {
        padding: 16px;
        font-size: 0.925rem;
        color: #27272A;
        border-bottom: 1px solid #F4F1EA;
        font-weight: 600;
    }
    .data-table td:nth-child(4) {
        font-family: 'DM Mono', monospace;
        font-weight: 400;
        font-size: 0.875rem;
    }
    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-success {
        background-color: #DCFCE7;
        color: #008236;
    }
    .badge-pending {
        background-color: #FEF3C6;
        color: #BB4D00;
    }

    .badge-due{
        background-color: #FFE2E2;
        color: #C10007;
    }
</style>

<script>
    const ctx = document.getElementById('borrowingActivityChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Books Borrowed',
                data: [42, 58, 52, 75, 48, 65, 60, 88, 55, 78, 92, 70], 
                borderColor: '#FF5722', 
                backgroundColor: 'rgba(255, 87, 34, 0.05)', 
                borderWidth: 3,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#FF5722',
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false }, 
                    ticks: { color: '#A1A1AA', font: { weight: '600', size: 12 } }
                },
                y: {
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 25,
                        color: '#A1A1AA',
                        font: { weight: '600', size: 12 }
                    },
                    border: { dash: [3, 3] },
                    grid: { color: '#E5E7EB' }
                }
            }
        }
    });
</script>