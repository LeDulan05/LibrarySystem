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
                <h1 class="dashboard-title">Reservations</h1>
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
                                @forelse($reservations as $res)
                                    <tr>
                                        <td class="mono-text">RES-{{ \Carbon\Carbon::parse($res->created_at)->year }}-{{ str_pad($res->id, 3, '0', STR_PAD_LEFT) }}</td>
                                        <td class="member-name-text" id="member-name-{{ $res->id }}">{{ $res->member_name }}</td>
                                        <td class="book-title-text" id="book-title-{{ $res->id }}">{{ $res->book_title }}</td>
                                        <td class="date-text">{{ \Carbon\Carbon::parse($res->reservation_date ?? $res->created_at)->format('M d, Y') }}</td>
                                        <td class="date-text">
                                            {{ $res->hold_expires_at ? \Carbon\Carbon::parse($res->hold_expires_at)->format('M d, Y') : 'Pending Hold' }}
                                        </td>
                                        <td>
                                            <span class="status-badge badge-{{ $res->status }}">
                                                {{ ucfirst($res->status) }}
                                            </span>
                                        </td>
                                        <td class="actions-cell-row">
                                            <a href="{{ route('admin.reservation.show', $res->id) }}" class="action-btn-view">
                                                <img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View">
                                            </a>
                                            
                                            @if($res->status === 'pending')
                                                <button type="button" class="action-btn-approve" onclick="triggerApproveModal({{ $res->id }})">
                                                    <img src="{{ asset('AdminAssets/BorrowAssets/approveIcon.svg') }}" alt="Approve">
                                                </button>
                                                <button type="button" class="action-btn-reject" onclick="triggerRejectModal({{ $res->id }})">
                                                    <img src="{{ asset('AdminAssets/BorrowAssets/rejectIcon.svg') }}" alt="Reject">
                                                </button>
                                            @else
                                                <span style="color: #A1A1AA; font-size: 0.8rem; font-weight: 700;">Processed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="empty-table-text-row">
                                            No library book reservation requests currently logged.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($reservations->hasPages())
                        <div class="catalog-pagination-row">
                            <div class="text-zinc">
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

    <div class="modal-overlay" id="approveReservationModalOverlay">
        <form id="approveForm" method="POST" class="action-modal-card">
            @csrf
            <div class="modal-round-icon-frame success-frame"><i class="bi bi-check-circle"></i></div>
            <h3 class="modal-main-title">Approve Reservation Request?</h3>
            <p class="modal-warning-body">
                Confirm approval for <strong id="approveMemberTarget">Member</strong> to reserve <strong id="approveBookTarget">"Book"</strong>.
            </p>
            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeApproveModal()">Cancel</button>
                <button type="submit" class="btn-modal-confirm">Confirm</button>
            </div>
        </form>
    </div>

    <div class="modal-overlay" id="rejectReservationModalOverlay">
        <form id="rejectForm" method="POST" class="action-modal-card">
            @csrf
            <div class="modal-round-icon-frame danger-frame"><i class="bi bi-x-circle"></i></div>
            <h3 class="modal-main-title">Reject Reservation Request?</h3>
            <p class="modal-warning-body">
                Reject reservation for <strong id="rejectMemberTarget">Member</strong> &mdash; <strong id="rejectBookTarget">"Book"</strong>?
            </p>
            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn-modal-danger">Reject</button>
            </div>
        </form>
    </div>

    <script>
        function triggerApproveModal(id) {
            const member = document.getElementById('member-name-' + id).innerText;
            const book = document.getElementById('book-title-' + id).innerText;
            
            document.getElementById('approveMemberTarget').innerText = member;
            document.getElementById('approveBookTarget').innerText = `"${book}"`;
            
            document.getElementById('approveForm').action = "/admin/reservation/" + id + "/approve";
            document.getElementById('approveReservationModalOverlay').classList.add('modal-visible');
        }

        function closeApproveModal() {
            document.getElementById('approveReservationModalOverlay').classList.remove('modal-visible');
        }

        function triggerRejectModal(id) {
            const member = document.getElementById('member-name-' + id).innerText;
            const book = document.getElementById('book-title-' + id).innerText;
            
            document.getElementById('rejectMemberTarget').innerText = member;
            document.getElementById('rejectBookTarget').innerText = `"${book}"`;
            
            document.getElementById('rejectForm').action = "/admin/reservation/" + id + "/reject";
            document.getElementById('rejectReservationModalOverlay').classList.add('modal-visible');
        }

        function closeRejectModal() {
            document.getElementById('rejectReservationModalOverlay').classList.remove('modal-visible');
        }
    </script>
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
        text-transform: capitalize;
    }
    .badge-pending { background-color: #FEF3C6; color: #BB4D00; }
    .badge-approved { background-color: #DCFCE7; color: #008236; }
    .badge-rejected { background-color: #FFE2E2; color: #C10007; }
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
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.4);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .modal-overlay.modal-visible {
        display: flex;
        opacity: 1;
    }
    .action-modal-card {
        background-color: #FFFFFF;
        border-radius: 24px;
        padding: 32px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }
    .modal-overlay.modal-visible .action-modal-card {
        transform: scale(1);
    }
    .modal-round-icon-frame {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        margin: 0 auto 16px auto;
    }
    .success-frame { background-color: #DCFCE7; color: #008236; }
    .danger-frame { background-color: #FFE2E2; color: #C10007; }
    .modal-main-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 12px;
        letter-spacing: -0.01em;
    }
    .modal-warning-body {
        font-size: 0.9rem;
        color: #71717A;
        line-height: 1.5;
        margin-bottom: 24px;
        font-weight: 500;
    }
    .modal-warning-body strong {
        color: #1A1A1A;
        font-weight: 700;
    }
    .modal-actions-footer {
        display: flex;
        gap: 12px;
    }
    .btn-modal-cancel {
        flex: 1;
        height: 44px;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: #4B5563;
        cursor: pointer;
    }
    .btn-modal-confirm {
        flex: 1;
        height: 44px;
        background-color: #008236;
        border: none;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: #FFFFFF;
        cursor: pointer;
    }
    .btn-modal-danger {
        flex: 1;
        height: 44px;
        background-color: #C10007;
        border: none;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: #FFFFFF;
        cursor: pointer;
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