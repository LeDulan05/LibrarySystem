<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>IskoLib - Late Return Reports</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Late Return Reports</h1>
                <div class="header-right-actions">
                    <button class="btn-export-report" onclick="window.print()">
                        <i class="bi bi-printer" style="font-size: 1rem;"></i>
                        <span>Print Report</span>
                    </button>
                    <div class="profile-avatar">LA</div>
                </div>
            </div>

            <div class="canvas-content">

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalPenaltiesIcon.svg') }}" alt="Metric Icon" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($totalLateReturns) }}</div>
                        <div class="sum-label">Total Late Returns</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/BorrowAssets/approvedTodayIcon.svg') }}" alt="Metric Icon" class="icon-wrapper">
                        <div class="sum-value">₱{{ number_format($totalPenalties, 2) }}</div>
                        <div class="sum-label">Total Penalties Assessed</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/PenaltyAssets/activePenaltiesIcon.svg') }}" alt="Metric Icon" class="icon-wrapper">
                        <div class="sum-value">₱{{ number_format($paidPenalties, 2) }}</div>
                        <div class="sum-label">Total Fines Paid</div>
                    </div>
                </div>

                <div class="analytics-chart-panel">
                    <h3 class="panel-subtitle-heading">Late Returns Trend Overview</h3>
                    <div class="chart-canvas-container">
                        <canvas id="lateReturnsTrendChart"></canvas>
                    </div>
                </div>

                <div class="member-search-container">
                    <form action="{{ route('admin.report') }}" method="GET" class="search-box-wrapper">
                        <i class="bi bi-search search-icon-inside"></i>
                        <input type="text" name="search" class="search-input" placeholder="Search parameters by member name or book titles..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit();">
                    </form>
                </div>

                <div class="queue-panel">
                    <div class="table-responsive-wrapper">
                        <table class="queue-data-table">
                            <thead>
                                <tr>
                                    <th>MEMBER</th>
                                    <th>STUDENT NO.</th>
                                    <th>BOOK</th>
                                    <th style="text-align: center;">DAYS LATE</th>
                                    <th>RETURN DATE</th>
                                    <th>STATUS</th>
                                    <th>FINE AMOUNT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lateReturns as $data)
                                    <tr>
                                        <td class="member-name-text">{{ $data->member_name }}</td>
                                        <td class="mono-text">{{ $data->student_number ?? 'N/A' }}</td>
                                        <td class="book-title-text">{{ $data->book_title }}</td>
                                        <td class="days-late-text" style="text-align: center;">{{ $data->days_late }} Days</td>
                                        <td class="date-text">{{ \Carbon\Carbon::parse($data->return_date)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="status-badge {{ $data->penalty_status === 'paid' ? 'badge-success' : 'badge-due' }}">
                                                {{ ucfirst($data->penalty_status) }}
                                            </span>
                                        </td>
                                        <td style="font-weight: 700; color: #1A1A1A;">₱{{ number_format($data->penalty_amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; color: #71717A; padding: 40px 0;">
                                            No late logs matching your constraints exist in database archives.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($lateReturns->hasPages())
                        <div class="catalog-pagination-row">
                            <div class="text-zinc" style="font-size: 0.85rem; font-weight: 600;">
                                Showing {{ $lateReturns->firstItem() }}-{{ $lateReturns->lastItem() }} of {{ $lateReturns->total() }}
                            </div>
                            <div class="pagination-nav">
                                @if ($lateReturns->onFirstPage())
                                    <span class="page-link disabled" style="opacity: 0.4; cursor: not-allowed;">&laquo;</span>
                                @else
                                    <a href="{{ $lateReturns->previousPageUrl() }}" class="page-link" style="text-decoration: none;">&laquo;</a>
                                @endif

                                @foreach ($lateReturns->getUrlRange(1, $lateReturns->lastPage()) as $page => $url)
                                    @if ($page == $lateReturns->currentPage())
                                        <span class="page-link active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-link" style="text-decoration: none;">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($lateReturns->hasMorePages())
                                    <a href="{{ $lateReturns->nextPageUrl() }}" class="page-link" style="text-decoration: none;">&raquo;</a>
                                @else
                                    <span class="page-link disabled" style="opacity: 0.4; cursor: not-allowed;">&raquo;</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    <script>
        const ctx = document.getElementById('lateReturnsTrendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Late Returns Count',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#FF5722',
                    backgroundColor: 'rgba(255, 87, 34, 0.05)',
                    borderWidth: 2,
                    tension: 0.35,
                    fill: true,
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
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, color: '#A1A1AA' },
                        grid: { color: '#F4F1EA' }
                    },
                    x: {
                        ticks: { color: '#A1A1AA' },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</body>
</html>

<style>
    /* Styling variables remain completely unchanged */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif; background-color: #1C1C1C; -webkit-font-smoothing: antialiased; }
    .layout-container { display: flex; height: 100vh; width: 100vw; overflow: hidden; }
    .main-canvas { flex: 1; background-color: #F9F6F0; overflow-y: auto; display: flex; flex-direction: column; }
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; background-color: #FFFFFF; padding: 20px 40px; border-bottom: 1px solid #EAE6DF; flex-wrap: wrap; gap: 16px; }
    .header-right-actions { display: flex; align-items: center; gap: 20px; }
    .btn-export-report { padding: 10px 20px; background-color: #212B05; border: none; border-radius: 12px; color: #FFFFFF; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; cursor: pointer; transition: opacity 0.15s ease; }
    .btn-export-report:hover { opacity: 0.9; }
    .canvas-content { padding: 32px 40px; flex: 1; }
    .dashboard-title { font-size: 1.5rem; font-weight: 800; color: #1A1A1A; letter-spacing: -0.02em; }
    .profile-avatar { width: 40px; height: 40px; background-color: #212B05; color: white; font-weight: 700; font-size: 14px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .summary-metrics-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 28px; }
    .summary-card { background-color: #FFFFFF; border: 1px solid #EAE6DF; border-radius: 16px; padding: 24px; }
    .icon-wrapper { width: 42px; height: 42px; margin-bottom: 16px; }
    .sum-value { font-size: 1.75rem; font-weight: 800; color: #1A1A1A; line-height: 1.1; margin-bottom: 2px; letter-spacing: -0.02em; }
    .sum-label { font-size: 0.8rem; color: #71717A; font-weight: 600; }
    .analytics-chart-panel { background-color: #FFFFFF; border: 1px solid #EAE6DF; border-radius: 16px; padding: 24px; margin-bottom: 28px; }
    .panel-subtitle-heading { font-size: 0.95rem; font-weight: 800; color: #1A1A1A; margin-bottom: 20px; letter-spacing: -0.01em; }
    .chart-canvas-container { width: 100%; height: 260px; position: relative; }
    .member-search-container { background-color: #FFFFFF; border: 1px solid #EAE6DF; border-radius: 16px; padding: 16px 24px; margin-bottom: 24px; width: 100%; box-shadow: 0 2px 4px rgba(0,0,0,0.01); }
    .search-box-wrapper { width: 100%; position: relative; display: flex; align-items: center; }
    .search-icon-inside { position: absolute; left: 18px; font-size: 1.1rem; color: #A1A1AA; pointer-events: none; }
    .search-input { width: 100%; padding: 12px 16px 12px 46px; background-color: #F4F1EA; border: none; border-radius: 12px; font-size: 0.925rem; color: #1A1A1A; font-weight: 500; outline: none; }
    .queue-panel { background-color: #FFFFFF; border: 1px solid #EAE6DF; border-radius: 16px; padding: 24px; margin-bottom: 24px; }
    .table-responsive-wrapper { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .queue-data-table { width: 100%; border-collapse: collapse; min-width: 950px; margin-top: 20px; }
    .queue-data-table th { background-color: #FDFBF7; font-size: 0.75rem; font-weight: 700; color: #71717A; letter-spacing: 0.06em; padding: 16px; border-bottom: 1px solid #F4F1EA; text-align: left; }
    .queue-data-table td { padding: 16px; font-size: 0.875rem; color: #71717A; border-bottom: 1px solid #F4F1EA; font-weight: 600; vertical-align: middle; }
    .queue-data-table tbody tr:last-child td { border-bottom: none; }
    .member-name-text { color: #1A1A1A; font-weight: 700; }
    .book-title-text { color: #4B5563; font-weight: 600; }
    .days-late-text { color: #C10007!important; font-weight: 800!important; }
    .date-text { color: #71717A; }
    .mono-text { font-family: 'JetBrains Mono', monospace; font-weight: 400; font-size: 0.825rem; color: #71717A; }
    .status-badge { padding: 6px 14px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
    .badge-success { background-color: #DCFCE7; color: #008236; } 
    .badge-due { background-color: #FFE2E2; color: #C10007; }
    .catalog-pagination-row { display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 12px; flex-wrap: wrap; gap: 12px; }
    .text-zinc { color: #71717A; }
    .pagination-nav { display: flex; align-items: center; gap: 8px; }
    .page-link { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; color: #71717A; border-radius: 50%; cursor: pointer; transition: all 0.15s ease; }
    .page-link:hover { background-color: #F4F1EA; color: #1A1A1A; }
    .page-link.active { background-color: #FF5722; color: #FFFFFF; }

    @media print {
        .layout-container > *:not(.main-canvas), .dashboard-header, .member-search-container, .catalog-pagination-row { display: none !important; }
        body, .main-canvas { background: white !important; }
        .canvas-content { padding: 0 !important; }
    }
</style>