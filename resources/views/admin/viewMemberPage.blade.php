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
    <title>IskoLib - Member Profile</title>

</head>

<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Member Profile</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">
                
                <a href="{{ route('admin.memberManagement') }}" class="back-navigation-link">
                    <span class="left-arrow-chevron">&lsaquo;</span> Back to Members
                </a>

                <div class="profile-layout-grid">
                    
                    <div class="left-profile-sidebar-wrapper">
                        
                        <div class="profile-meta-card">
                            <div class="avatar-circle-display">
                                {{ strtoupper(substr($member->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'D', 0, 1)) }}
                            </div>
                            
                            <span class="member-fullname">{{ $member->first_name }} {{ $member->last_name }}</span>
                            <span class="course-text">{{ $member->course ?? 'Not Provided' }}</span>
                            
                            @if(($member->status ?? 'active') == 'active')
                                <span class="status-badge badge-success">Active</span>
                            @else
                                <span class="status-badge badge-suspended">Suspended</span>
                            @endif
                            
                            <div class="metadata-rows-strip">
                                <div class="metadata-row">
                                    <span class="meta-label">Student No.</span>
                                    <span class="meta-value mono-text">{{ $member->student_number ?? 'N/A' }}</span>
                                </div>
                                <div class="metadata-row">
                                    <span class="meta-label">Year Level</span>
                                    <span class="meta-value">{{ $member->year_level ?? 'N/A' }}</span>
                                </div>
                                <div class="metadata-row">
                                    <span class="meta-label">Email</span>
                                    <span class="meta-value" style="text-transform: lowercase;">{{ $member->email }}</span>
                                </div>
                                <div class="metadata-row">
                                    <span class="meta-label">Phone</span>
                                    <span class="meta-value">{{ $member->phone ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="current-borrowed-panel-card">
                            <h3 class="panel-card-subtitle">Current Borrowed Books</h3>
                            <div class="borrowed-badges-stack">
                                @forelse($currentBorrowed as $book)
                                    <div class="active-borrow-book-badge">
                                        <i class="bi bi-book book-badge-icon"></i>
                                        <span class="active-badge-title-text">{{ $book->title }}</span>
                                    </div>
                                @empty
                                    <div class="empty-table-text-row" style="font-size: 0.825rem; padding: 12px 0 !important;">No books currently checked out.</div>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div class="right-history-tables-wrapper">
                        
                        <div class="directory-panel">
                            <h3 class="panel-card-subtitle">Borrow History</h3>
                            <div class="table-responsive-wrapper">
                                <table class="directory-data-table">
                                    <thead>
                                        <tr>
                                            <th>BOOK</th>
                                            <th>BORROWED</th>
                                            <th>RETURNED</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($borrowHistory as $log)
                                            <tr>
                                                <td class="table-book-title-text">{{ $log->title }}</td>
                                                <td class="mono-text">{{ \Carbon\Carbon::parse($log->borrow_date)->format('M d, Y') }}</td>
                                                <td class="mono-text">{{ $log->return_date ? \Carbon\Carbon::parse($log->return_date)->format('M d, Y') : '&mdash;' }}</td>
                                                <td>
                                                    @if($log->status == 'returned')
                                                        <span class="status-badge badge-success">Returned</span>
                                                    @else
                                                        <span class="status-badge badge-active">Active</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="empty-table-text-row">No borrow history records found on file.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="directory-panel">
                            <h3 class="panel-card-subtitle">Penalty History</h3>
                            <div class="table-responsive-wrapper">
                                <table class="directory-data-table">
                                    <thead>
                                        <tr>
                                            <th>BOOK</th>
                                            <th>AMOUNT</th>
                                            <th>DATE</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($penaltyHistory as $penalty)
                                            <tr>
                                                <td class="table-book-title-text">{{ $penalty->title }}</td>
                                                <td class="currency-text">₱{{ number_format($penalty->amount, 2) }}</td>
                                                <td class="mono-text">{{ \Carbon\Carbon::parse($penalty->date)->format('M d, Y') }}</td>
                                                <td>
                                                    @if($penalty->status == 'paid')
                                                        <span class="status-badge badge-success">Paid</span>
                                                    @else
                                                        <span class="status-badge badge-suspended">Due</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="empty-table-text-row">No penalty metrics registered on file.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
        /* Baseline Overrides & Viewport Resets */
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

        /* Main Canvas Context */
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

        /* Back Navigation Link */
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

        /* Grid System Split */
        .profile-layout-grid {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 24px;
            align-items: start;
            width: 100%;
        }
        .left-profile-sidebar-wrapper, .right-history-tables-wrapper {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Card Container Panel Blocks */
        .profile-meta-card, .current-borrowed-panel-card, .directory-panel {
            background-color: #FFFFFF;
            border: 1px solid #EAE6DF;
            border-radius: 16px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        }

        /* Profile Left Meta Sidebar Card */
        .profile-meta-card {
            padding: 32px 24px;
            text-align: center;
        }
        .avatar-circle-display {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #FFFFFF;
            margin: 0 auto 16px auto;
            background-color: #2E3A14; 
        }
        .member-fullname {
            font-size: 1.15rem;
            font-weight: 800;
            color: #1A1A1A;
            margin-bottom: 4px;
            display: block;
        }
        .course-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #71717A;
            display: block;
            margin-bottom: 16px;
        }

        /* Metadata Details List Block Structure */
        .metadata-rows-strip {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 24px;
            text-align: left;
            border-top: 1px solid #F4F1EA;
            padding-top: 20px;
        }
        .metadata-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
        }
        .meta-label {
            font-weight: 700;
            color: #71717A;
        }
        .meta-value {
            font-weight: 600;
            color: #1A1A1A;
        }

        /* Current Checked-out Shelf Cards List */
        .current-borrowed-panel-card {
            padding: 24px;
        }
        .panel-card-subtitle {
            font-size: 0.9rem;
            font-weight: 800;
            color: #1A1A1A;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .borrowed-badges-stack {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .active-borrow-book-badge {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 14px;
            background-color: #F4F1EA;
            border-radius: 12px;
            border: 1px solid #EAE6DF;
        }
        .book-badge-icon {
            color: #71717A;
            font-size: 1rem;
        }
        .active-badge-title-text {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1A1A1A;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Right Panel History Content Cards */
        .directory-panel {
            padding: 24px;
        }

        /* Table Resets & Typography Foundations */
        .table-responsive-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .directory-data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px; 
        }
        .directory-data-table th {
            background-color: #FDFBF7;
            font-size: 0.75rem;
            font-weight: 700;
            color: #71717A;
            letter-spacing: 0.06em;
            padding: 16px;
            border-bottom: 1px solid #F4F1EA;
            text-align: left;
        }
        .directory-data-table td {
            padding: 14px 16px;
            font-size: 0.875rem;
            color: #71717A;
            border-bottom: 1px solid #F4F1EA;
            font-weight: 500;
            vertical-align: middle;
        }
        .directory-data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Unique Cell Modifiers */
        .table-book-title-text {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1A1A1A;
        }
        .mono-text {
            font-family: 'JetBrains Mono', monospace;
            font-weight: 400;
            font-size: 0.85rem;
        }
        .currency-text {
            font-weight: 800;
            color: #FF5722;
            font-size: 0.95rem;
        }

        /* Custom Dynamic Status Capsule Matrix Context */
        .status-badge {
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }
        .badge-success { background-color: #DCFCE7; color: #008236; }
        .badge-suspended { background-color: #FFE2E2; color: #C10007; }
        .badge-active { background-color: #EFF6FF; color: #2563EB; }

        .empty-table-text-row {
            text-align: center;
            color: #71717A;
            padding: 32px 0 !important;
            font-weight: 600;
        }
    </style>