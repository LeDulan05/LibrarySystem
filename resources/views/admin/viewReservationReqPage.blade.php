<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
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
                            <h2 class="mono-id-text">RES-{{ \Carbon\Carbon::parse($requestData->request_date)->year }}-{{ str_pad($requestData->id, 3, '0', STR_PAD_LEFT) }}</h2>
                        </div>
                        <span class="status-badge badge-{{ $requestData->status }}">{{ ucfirst($requestData->status) }}</span>
                    </div>

                    <div class="details-info-grid">
                        <div class="info-data-cell">
                            <span class="label-heading">MEMBER NAME</span>
                            <span class="value-text">{{ $requestData->member_name }}</span>
                        </div>
                        <div class="info-data-cell">
                            <span class="label-heading">STUDENT NUMBER</span>
                            <span class="value-text mono-text">{{ $requestData->student_number ?? 'N/A' }}</span>
                        </div>
                        <div class="info-data-cell grid-col-span-2">
                            <span class="label-heading">BOOK TITLE</span>
                            <span class="value-text book-title-highlight">{{ $requestData->book_title }}</span>
                        </div>
                        <div class="info-data-cell">
                            <span class="label-heading">ISBN</span>
                            <span class="value-text text-zinc">{{ $requestData->isbn ?? 'N/A' }}</span>
                        </div>
                        <div class="info-data-cell">
                            <span class="label-heading">RESERVED ON</span>
                            <span class="value-text text-zinc">{{ \Carbon\Carbon::parse($requestData->request_date)->format('M d, Y') }}</span>
                        </div>
                        @if($requestData->status === 'rejected' && isset($requestData->notes))
                        <div class="info-data-cell grid-col-span-2">
                            <span class="label-heading">REJECTION REASON</span>
                            <span class="value-text text-red">{{ $requestData->notes }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                @if($requestData->status === 'pending')
                <div class="actions-decision-row">
                    <button type="button" class="btn-decision-action btn-approve" onclick="openApproveModal()">
                        <i class="bi bi-check-circle"></i> Approve Reservation
                    </button>

                    <button type="button" class="btn-decision-action btn-reject" onclick="openRejectModal()">
                        <i class="bi bi-x-circle"></i> Reject Reservation
                    </button>
                </div>
                @elseif($requestData->status === 'approved')
                <div class="actions-decision-row" style="justify-content: center;">
                    <a href="{{ route('admin.reservation.receipt', $requestData->id) }}" class="btn-decision-action" style="flex: 0 1 auto; padding: 0 32px; background-color: #F4F1EA; color: #1A1A1A; text-decoration: none; border: 1px solid #EAE6DF;">
                        <i class="bi bi-printer"></i> View Receipt
                    </a>
                </div>
                @endif
            </div>
        </main>
    </div>

    <!-- Approve Modal -->
    <div class="modal-overlay" id="approveModalOverlay">
        <form action="{{ route('admin.reservation.approve', $requestData->id) }}" method="POST" class="suspend-modal-card">
            @csrf
            <div class="modal-round-icon-frame success-frame"><i class="bi bi-check-circle"></i></div>
            <h3 class="modal-main-title">Approve Reservation?</h3>
            <p class="modal-warning-body">Confirming this action will approve the reservation and set a 3-day hold window for the student to pick up the book.</p>
            
            <div style="width: 100%; background: #F9F6F0; border: 1px solid #EAE6DF; border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                <div class="info-grid-row" style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <span class="label" style="font-size: 0.85rem; font-weight: 600; color: #71717A;">Member</span>
                    <span class="value" style="font-size: 0.85rem; font-weight: 700; color: #1A1A1A;">{{ $requestData->member_name }}</span>
                </div>
                <div class="info-grid-row" style="display: flex; justify-content: space-between;">
                    <span class="label" style="font-size: 0.85rem; font-weight: 600; color: #71717A;">Book Title</span>
                    <span class="value" style="font-size: 0.85rem; font-weight: 700; color: #1A1A1A; text-align: right; max-width: 60%;">{{ $requestData->book_title }}</span>
                </div>
            </div>

            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeApproveModal()">Cancel</button>
                <button type="submit" class="btn-modal-confirm btn-approve-solid">Approve</button>
            </div>
        </form>
    </div>

    <!-- Reject Modal -->
    <div class="modal-overlay" id="rejectReasonModalOverlay">
        <form action="{{ route('admin.reservation.reject', $requestData->id) }}" method="POST" class="decision-modal-card" style="max-width: 480px;">
            @csrf
            <div class="modal-round-icon-frame danger-frame">
                <i class="bi bi-x-lg"></i>
            </div>
            
            <h3 class="modal-main-title">Reject Reservation?</h3>
            
            <div class="rejection-options-container">
                <span class="label-heading" style="margin-bottom: 16px; color: #1A1A1A;">Reason for Rejection</span>
                
                <label class="radio-option-row">
                    <input type="radio" name="reason" value="Maximum outstanding fine limit exceeded on user log context" required>
                    <span class="radio-text">Outstanding fine limit exceeded</span>
                </label>
                
                <label class="radio-option-row">
                    <input type="radio" name="reason" value="Selected physical media material missing structural integrity status check">
                    <span class="radio-text">Item unavailable / damaged</span>
                </label>
                
                <label class="radio-option-row">
                    <input type="radio" name="reason" value="Student profile restrictions applied based on chronological parameter checks">
                    <span class="radio-text">Account restricted / suspended</span>
                </label>
            </div>

            <div class="suggestion-notice-box">
                <i class="bi bi-lightbulb" style="margin-right: 6px;"></i> Choosing a reason permanently declines this reservation and notes the decision in the student's notifications log.
            </div>
            
            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn-modal-confirm btn-reject-solid">Confirm</button>
            </div>
        </form>
    </div>

    <script>
        function openApproveModal() { document.getElementById('approveModalOverlay').classList.add('modal-visible'); }
        function closeApproveModal() { document.getElementById('approveModalOverlay').classList.remove('modal-visible'); }
        
        function openRejectModal() { document.getElementById('rejectReasonModalOverlay').classList.add('modal-visible'); }
        function closeRejectModal() { document.getElementById('rejectReasonModalOverlay').classList.remove('modal-visible'); }
    </script>
</body>
</html>

<style>
    /* Baseline Overrides & Viewport Resets */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #1C1C1C; -webkit-font-smoothing: antialiased; }
    .layout-container { display: flex; height: 100vh; width: 100vw; overflow: hidden; }

    /* Main Canvas Context */
    .main-canvas { flex: 1; background-color: #F9F6F0; overflow-y: auto; display: flex; flex-direction: column; }
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; background-color: #FFFFFF; padding: 20px 40px; border-bottom: 1px solid #EAE6DF; }
    .canvas-content { padding: 32px 40px; flex: 1; }
    .dashboard-title { font-size: 1.5rem; font-weight: 800; color: #1A1A1A; }
    .profile-avatar { width: 40px; height: 40px; background-color: #212B05; color: white; font-weight: 700; font-size: 14px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

    /* Navigation */
    .back-navigation-link { font-size: 0.875rem; color: #71717A; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 24px; transition: color 0.15s; }
    .back-navigation-link:hover { color: #1A1A1A; }
    .left-arrow-chevron { font-size: 1.35rem; line-height: 1; font-weight: 500; margin-top: -2px; }

    /* Details Panel */
    .details-panel-wrapper { background-color: #FFFFFF; border: 1px solid #EAE6DF; border-radius: 16px; padding: 32px; margin-bottom: 24px; box-shadow: 0 2px 4px rgba(0,0,0,0.01); }
    .details-meta-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px; }
    
    .label-heading { font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase; display: block; margin-bottom: 8px; }
    .mono-id-text { font-family: 'JetBrains Mono', monospace; font-size: 1.15rem; font-weight: 700; color: #71717A; }
    .status-badge { padding: 6px 14px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
    .badge-pending { background-color: #FEF3C6; color: #BB4D00; }
    .badge-approved { background-color: #DCFCE7; color: #15803D; }
    .badge-rejected { background-color: #FEE2E2; color: #991B1B; }
    .badge-fulfilled { background-color: #DCFCE7; color: #15803D; }
    .badge-closed { background-color: #E5E7EB; color: #4B5563; }

    /* Grid Layout */
    .details-info-grid { display: grid; grid-template-columns: repeat(2, 1fr); row-gap: 28px; column-gap: 40px; }
    .grid-col-span-2 { grid-column: span 2; }
    .value-text { font-size: 0.95rem; font-weight: 700; color: #1A1A1A; display: block; }
    .book-title-highlight { font-size: 1.05rem !important; color: #212B05 !important; }
    .mono-text { font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; }
    .text-zinc { color: #71717A; font-weight: 600; }
    .text-green { color: #008236; font-weight: 800; }
    .text-red { color: #C10007; font-weight: 800; }

    /* Bottom Action Buttons */
    .actions-decision-row { display: flex; gap: 16px; width: 100%; }
    .btn-decision-action { flex: 1; height: 52px; border: none; border-radius: 12px; font-family: inherit; font-size: 0.95rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: opacity 0.15s; }
    .btn-decision-action:hover { opacity: 0.9; }
    .btn-approve { background-color: #008236; color: #FFFFFF; }
    .btn-reject { background-color: #C10007; color: #FFFFFF; }

    /* Modals System */
    .modal-overlay { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0, 0, 0, 0.4); display: none; align-items: center; justify-content: center; z-index: 10000; opacity: 0; transition: opacity 0.2s ease; }
    .modal-overlay.modal-visible { display: flex !important; opacity: 1; }
    
    .suspend-modal-card,
    .decision-modal-card { background-color: #FFFFFF; border-radius: 24px; padding: 40px 32px; width: 100%; max-width: 420px; box-shadow: 0 12px 40px rgba(0,0,0,0.15); text-align: center; display: flex; flex-direction: column; align-items: center; transform: scale(0.95); transition: transform 0.2s ease; }
    .modal-overlay.modal-visible .suspend-modal-card,
    .modal-overlay.modal-visible .decision-modal-card { transform: scale(1); }

    .modal-round-icon-frame { width: 64px; height: 64px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; margin-bottom: 24px; }
    .success-frame { background-color: #E6F4EA; color: #008236; }
    .danger-frame { background-color: #FFE2E2; color: #C10007; }

    .modal-main-title { font-size: 1.35rem; font-weight: 800; color: #1A1A1A; margin-bottom: 12px; letter-spacing: -0.01em; }
    .modal-warning-body { font-size: 0.9rem; color: #71717A; margin-bottom: 32px; line-height: 1.5; font-weight: 500; }

    /* Reject Modal Specifics */
    .rejection-options-container { width: 100%; text-align: left; margin-bottom: 20px; display: flex; flex-direction: column; gap: 16px; }
    .radio-option-row { display: flex; align-items: center; gap: 12px; cursor: pointer; }
    .radio-option-row input[type="radio"] { accent-color: #C10007; width: 18px; height: 18px; cursor: pointer; }
    .radio-text { font-size: 0.9rem; font-weight: 600; color: #4B5563; }

    .suggestion-notice-box { width: 100%; background-color: #FFFBEB; border: 1px solid #FDE68A; border-radius: 12px; padding: 16px; text-align: left; font-size: 0.825rem; font-weight: 600; color: #D97706; margin-bottom: 32px; line-height: 1.4; }

    /* Modal Buttons */
    .modal-actions-footer { width: 100%; display: flex; gap: 16px; }
    .btn-modal-cancel { flex: 1; height: 48px; background-color: #FFFFFF; border: 1px solid #E5E7EB; color: #4B5563; border-radius: 14px; font-size: 0.925rem; font-weight: 700; font-family: inherit; cursor: pointer; transition: background-color 0.15s; }
    .btn-modal-cancel:hover { background-color: #F9F6F0; color: #1A1A1A; }
    
    .btn-modal-confirm { flex: 1; height: 48px; border: none; border-radius: 14px; font-size: 0.925rem; font-weight: 700; font-family: inherit; color: #FFFFFF; cursor: pointer; transition: opacity 0.15s; }
    .btn-modal-confirm:hover { opacity: 0.9; }
    .btn-approve-solid { background-color: #008236; }
    .btn-reject-solid { background-color: #C10007; }
</style>