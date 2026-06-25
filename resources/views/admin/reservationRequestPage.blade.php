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
    <title>IskoLib - Reservation Requests</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Reservation Requests</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReservationAssets/reservationIcon.svg') }}" alt="Total Reservations" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($totalReservations) }}</div>
                        <div class="sum-label">Total Reservations</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReservationAssets/pendingIcon.svg') }}" alt="Pending Approval" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($pendingApproval) }}</div>
                        <div class="sum-label">Pending Approval</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/ReservationAssets/approvedIcon.svg') }}" alt="Approved" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($approvedCount) }}</div>
                        <div class="sum-label">Approved</div>
                    </div>
                </div>

                <div class="member-search-container">
                    <form action="{{ route('admin.reservationRequest') }}" method="GET" class="search-box-wrapper">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" class="search-input" placeholder="Search reservations by member or book title..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit();">
                    </form>
                </div>

                <div class="queue-panel">
                    <h2 class="panel-section-heading">Reservation Queue</h2>
                    
                    <div class="table-responsive-wrapper">
                        <table class="queue-data-table">
                            <thead>
                                <tr>
                                    <th>RESERVATION ID</th>
                                    <th>MEMBER NAME</th>
                                    <th>BOOK TITLE</th>
                                    <th>RESERVED ON</th>
                                    <th>STATUS</th>
                                    <th style="width: 140px; text-align: center;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservations as $req)
                                    <tr>
                                        <td class="mono-text">
                                            {{ $req->reservation_code ?? 'RES-' . \Carbon\Carbon::parse($req->created_at)->year . '-' . str_pad($req->id, 3, '0', STR_PAD_LEFT) }}
                                        </td>
                                        <td class="member-name-text">{{ $req->member_name }}</td>
                                        <td class="book-title-text">{{ $req->book_title }}</td>
                                        <td class="date-text">{{ \Carbon\Carbon::parse($req->created_at)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="status-badge badge-{{ $req->status }}">
                                                {{ ucfirst($req->status) }}
                                            </span>
                                        </td>
                                        <td class="actions-cell-row">
                                            <a href="{{ route('admin.reservation.show', $req->id) }}" class="action-btn-view">
                                                <img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View">
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty-table-text-row">No reservation records match the current filters.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($reservations->hasPages())
                        <div class="catalog-pagination-row">
                            <div class="text-zinc" style="font-size: 0.85rem; font-weight: 600;">
                                Showing {{ $reservations->firstItem() }}-{{ $reservations->lastItem() }} of {{ $reservations->total() }}
                            </div>
                            <div class="pagination-nav">
                                @if ($reservations->onFirstPage())
                                    <span class="page-link disabled" style="opacity: 0.4; cursor: not-allowed;">&laquo;</span>
                                @else
                                    <a href="{{ $reservations->previousPageUrl() }}" class="page-link" style="text-decoration: none;">&laquo;</a>
                                @endif

                                @foreach ($reservations->getUrlRange(1, $reservations->lastPage()) as $page => $url)
                                    @if ($page == $reservations->currentPage())
                                        <span class="page-link active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-link" style="text-decoration: none;">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($reservations->hasMorePages())
                                    <a href="{{ $reservations->nextPageUrl() }}" class="page-link" style="text-decoration: none;">&raquo;</a>
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
        position: relative; 
        display: flex;
        align-items: center;
        width: 100%;
    }
    .search-icon {
        position: absolute;
        left: 18px; 
        font-size: 1.1rem;
        color: #A1A1AA; 
        pointer-events: none; 
    }
    .search-input {
        width: 100%;
        padding: 12px 16px 12px 48px;
        background-color: #F4F1EA;
        border: none;
        border-radius: 12px;
        font-size: 0.925rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1A1A1A;
        font-weight: 500;
        outline: none;
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
        margin-bottom: 20px;
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

    /* Column Cell Typography Layouts */
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
    .empty-table-text-row {
        text-align: center;
        color: #71717A;
        padding: 40px 0 !important;
        font-weight: 600;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-pending { background-color: #FEF3C6; color: #BB4000; } 
    .badge-approved { background-color: #DCFCE7; color: #008236; } 
    .badge-rejected { background-color: #FFE2E2; color: #C10007; }
    .badge-fulfilled { background-color: #DCFCE7; color: #008236; }
    .badge-closed { background-color: #E5E7EB; color: #4B5563; }

    /* Action Controllers */
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
        font-size: 0.85rem;
        font-weight: 600;
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