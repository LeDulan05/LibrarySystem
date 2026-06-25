@php
    $isRejected = isset($slip->status) && $slip->status === 'rejected';
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <title>IskoLib - Reservation Slip Summary</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">
                    {{ $isRejected ? 'Reservation Cancellation Notice' : 'Reservation Hold Slip' }}
                </h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">
                <a href="{{ route('admin.reservationRequest') }}" class="back-navigation-link">
                    <span class="left-arrow-chevron">&lsaquo;</span> Return to Registry Index
                </a>

                <div class="details-panel-wrapper print-surface" style="padding: 40px; background-color: #FFFFFF; border: 1px solid #EAE6DF; border-radius: 24px;">
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 2px dashed #EAE6DF; padding-bottom: 24px;">
                        <div>
                            <h2 style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; color: #212B05; margin-bottom: 4px;">IskoLib Circulation Desk</h2>
                            <p style="font-size: 0.8rem; color: #71717A; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">University Library System</p>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-size: 0.75rem; font-weight: 800; color: #A1A1AA; display: block;">TRANSACTION ID</span>
                            <span style="font-family: 'JetBrains Mono', monospace; font-weight: 700; color: #1A1A1A;">RES-{{ str_pad($slip->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>

                    @if($isRejected)
                        <div style="background-color: #FEE2E2; border: 1px solid #FCA5A5; padding: 20px; border-radius: 16px; margin-bottom: 32px;">
                            <h4 style="color: #991B1B; font-weight: 800; margin-bottom: 4px; font-size: 0.95rem;">Reservation Disapproved</h4>
                            <p style="color: #B91C1C; font-size: 0.875rem; font-weight: 600; line-height: 1.4;">
                                Reason: {{ $slip->notes ?? 'Administrative operational volume constraints.' }}
                            </p>
                        </div>
                    @else
                        <div style="background-color: #DCFCE7; border: 1px solid #BBF7D0; padding: 20px; border-radius: 16px; margin-bottom: 32px;">
                            <h4 style="color: #166534; font-weight: 800; margin-bottom: 4px; font-size: 0.95rem;">Book Hold Confirmed</h4>
                            <p style="color: #15803D; font-size: 0.875rem; font-weight: 600; line-height: 1.4;">
                                This physical material media is securely stored at the counter shelf and must be claimed before the expiration threshold date.
                            </p>
                        </div>
                    @endif

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px; margin-bottom: 40px;">
                        <div>
                            <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #71717A; text-transform: uppercase; margin-bottom: 6px;">Borrower Full Name</span>
                            <span style="font-size: 1rem; font-weight: 700; color: #1A1A1A;">{{ $slip->member_name }}</span>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #71717A; text-transform: uppercase; margin-bottom: 6px;">Student ID Account</span>
                            <span style="font-family: 'JetBrains Mono', monospace; font-size: 0.95rem; font-weight: 700; color: #1A1A1A;">{{ $slip->student_id ?? 'N/A' }}</span>
                        </div>
                        <div style="grid-column: span 2;">
                            <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #71717A; text-transform: uppercase; margin-bottom: 6px;">Reserved Book Title</span>
                            <span style="font-size: 1.1rem; font-weight: 800; color: #212B05;">{{ $slip->book_title }}</span>
                        </div>
                        <div>
                            <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #71717A; text-transform: uppercase; margin-bottom: 6px;">Initial Request Date</span>
                            <span style="font-size: 0.9rem; font-weight: 600; color: #4B5563;">{{ \Carbon\Carbon::parse($slip->request_date)->format('M d, Y h:i A') }}</span>
                        </div>
                        <div>
                            @if(!$isRejected && $slip->hold_expires_at)
                                <span style="display: block; font-size: 0.75rem; font-weight: 800; color: #71717A; text-transform: uppercase; margin-bottom: 6px; color: #C10007;">Hold Release Deadline</span>
                                <span style="font-size: 1rem; font-weight: 800; color: #C10007;">{{ \Carbon\Carbon::parse($slip->hold_expires_at)->format('F d, Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="action-footer-utility" style="display: flex; gap: 16px; border-top: 1px solid #EAE6DF; padding-top: 24px;">
                        <button onclick="window.print()" style="flex: 1; height: 48px; background-color: #212B05; border: none; border-radius: 12px; color: white; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="bi bi-printer"></i> Print Statement Summary
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #1C1C1C; }
    .layout-container { display: flex; height: 100vh; width: 100vw; overflow: hidden; }
    .main-canvas { flex: 1; background-color: #F9F6F0; overflow-y: auto; display: flex; flex-direction: column; }
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; background-color: #FFFFFF; padding: 20px 40px; border-bottom: 1px solid #EAE6DF; }
    .dashboard-title { font-size: 1.5rem; font-weight: 800; color: #1A1A1A; letter-spacing: -0.02em; }
    .profile-avatar { width: 40px; height: 40px; background-color: #212B05; color: white; font-weight: 700; font-size: 14px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .canvas-content { padding: 32px 40px; max-width: 700px; width: 100%; margin: 0 auto; }
    .back-navigation-link { font-size: 0.875rem; color: #71717A; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 24px; }
    
    @media print {
        .layout-container > *:not(.main-canvas), .dashboard-header, .back-navigation-link, .action-footer-utility { display: none !important; }
        body, .main-canvas { background: white !important; }
        .canvas-content { padding: 0 !important; max-width: 100% !important; }
        .print-surface { border: none !important; box-shadow: none !important; padding: 0 !important; }
    }
</style>