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
                        <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? 'D', 0, 1)) }}</div>
                    @else
                        <div class="profile-avatar">JD</div>
                    @endif
                </div>
            </div>

            <div class="canvas-content">
                <div class="notifications-list">
                    
                    <!-- Notification Item 1 -->
                    <div class="notification-card unread">
                        <div class="notification-icon-circle text-green bg-green-light">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <span class="notification-title">Borrow Request — Approved</span>
                            </div>
                            <div class="notification-message">
                                <strong>"Introduction to Artificial Intelligence"</strong> — has been approved. Please pick it up within 3 days.
                            </div>
                            <div class="notification-date">Dec 10, 2024</div>
                        </div>
                        <div class="unread-dot"></div>
                    </div>

                    <!-- Notification Item 2 -->
                    <div class="notification-card unread">
                        <div class="notification-icon-circle text-yellow bg-yellow-light">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <span class="notification-title">Reservation — Pending</span>
                            </div>
                            <div class="notification-message">
                                <strong>"Clean Code"</strong> — is currently in queue (Position #2). You will be notified when available.
                            </div>
                            <div class="notification-date">Dec 8, 2024</div>
                        </div>
                        <div class="unread-dot"></div>
                    </div>

                    <!-- Notification Item 3 -->
                    <div class="notification-card">
                        <div class="notification-icon-circle text-red bg-red-light">
                            <i class="bi bi-x-circle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <span class="notification-title">Borrow Request — Rejected</span>
                            </div>
                            <div class="notification-message">
                                <strong>"Database System Concepts"</strong> — has been declined. Reason: Maximum borrow limit reached.
                            </div>
                            <div class="notification-date">Dec 1, 2024</div>
                        </div>
                    </div>

                    <!-- Notification Item 4 -->
                    <div class="notification-card">
                        <div class="notification-icon-circle text-green bg-green-light">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <div class="notification-header">
                                <span class="notification-title">Reservation — Approved</span>
                            </div>
                            <div class="notification-message">
                                <strong>"Python for Data Analysis"</strong> — has been approved. The book is now ready.
                            </div>
                            <div class="notification-date">Nov 28, 2024</div>
                        </div>
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
        overflow: hidden;
    }
    .layout-container {
        display: flex;
        height: 100vh;
        width: 100vw;
        overflow: hidden;
    }

    /* Main Content Area */
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
        border-color: #FFCCB3; /* Subtle orange tint for unread */
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
