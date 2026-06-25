@php
    // Automatically detect whether the controller sent $slip or $rejection
    $data = $slip ?? $rejection;
    $isRejected = isset($data->status) && $data->status === 'rejected';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <title>IskoLib - Borrow Request Summary</title>
</head>

<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">
                    {{ $isRejected ? 'Rejection Summary Notice' : 'Borrow Transaction Slip' }}
                </h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content" style="max-width: 600px; margin: 0 auto;">
                <a href="{{ route('admin.borrowRequest') }}" class="back-navigation-link">
                    <span class="left-arrow-chevron">&lsaquo;</span> Back to Requests
                </a>

                <div class="details-panel-wrapper" style="text-align: center; padding: 40px 32px;">
                    
                    @if($isRejected)
                        <div class="modal-round-icon-frame danger-frame" style="background-color: #FFE2E2; color: #C10007; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 16px auto;">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #1A1A1A; margin-bottom: 6px;">Request Declined</h2>
                        <p style="font-size: 0.9rem; color: #71717A; font-weight: 500; margin-bottom: 32px;">This borrow request has been rejected and logged in the system archiving ledger.</p>
                    @else
                        <div class="modal-round-icon-frame success-frame" style="background-color: #DCFCE7; color: #008236; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 16px auto;">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <h2 style="font-size: 1.5rem; font-weight: 800; color: #1A1A1A; margin-bottom: 6px;">Borrow Request Approved</h2>
                        <p style="font-size: 0.9rem; color: #71717A; font-weight: 500; margin-bottom: 32px;">The borrow request transaction code has been recorded into the system ledger logs.</p>
                    @endif

                    <div class="slip-details-box" style="background-color: #F9F6F0; border: 1px dashed #EAE6DF; border-radius: 16px; padding: 24px; margin-bottom: 32px; text-align: left;">
                        
                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px; border-bottom: 1px solid #EAE6DF; padding-bottom: 12px;">
                            <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase;">Borrow ID</span>
                            <span class="mono-text" style="font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #2E3A14;">
                                BRW-{{ str_pad($data->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase;">Borrower</span>
                            <span style="font-size: 0.9rem; font-weight: 700; color: #1A1A1A;">{{ $data->member_name }}</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase;">Student ID</span>
                            <span class="mono-text" style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; font-weight: 700; color: #1A1A1A;">{{ $data->student_id ?? 'N/A' }}</span>
                        </div>

                        <div style="margin-bottom: 16px;">
                            <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase;">Book Title</span>
                            <span style="font-size: 0.9rem; font-weight: 700; color: #1A1A1A; display: block; margin-top: 2px;">{{ $data->book_title }}</span>
                        </div>

                        <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                            <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase;">ISBN</span>
                            <span class="mono-text" style="font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; font-weight: 700; color: #71717A;">{{ $data->isbn ?? 'N/A' }}</span>
                        </div>

                        @if($isRejected)
                            <div style="margin-top: 16px; padding-top: 16px; border-top: 1px dashed #EAE6DF;">
                                <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #C10007; letter-spacing: 0.05em; text-transform: uppercase; display: flex; align-items: center; gap: 4px;">
                                    <i class="bi bi-exclamation-octagon-fill"></i> Reason for Decline
                                </span>
                                <p style="font-size: 0.9rem; font-weight: 600; color: #7F1D1D; margin-top: 4px; line-height: 1.5;">
                                    {{ $data->rejection_reason ?? 'No administrative reason specified.' }}
                                </p>
                            </div>
                        @else
                            <div style="display: flex; justify-content: space-between; margin-bottom: 16px; border-top: 1px dashed #EAE6DF; padding-top: 16px;">
                                <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase;">Borrow Date</span>
                                <span style="font-size: 0.9rem; font-weight: 700; color: #1A1A1A;">{{ \Carbon\Carbon::parse($data->borrow_date)->format('M d, Y') }}</span>
                            </div>

                            <div style="display: flex; justify-content: space-between;">
                                <span class="label-heading" style="font-size: 0.725rem; font-weight: 800; color: #A1A1AA; letter-spacing: 0.05em; text-transform: uppercase;">Due Date</span>
                                <span style="font-size: 0.9rem; font-weight: 700; color: #C10007;">{{ \Carbon\Carbon::parse($data->due_date)->format('M d, Y') }}</span>
                            </div>
                        @endif
                    </div>

                    @if($isRejected)
                        <div class="suggestion-notice-box" style="background-color: #FEF2F2; border: 1px solid #FCA5A5; border-radius: 12px; padding: 16px; text-align: left; font-size: 0.825rem; font-weight: 600; color: #991B1B; margin-bottom: 32px; line-height: 1.4;">
                            <i class="bi bi-info-circle-fill" style="margin-right: 6px;"></i> The member will be notified of this denial sequence. The reserved inventory slot has been released back into the available library catalog.
                        </div>
                    @else
                        <div class="suggestion-notice-box" style="background-color: #EFF6FF; border: 1px solid #BFDBFE; border-radius: 12px; padding: 16px; text-align: left; font-size: 0.825rem; font-weight: 600; color: #1D4ED8; margin-bottom: 32px; line-height: 1.4;">
                            <i class="bi bi-info-circle-fill" style="margin-right: 6px;"></i> Please remind the member to return the physical copy on or before the designated due date to avoid accumulating account penalties.
                        </div>
                    @endif

                    <div class="modal-actions-footer" style="display: flex; gap: 16px;">
                        <a href="{{ route('admin.borrowRequest') }}" class="btn-modal-cancel" style="flex: 1; height: 48px; background-color: #FFFFFF; border: 1px solid #E5E7EB; color: #4B5563; border-radius: 14px; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: background-color 0.15s;">
                            Done
                        </a>
                        
                        @if(!$isRejected)
                            <button type="button" class="btn-modal-confirm" onclick="window.print()" style="flex: 1; height: 48px; background-color: #212B05; border: none; color: #FFFFFF; border-radius: 14px; font-size: 0.9rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: opacity 0.15s;">
                                <i class="bi bi-printer"></i> Print Slip
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        </main>
    </div>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #1C1C1C; }
        .layout-container { display: flex; height: 100vh; width: 100vw; overflow: hidden; }
        .main-canvas { flex: 1; background-color: #F9F6F0; overflow-y: auto; display: flex; flex-direction: column; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; background-color: #FFFFFF; padding: 20px 40px; border-bottom: 1px solid #EAE6DF; }
        .canvas-content { padding: 32px 40px; flex: 1; }
        .dashboard-title { font-size: 1.5rem; font-weight: 800; color: #1A1A1A; letter-spacing: -0.02em; }
        .profile-avatar { width: 40px; height: 40px; background-color: #212B05; color: white; font-weight: 700; font-size: 14px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .back-navigation-link { font-size: 0.875rem; color: #71717A; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 24px; width: max-content; }
        .left-arrow-chevron { font-size: 1.35rem; font-weight: 500; margin-top: -2px; }
        .details-panel-wrapper { background-color: #FFFFFF; border: 1px solid #EAE6DF; border-radius: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .btn-modal-cancel:hover { background-color: #F9FAFB; }
        .btn-modal-confirm:hover { opacity: 0.9; }

        @media print {
            .layout-container > *:not(.main-canvas), .dashboard-header, .back-navigation-link, .suggestion-notice-box, .modal-actions-footer { display: none !important; }
            body, .main-canvas { background: white !important; }
            .canvas-content { padding: 0 !important; margin: 0 !important; max-width: 100% !important; }
            .details-panel-wrapper { border: none !important; box-shadow: none !important; padding: 0 !important; }
            .slip-details-box { border: 1px solid #000 !important; background: white !important; }
        }
    </style>
</body>
</html>