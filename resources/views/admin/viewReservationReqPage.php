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
    <title>IskoLib - Reservation Details</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Reservation Details</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">
                
                <a href="{{ route('admin.reservationRequest') }}" class="back-navigation-link">
                    <span class="left-arrow-chevron">&lsaquo;</span> Back to Reservations
                </a>

                <div class="details-panel-wrapper">
                    <div class="details-meta-header">
                        <div class="request-id-block">
                            <span class="label-heading">RESERVATION ID</span>
                            <h2 class="mono-id-text">
                                RES-{{ \Carbon\Carbon::parse($requestData->created_at)->year }}-{{ str_pad($requestData->id, 3, '0', STR_PAD_LEFT) }}
                            </h2>
                        </div>
                        <span class="status-badge badge-{{ $requestData->status }}">{{ ucfirst($requestData->status) }}</span>
                    </div>

                    <div class="details-info-grid">
                        <div class="info-data-cell">
                            <span class="label-heading">MEMBER NAME</span>
                            <span class="value-text" id="member-name-text">{{ $requestData->member_name }}</span>
                        </div>
                        
                        <div class="info-data-cell">
                            <span class="label-heading">STUDENT NUMBER</span>
                            <span class="value-text mono-id-text" style="font-size: 0.95rem;">{{ $requestData->student_number ?? 'N/A' }}</span>
                        </div>

                        <div class="info-data-cell grid-col-span-2">
                            <span class="label-heading">BOOK TITLE</span>
                            <span class="value-text book-title-highlight" id="book-title-text">{{ $requestData->book_title }}</span>
                        </div>

                        <div class="info-data-cell">
                            <span class="label-heading">ISBN</span>
                            <span class="value-text text-zinc">{{ $requestData->isbn ?? 'N/A' }}</span>
                        </div>

                        <div class="info-data-cell">
                            <span class="label-heading">AVAILABLE COPIES</span>
                            <span class="value-text copies-count-text {{ $requestData->available_copies > 0 ? 'text-green' : 'text-red' }}">
                                {{ $requestData->available_copies }}
                            </span>
                        </div>

                        <div class="info-data-cell">
                            <span class="label-heading">RESERVATION DATE</span>
                            <span class="value-text">{{ \Carbon\Carbon::parse($requestData->reservation_date ?? $requestData->created_at)->format('M d, Y') }}</span>
                        </div>

                        <div class="info-data-cell">
                            <span class="label-heading">PICKUP EXPIRATION WINDOW</span>
                            <span class="value-text">
                                {{ $requestData->hold_expires_at ? \Carbon\Carbon::parse($requestData->hold_expires_at)->format('M d, Y') : 'Pending Hold' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($requestData->status === 'pending')
                    <div class="actions-decision-row">
                        <button type="button" class="btn-decision-action btn-approve-action" onclick="openApproveModal()">
                            <i class="bi bi-check-circle"></i> Approve Request
                        </button>

                        <button type="button" class="btn-decision-action btn-reject-action" onclick="openRejectModal()">
                            <i class="bi bi-x-circle"></i> Reject Request
                        </button>
                    </div>
                @endif

            </div>
        </main>
    </div>

    <div class="modal-overlay" id="approveReservationModalOverlay">
        <form action="{{ route('admin.reservation.approve', $requestData->id) }}" method="POST" class="action-modal-card">
            @csrf
            <div class="modal-round-icon-frame success-frame"><i class="bi bi-check-circle"></i></div>
            <h3 class="modal-main-title">Approve Reservation Request?</h3>
            <p class="modal-warning-body">
                Confirm approval for <strong>{{ $requestData->member_name }}</strong> to reserve <strong>"{{ $requestData->book_title }}"</strong>.
            </p>
            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeApproveModal()">Cancel</button>
                <button type="submit" class="btn-modal-confirm">Confirm</button>
            </div>
        </form>
    </div>

    <div class="modal-overlay" id="rejectReservationModalOverlay">
        <form action="{{ route('admin.reservation.reject', $requestData->id) }}" method="POST" class="action-modal-card">
            @csrf
            <div class="modal-round-icon-frame danger-frame"><i class="bi bi-x-circle"></i></div>
            <h3 class="modal-main-title">Reject Reservation? Request</h3>
            <p class="modal-warning-body">
                Reject reservation for <strong>{{ $requestData->member_name }}</strong> &mdash; <strong>"{{ $requestData->book_title }}"</strong>?
            </p>
            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn-modal-danger">Reject</button>
            </div>
        </form>
    </div>

    <script>
        function openApproveModal() {
            document.getElementById('approveReservationModalOverlay').classList.add('modal-visible');
        }
        function closeApproveModal() {
            document.getElementById('approveReservationModalOverlay').classList.remove('modal-visible');
        }
        function openRejectModal() {
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
    .back-navigation-link {
        font-size: 0.875rem;
        color: #71717A;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 24px;
        width: max-content;
        transition: color 0.15s ease;
    }
    .back-navigation-link:hover {
        color: #1A1A1A;
    }
    .left-arrow-chevron {
        font-size: 1.35rem;
        line-height: 1;
        font-weight: 500;
        margin-top: -2px;
    }
    .details-panel-wrapper {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 32px;
        margin-bottom: 24px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
    }
    .details-meta-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #F4F1EA;
        padding-bottom: 24px;
        margin-bottom: 28px;
    }
    .label-heading {
        font-size: 0.725rem;
        font-weight: 800;
        color: #A1A1AA;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        display: block;
        margin-bottom: 6px;
    }
    .mono-id-text {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.15rem;
        font-weight: 700;
        color: #2E3A14;
    }
    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-pending { background-color: #FEF3C6; color: #BB4D00; }
    .badge-approved { background-color: #DCFCE7; color: #008236; }
    .badge-rejected { background-color: #FFE2E2; color: #C10007; }
    .details-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        row-gap: 28px;
        column-gap: 40px;
    }
    .grid-col-span-2 {
        grid-column: span 2;
    }
    .value-text {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1A1A1A;
        display: block;
    }
    .book-title-highlight {
        font-size: 1.05rem;
        font-weight: 800;
        color: #1A1A1A;
    }
    .text-zinc {
        color: #71717A;
    }
    .copies-count-text {
        font-size: 1.05rem;
        font-weight: 800;
    }
    .text-green { color: #008236; }
    .text-red { color: #C10007; }
    .actions-decision-row {
        display: flex;
        gap: 16px;
        width: 100%;
    }
    .btn-decision-action {
        flex: 1;
        height: 48px;
        border: none;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.925rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: opacity 0.15s ease;
    }
    .btn-decision-action:hover {
        opacity: 0.9;
    }
    .btn-approve-action {
        background-color: #008236;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(0, 130, 54, 0.15);
    }
    .btn-reject-action {
        background-color: #C10007;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(193, 0, 7, 0.15);
    }
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.5);
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
</style>