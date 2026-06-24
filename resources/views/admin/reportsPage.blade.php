<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Fonts Imports for IskoLib Design System -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <title>IskoLib - Late Return Reports</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Late Return Reports</h1>
                <div class="header-right-actions">
                    <button class="btn-export-report">
                        <img src="{{ asset('AdminAssets/ReportAssets/exportIcon.svg') }}" alt="Export Icon" class="btn-icon-svg">
                        <span>Export</span>
                    </button>
                    <div class="profile-avatar">LA</div>
                </div>
            </div>

            <div class="canvas-content">

                <div class="date-filter-container">
                    <div class="date-filter-row">
                        <div class="date-input-group">
                            <span class="date-label">From</span>
                            <input type="date" class="date-field-input" value="2024-11-01">
                        </div>
                        <div class="date-input-group">
                            <span class="date-label">To</span>
                            <input type="date" class="date-field-input" value="2024-12-31">
                        </div>
                        <div class="dropdown-wrapper-spacer"></div>
                    </div>
                </div>

                <div class="report-chart-container">
                    <h2 class="panel-section-heading">Monthly Borrowing Activity</h2>
                    <div class="chart-body-wrapper">
                        <canvas id="borrowingActivityChart"></canvas>
                    </div>
                </div>

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReportAssets/lateReturnsIcon.svg') }}" alt="Total Late Returns" class="icon-wrapper">
                        <div class="sum-value">4</div>
                        <div class="sum-label">Total Late Returns</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReportAssets/totalPenaltiesIcon.svg') }}" alt="Total Penalties" class="icon-wrapper">
                        <div class="sum-value">₱140.00</div>
                        <div class="sum-label">Total Penalties</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReportAssets/paidIcon.svg') }}" alt="Paid" class="icon-wrapper">
                        <div class="sum-value">₱65.00</div>
                        <div class="sum-label">Paid</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReportAssets/outstandingIcon.svg') }}" alt="Outstanding" class="icon-wrapper">
                        <div class="sum-value">₱75.00</div>
                        <div class="sum-label">Outstanding</div>
                    </div>
                </div>

                <!-- Detailed Late Return Data Table Panel -->
                <div class="queue-panel">
                    <h2 class="panel-section-heading">Late Return Details</h2>
                    
                    <!-- Responsive swipable container scroll-box to prevent mobile clipping -->
                    <div class="table-responsive-wrapper">
                        <table class="queue-data-table">
                            <thead>
                                <tr>
                                    <th>MEMBER</th>
                                    <th>BOOK</th>
                                    <th>DUE DATE</th>
                                    <th>RETURN DATE</th>
                                    <th style="text-align: center;">DAYS LATE</th>
                                    <th>PENALTY</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="member-name-text">Ana Lim</td>
                                    <td class="book-title-text">Research Methodology</td>
                                    <td class="date-text">Nov 26, 2024</td>
                                    <td class="date-text">Dec 8, 2024</td>
                                    <td class="days-late-text" style="text-align: center;">12</td>
                                    <td class="penalty-text penalty-active">₱60.00</td>
                                    <td><span class="status-badge badge-due">Unpaid</span></td>
                                </tr>
                                <tr>
                                    <td class="member-name-text">Carlos Cruz</td>
                                    <td class="book-title-text">Cybersecurity Essentials</td>
                                    <td class="date-text">Dec 5, 2024</td>
                                    <td class="date-text">Dec 8, 2024</td>
                                    <td class="days-late-text" style="text-align: center;">3</td>
                                    <td class="penalty-text penalty-active">₱15.00</td>
                                    <td><span class="status-badge badge-due">Unpaid</span></td>
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
    .header-right-actions {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
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

    .btn-export-report {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 20px;
        height: 40px;
        background-color: #212B05;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        weight: 700;
        font-weight: 700;
        font-size: 0.875rem;
        color: #FFFFFF;
        box-shadow: 0 2px 6px rgba(33, 43, 5, 0.15);
    }

    .date-filter-container {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 16px 24px;
        margin-bottom: 24px;
        width: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
    }
    .date-filter-row {
        display: flex;
        align-items: center;
        gap: 24px;
        width: 100%;
        flex-wrap: wrap;
    }
    .date-input-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .date-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #4B5563;
    }
    .date-field-input {
        padding: 10px 14px;
        background-color: #F4F1EA;
        border: none;
        border-radius: 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        color: #1A1A1A;
        font-weight: 600;
        outline: none;
    }
    .dropdown-wrapper-spacer {
        flex: 1;
        min-width: 100px;
    }

    .report-chart-container {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }
    .chart-body-wrapper {
        position: relative; 
        height: 220px; 
        width: 100%;
        margin-top: 16px;
    }

    /* Summary Analytic Metric Cards */
    .summary-metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
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
    .panel-section-heading {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1A1A1A;
        letter-spacing: -0.01em;
    }

    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .queue-data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px; 
        margin-top: 20px;
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
    .badge-due { background-color: #FFE2E2; color: #C10007; }
</style>


    <script>
        const ctx = document.getElementById('borrowingActivityChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Activity Count',
                    data: [42, 58, 50, 74, 48, 65, 61, 88, 53, 77, 91, 70], 
                    borderColor: '#FF5722', 
                    backgroundColor: 'rgba(255, 87, 34, 0.04)', 
                    borderWidth: 2.5,
                    tension: 0.35,
                    pointRadius: 4.5,
                    pointBackgroundColor: '#FF5722',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 1,
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
                        ticks: { color: '#A1A1AA', font: { weight: '600', size: 11 } }
                    },
                    y: {
                        min: 0,
                        max: 100,
                        ticks: {
                            stepSize: 25,
                            color: '#A1A1AA',
                            font: { weight: '600', size: 11 }
                        },
                        border: { dash: [4, 4] },
                        grid: { color: '#E5E7EB' }
                    }
                }
            }
        });
    </script>