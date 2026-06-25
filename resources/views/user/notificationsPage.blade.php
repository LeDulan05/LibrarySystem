<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <title>IskoLib - Notifications</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Notifications</h1>
                <div class="header-right">
                    <a href="{{ url('/notifications') }}" class="notification-icon">
                        <i class="bi bi-bell"></i>
                    </a>
                    @if(Auth::check())
                        <a href="{{ route('profile.edit') }}" class="profile-avatar" style="text-decoration:none;">{{ strtoupper(substr(Auth::user()->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? 'D', 0, 1)) }}</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="profile-avatar" style="text-decoration:none;">JD</a>
                    @endif
                </div>
            </div>

            <div class="canvas-content">
                <div class="notifications-list">
                    @forelse($notifications as $notification)
                    @php
                        // Determine icon and colors based on status
                        if (in_array($notification['status'], ['active', 'fulfilled', 'returned'])) {
                            $colorClass = 'text-green bg-green-light';
                            $iconClass = 'bi-check-circle';
                            $statusTitle = 'Approved / Processed';
                        } elseif (in_array($notification['status'], ['pending'])) {
                            $colorClass = 'text-yellow bg-yellow-light';
                            $iconClass = 'bi-clock';
                            $statusTitle = 'Pending';
                        } else {
                            $colorClass = 'text-red bg-red-light';
                            $iconClass = 'bi-x-circle';
                            $statusTitle = ucfirst($notification['status']);
                        }
                    @endphp
                    <div class="notification-card {{ $notification['is_unread'] ? 'unread' : '' }}">
                        <div class="notification-icon-circle {{ $colorClass }}">
                            <i class="bi {{ $iconClass }}"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <span class="notification-title">{{ $notification['type'] }} — {{ $statusTitle }}</span>
                            </div>
                            <div class="notification-message">
                                <strong>"{{ $notification['book_title'] }}"</strong> — {{ $notification['message'] }}
                            </div>
                            <div class="notification-date">{{ \Carbon\Carbon::parse($notification['date'])->format('M j, Y - g:i A') }}</div>
                        </div>
                        @if($notification['is_unread'])
                            <div class="unread-dot"></div>
                        @endif
                    </div>
                    @empty
                        <div class="text-sm text-gray-500 text-center py-8">You have no notifications at this time.</div>
                    @endforelse

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
    
    .dashboard-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.02em;
    }

    .header-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .notification-icon {
        position: relative;
        font-size: 1.25rem;
        color: #52525B;
        cursor: pointer;
        text-decoration: none;
    }

    .profile-avatar {
        width: 40px;
        height: 40px;
        background-color: #E85D22;
        color: white;
        font-weight: 700;
        font-size: 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .canvas-content {
        padding: 32px 40px;
        flex: 1;
        max-width: 1400px;
        margin: 0 auto;
        width: 100%;
    }

    /* Notifications List */
    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .notification-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        align-items: flex-start;
        position: relative;
    }
    .notification-card.unread {
        border-color: #FFCCB3; 
    }

    .notification-icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 24px;
        flex-shrink: 0;
    }

    .text-green { color: #059669; }
    .bg-green-light { background-color: #D1FAE5; }
    .text-yellow { color: #D97706; }
    .bg-yellow-light { background-color: #FEF3C7; }
    .text-red { color: #DC2626; }
    .bg-red-light { background-color: #FEE2E2; }

    .notification-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 4px;
    }

    .notification-title {
        font-size: 1rem;
        font-weight: 800;
        color: #1A1A1A;
    }

    .notification-message {
        font-size: 0.9rem;
        color: #52525B;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .notification-message strong {
        color: #27272A;
        font-weight: 700;
    }

    .notification-date {
        font-size: 0.75rem;
        color: #A1A1AA;
        font-weight: 500;
    }

    .unread-dot {
        width: 8px;
        height: 8px;
        background-color: #E85D22;
        border-radius: 50%;
        position: absolute;
        top: 24px;
        right: 24px;
        display: none;
    }
    .notification-card.unread .unread-dot {
        display: block;
    }

</style>
