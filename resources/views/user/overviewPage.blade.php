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
    
    <title>IskoLib - Student Portal</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Overview</h1>
                <div class="header-right">
                    <a href="{{ url('/notifications') }}" class="notification-icon">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">2</span>
                    </a>
                    @if(Auth::check())
                        <a href="{{ route('profile.edit') }}" class="profile-avatar" style="text-decoration:none;">{{ strtoupper(substr(Auth::user()->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? 'D', 0, 1)) }}</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="profile-avatar" style="text-decoration:none;">JD</a>
                    @endif
                </div>
            </div>

            <div class="canvas-content">
                
                <!-- Welcome Banner -->
                <div class="welcome-banner">
                    <div class="welcome-content">
                        <p class="welcome-greeting">Welcome back,</p>
                        @if(Auth::check())
                            <h2 class="welcome-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                            <p class="welcome-details">{{ Auth::user()->course ?? 'BS Computer Science' }} &middot; Student ID: {{ Auth::user()->student_id ?? '2024-00001' }}</p>
                        @else
                            <h2 class="welcome-name">Juan dela Cruz</h2>
                            <p class="welcome-details">BS Computer Science &middot; Student ID: 2024-00001</p>
                        @endif
                        
                        <div class="welcome-notifications">
                            <i class="bi bi-bell-fill"></i>
                            <span>2 new notifications — tap to view</span>
                        </div>
                    </div>
                    <div class="welcome-graphic">
                        <i class="bi bi-stack" style="font-size: 8rem; opacity: 0.1; color: white;"></i>
                    </div>
                </div>

                <!-- Metrics Grid -->
                <div class="metrics-grid">
                    <div class="metric-card">
                        <div class="metric-icon-wrapper bg-orange">
                            <i class="bi bi-book"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-value">{{ $user->transactions->count() }}</div>
                            <div class="metric-label">Total Books Borrowed</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon-wrapper bg-blue">
                            <i class="bi bi-clock"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-value">{{ $user->transactions->where('status', 'active')->whereNotNull('due_date')->filter(fn($t) => \Carbon\Carbon::parse($t->due_date)->isPast() || \Carbon\Carbon::parse($t->due_date)->diffInDays(now()) <= 7)->count() }}</div>
                            <div class="metric-label">Books Due This Week</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon-wrapper bg-green">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-value">₱0.00</div>
                            <div class="metric-label">Penalty Amount</div>
                        </div>
                    </div>

                    <div class="metric-card">
                        <div class="metric-icon-wrapper bg-yellow">
                            <i class="bi bi-calendar"></i>
                        </div>
                        <div class="metric-info">
                            <div class="metric-value">{{ $user->reservations->where('status', 'pending')->count() }}</div>
                            <div class="metric-label">Pending Reservations</div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Section -->
                <div class="bottom-section">
                    <!-- Recent Activity -->
                    <div class="recent-activity-panel">
                        <div class="panel-header">
                            <h2>Recent Activity</h2>
                            <a href="{{ route('borrowed') }}" class="view-all-link">View All</a>
                        </div>
                        <div class="activity-list">
                            @php
                                $recentActivity = collect();
                                foreach($user->transactions as $t) {
                                    $recentActivity->push(['type' => 'borrow', 'item' => $t, 'date' => $t->created_at]);
                                }
                                foreach($user->reservations as $r) {
                                    $recentActivity->push(['type' => 'reserve', 'item' => $r, 'date' => $r->created_at]);
                                }
                                $recentActivity = $recentActivity->sortByDesc('date')->take(4);
                            @endphp

                            @forelse($recentActivity as $activity)
                                @php
                                    $item = $activity['item'];
                                    $isBorrow = $activity['type'] === 'borrow';
                                    
                                    if ($item->status === 'approved' || $item->status === 'active' || $item->status === 'returned' || $item->status === 'fulfilled') {
                                        $iconColor = 'text-green';
                                        $iconBg = 'bg-green-light';
                                        $icon = 'bi-check2';
                                        $badgeClass = 'badge-approved';
                                    } elseif ($item->status === 'pending') {
                                        $iconColor = 'text-yellow';
                                        $iconBg = 'bg-yellow-light';
                                        $icon = 'bi-clock';
                                        $badgeClass = 'badge-pending';
                                    } else {
                                        $iconColor = 'text-red';
                                        $iconBg = 'bg-red-light';
                                        $icon = 'bi-x';
                                        $badgeClass = 'badge-rejected';
                                    }
                                @endphp
                                <div class="activity-item">
                                    <div class="activity-icon-circle {{ $iconColor }} {{ $iconBg }}">
                                        <i class="bi {{ $icon }}"></i>
                                    </div>
                                    <div class="activity-details">
                                        <div class="activity-title">{{ $item->book->title }}</div>
                                        <div class="activity-meta">{{ $isBorrow ? 'Borrow' : 'Reservation' }} {{ ucfirst($item->status) }} &middot; {{ $item->created_at->format('M j, Y') }}</div>
                                    </div>
                                    <div class="activity-status {{ $badgeClass }}">{{ ucfirst($item->status) }}</div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500">No recent activity.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recommended Books -->
                    <div class="recommended-books-panel">
                        <h2>Recommended Books</h2>
                        <div class="books-list">
                            <div class="book-card">
                                <div class="book-cover bg-cover-blue">
                                    <div class="book-cover-title">Introduction to Artificial Intelligence</div>
                                    <div class="book-cover-author">Stuart Russell</div>
                                </div>
                                <div class="book-title">Introduction to Artificial...</div>
                                <div class="book-author">Stuart Russell</div>
                            </div>

                            <div class="book-card">
                                <div class="book-cover bg-cover-orange">
                                    <div class="book-cover-title">Clean Code: A Handbook of Agile Software</div>
                                    <div class="book-cover-author">Robert C. Martin</div>
                                </div>
                                <div class="book-title">Clean Code: A Handbook of...</div>
                                <div class="book-author">Robert C. Martin</div>
                            </div>

                            <div class="book-card">
                                <div class="book-cover bg-cover-purple">
                                    <div class="book-cover-title">Computer Networks</div>
                                    <div class="book-cover-author">Andrew S. Tanenbaum</div>
                                </div>
                                <div class="book-title">Computer Networks</div>
                                <div class="book-author">Andrew S. Tanenbaum</div>
                            </div>

                            <div class="book-card">
                                <div class="book-cover bg-cover-green">
                                    <div class="book-cover-title">Database System Concepts</div>
                                    <div class="book-cover-author">Abraham Silberschatz</div>
                                </div>
                                <div class="book-title">Database System...</div>
                                <div class="book-author">Abraham Silberschatz</div>
                            </div>
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
    }
    .notification-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        background-color: #FF5722;
        color: white;
        font-size: 0.6rem;
        font-weight: 700;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
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

    /* Welcome Banner */
    .welcome-banner {
        background-color: #E85D22;
        border-radius: 16px;
        padding: 32px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #FFFFFF;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(232, 93, 34, 0.15);
        position: relative;
        overflow: hidden;
    }
    .welcome-content {
        position: relative;
        z-index: 2;
    }
    .welcome-greeting {
        font-size: 0.9rem;
        font-weight: 500;
        opacity: 0.9;
        margin-bottom: 4px;
    }
    .welcome-name {
        font-size: 2.25rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }
    .welcome-details {
        font-size: 0.9rem;
        opacity: 0.85;
        font-weight: 500;
        margin-bottom: 20px;
    }
    .welcome-notifications {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 9999px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .welcome-notifications:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }
    .welcome-graphic {
        position: absolute;
        right: 40px;
        bottom: -20px;
        z-index: 1;
        transform: rotate(-10deg);
    }

    /* Metrics Grid */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    .metric-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .metric-icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 16px;
        color: white;
    }
    .bg-orange { background-color: #FF6B2C; }
    .bg-blue { background-color: #4F46E5; }
    .bg-green { background-color: #10B981; }
    .bg-yellow { background-color: #FBBF24; }
    
    .metric-info {
        display: flex;
        flex-direction: column;
    }
    .metric-value {
        font-family: 'DM Mono', monospace;
        font-size: 2rem; 
        font-weight: 500;
        color: #1A1A1A;
        line-height: 1;
        margin-bottom: 8px;
    }
    .metric-label {
        font-size: 0.875rem;
        color: #71717A;
        font-weight: 600;
    }

    /* Bottom Section */
    .bottom-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .recent-activity-panel, .recommended-books-panel {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 28px;
    }
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .recent-activity-panel h2, .recommended-books-panel h2 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1A1A1A;
        letter-spacing: -0.01em;
        margin-bottom: 0;
    }
    .recommended-books-panel h2 {
        margin-bottom: 24px;
    }
    .view-all-link {
        font-size: 0.875rem;
        color: #E85D22;
        font-weight: 700;
        text-decoration: none;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .activity-item {
        display: flex;
        align-items: center;
        padding: 16px;
        border: 1px solid #F4F1EA;
        border-radius: 12px;
        background-color: #FCFAf7;
    }
    .activity-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-right: 16px;
        flex-shrink: 0;
    }
    .text-green { color: #059669; }
    .bg-green-light { background-color: #D1FAE5; }
    .text-yellow { color: #D97706; }
    .bg-yellow-light { background-color: #FEF3C7; }
    .text-red { color: #DC2626; }
    .bg-red-light { background-color: #FEE2E2; }
    
    .activity-details {
        flex: 1;
    }
    .activity-title {
        font-size: 0.95rem;
        font-weight: 700;
        color: #27272A;
        margin-bottom: 4px;
    }
    .activity-meta {
        font-size: 0.8rem;
        color: #A1A1AA;
        font-weight: 500;
    }
    
    .activity-status {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
    }
    .badge-approved { background-color: #DCFCE7; color: #008236; }
    .badge-pending { background-color: #FEF3C6; color: #BB4D00; }
    .badge-rejected { background-color: #FFE2E2; color: #C10007; }

    /* Recommended Books */
    .books-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }
    .book-card {
        display: flex;
        flex-direction: column;
    }
    .book-cover {
        width: 100%;
        aspect-ratio: 3/4;
        border-radius: 8px;
        padding: 12px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 12px;
        color: white;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .book-cover-title {
        font-size: 0.75rem;
        font-weight: 800;
        margin-bottom: 8px;
        line-height: 1.2;
    }
    .book-cover-author {
        font-size: 0.6rem;
        opacity: 0.8;
    }
    
    .bg-cover-blue { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
    .bg-cover-orange { background: linear-gradient(135deg, #F97316, #C2410C); }
    .bg-cover-purple { background: linear-gradient(135deg, #A855F7, #7E22CE); }
    .bg-cover-green { background: linear-gradient(135deg, #10B981, #047857); }

    .book-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #27272A;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .book-author {
        font-size: 0.75rem;
        color: #71717A;
    }
</style>
