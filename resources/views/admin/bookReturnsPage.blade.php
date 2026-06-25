<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
                        <div class="sum-value">{{ number_format($pendingReturns) }}</div>
                        <div class="sum-label">Pending Returns</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/BorrowAssets/approvedTodayIcon.svg') }}" alt="Returned Today" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($returnedToday) }}</div>
                        <div class="sum-label">Returned Today</div> 
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/OverviewAssets/totalPenaltiesIcon.svg') }}" alt="Overdue" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($overdueCount) }}</div>
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
                                @forelse($returns as $ret)
                                    <tr>
                                        <td class="mono-text">
                                            {{ $ret->transaction_code ?? 'RET-' . \Carbon\Carbon::parse($ret->return_date)->year . '-' . str_pad($ret->id, 3, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="member-name-text">{{ $ret->member_name }}</td>
                                        <td class="book-title-text">{{ $ret->book_title }}</td>
                                        <td class="date-text">{{ \Carbon\Carbon::parse($ret->return_date)->format('M d, Y') }}</td>
                                        
                                        <td class="penalty-text {{ $ret->penalty_amount > 0 ? 'penalty-active' : 'penalty-none' }}">
                                            ₱{{ number_format($ret->penalty_amount, 2) }}
                                        </td>
                                        <td>
                                            @if($ret->penalty_amount > 0)
                                                <span class="status-badge badge-due">Late</span>
                                            @else
                                                <span class="status-badge badge-success">On Time</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty-table-text-row" style="text-align: center; color: #71717A; padding: 40px 0; font-weight: 600;">
                                            No completed book return logs discovered matching database records.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($returns->hasPages())
                        <div class="catalog-pagination-row">
                            <div class="text-zinc" style="font-size: 0.85rem; font-weight: 600;">
                                Showing {{ $returns->firstItem() }}-{{ $returns->lastItem() }} of {{ $returns->total() }}
                            </div>
                            <div class="pagination-nav">
                                @if ($returns->onFirstPage())
                                    <span class="page-link disabled" style="opacity: 0.4; cursor: not-allowed;">&laquo;</span>
                                @else
                                    <a href="{{ $returns->previousPageUrl() }}" class="page-link" style="text-decoration: none;">&laquo;</a>
                                @endif

                                @foreach ($returns->getUrlRange(1, $returns->lastPage()) as $page => $url)
                                    @if ($page == $returns->currentPage())
                                        <span class="page-link active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-link" style="text-decoration: none;">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($returns->hasMorePages())
                                    <a href="{{ $returns->nextPageUrl() }}" class="page-link" style="text-decoration: none;">&raquo;</a>
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
    .catalog-pagination-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        padding-top: 12px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .text-zinc {
        color: #71717A;
    }
    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .page-link {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
        color: #71717A;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .page-link:hover {  
        background-color: #F4F1EA;
        color: #1A1A1A;
    }
    .page-link.active {
        background-color: #FF5722;
        color: #FFFFFF;
    }
</style>