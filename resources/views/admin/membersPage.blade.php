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
    <title>IskoLib - Member Management</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Member Management</h1>
                <div class="header-right-actions">
                    <div class="profile-avatar">LA</div>
                </div>
            </div>

            <div class="canvas-content">

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/totalMembersIcon.svg') }}" alt="Member" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($totalMembersCount) }}</div>
                        <div class="sum-label">Total Members</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/activeIcon.svg') }}" alt="Active" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($activeCount) }}</div>
                        <div class="sum-label">Active</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/suspendedIcon.svg') }}" alt="Suspended" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($suspendedCount) }}</div>
                        <div class="sum-label">Suspended</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/newMemberIcon.svg') }}" alt="New Member" class="icon-wrapper">
                        <div class="sum-value">{{ number_format($newThisMonthCount) }}</div>
                        <div class="sum-label">New This Month</div>
                    </div>
                </div>

                <div class="member-search-container">
                    <form action="{{ route('admin.memberManagement') }}" method="GET" class="search-box-wrapper">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" class="search-input" placeholder="Search members..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit();">
                    </form>
                </div>

                <div class="directory-panel">
                    <div class="table-responsive-wrapper">
                        <table class="directory-data-table">
                            <thead>
                                <tr>
                                    <th>MEMBER</th>
                                    <th>STUDENT NO.</th>
                                    <th>COURSE</th>
                                    <th>EMAIL</th>
                                    <th style="text-align: center;">BORROWED</th>
                                    <th>STATUS</th>
                                    <th style="width: 120px; text-align: center;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $avatarColors = ['av-olive', 'av-darkgreen', 'av-forest']; @endphp
                                @forelse($members as $index => $member)
                                    <tr>
                                        <td>
                                            <div class="member-identity-cell">
                                                <div class="avatar-circle {{ $avatarColors[$member->id % 3] }}">
                                                    {{ strtoupper(substr($member->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr($member->last_name ?? 'D', 0, 1)) }}
                                                </div>
                                                <span class="member-fullname">{{ $member->first_name }} {{ $member->last_name }}</span>
                                            </div>
                                        </td>
                                        <td class="mono-text">{{ $member->student_number ?? 'N/A' }}</td>
                                        <td class="course-text">{{ $member->course ?? 'N/A' }}</td>
                                        <td class="email-text" style="text-transform: lowercase;">{{ $member->email }}</td>
                                        <td class="borrowed-count-cell">{{ $member->borrowed_count }}</td>
                                        <td>
                                            <span class="status-badge {{ ($member->status ?? 'active') == 'active' ? 'badge-success' : 'badge-suspended' }}">
                                                {{ ucfirst($member->status ?? 'active') }}
                                            </span>
                                        </td>
                                        <td class="actions-cell-row">
                                            <a href="{{ route('admin.members.show', $member->id) }}" class="action-btn">
                                                <img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View">
                                            </a>
                                            
                                            <button class="action-btn" onclick="openDeleteModal({{ $member->id }}, '{{ $member->first_name }} {{ $member->last_name }}', '{{ $member->student_id ?? 'N/A' }}')">
                                                <img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete">
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="empty-table-text-row" style="text-align: center; padding: 40px 0; color: #71717A; font-weight: 600;">No members match your criteria.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($members->hasPages())
                        <div class="catalog-pagination-row">
                            <div class="pagination-info text-zinc">
                                Showing {{ $members->firstItem() }}-{{ $members->lastItem() }} of {{ $members->total() }}
                            </div>
                            <div class="pagination-nav">
                                @if ($members->onFirstPage())
                                    <span class="page-link disabled" style="opacity: 0.4; cursor: not-allowed;">&laquo;</span>
                                @else
                                    <a href="{{ $members->previousPageUrl() }}" class="page-link" style="text-decoration: none;">&laquo;</a>
                                @endif

                                @foreach ($members->getUrlRange(1, $members->lastPage()) as $page => $url)
                                    @if ($page == $members->currentPage())
                                        <span class="page-link active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-link" style="text-decoration: none;">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($members->hasMorePages())
                                    <a href="{{ $members->nextPageUrl() }}" class="page-link" style="text-decoration: none;">&raquo;</a>
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

    <div class="modal-overlay" id="deleteMemberModalOverlay">
        <form id="deleteMemberForm" action="" method="POST" class="suspend-modal-card">
            @csrf
            @method('DELETE')
            <div class="modal-round-icon-frame">
                <i class="bi bi-trash3"></i>
            </div>

            <h3 class="modal-main-title">Delete Member</h3>
            <p class="modal-warning-body">This will permanently remove the member and all their associated records.</p>

            <div class="modal-info-grid-box">
                <div class="info-grid-row">
                    <span class="label">Member</span>
                    <span class="value" id="deleteModalMemberName">—</span>
                </div>
                <div class="info-grid-row">
                    <span class="label">Student ID</span>
                    <span class="value" id="deleteModalStudentId">—</span>
                </div>
            </div>

            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="btn-modal-delete">Delete</button>
            </div>
        </form>
    </div>

    <script>
        function openDeleteModal(memberId, memberName, studentId) {
            document.getElementById('deleteModalMemberName').textContent = memberName;
            document.getElementById('deleteModalStudentId').textContent = studentId;
            document.getElementById('deleteMemberForm').action = '/admin/members/' + memberId;
            document.getElementById('deleteMemberModalOverlay').classList.add('modal-visible');
        }

        function closeDeleteModal() {
            document.getElementById('deleteMemberModalOverlay').classList.remove('modal-visible');
        }
    </script>
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

    /* Main Content */
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
    .header-right-actions {
        display: flex;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .btn-add-member {
        background-color: #FF5722;
        color: #FFFFFF;
        border: none;
        padding: 10px 20px;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 10px rgba(255, 87, 34, 0.2);
    }
    .btn-plus-symbol {
        font-size: 1.1rem;
        line-height: 1;
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

    /* Summary Analytic Metric Cards */
    .icon-wrapper {
        width: 42px;
        height: 42px;
        margin-bottom: 16px;
    }
    
    .summary-metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }
    .summary-card {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 20px 24px;
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
        flex: 2; 
        position: relative; 
        display: flex;
        align-items: center;
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

    .directory-panel {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
    }
    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .directory-data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px; 
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

    .member-identity-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .avatar-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #FFFFFF;
        flex-shrink: 0;
    }
    .av-olive { background-color: #2E3A14; }
    .av-darkgreen { background-color: #1A2605; }
    .av-forest { background-color: #3E4C1C; }

    .member-fullname {
        font-size: 0.9rem;
        font-weight: 700;
        color: #1A1A1A;
    }
    .mono-text {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 400;
        font-size: 0.85rem;
    }
    .course-text, .email-text { font-weight: 600; }
    .borrowed-count-cell {
        text-align: center;
        font-weight: 800;
        color: #1A1A1A;
        font-size: 0.95rem;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-success { background-color: #DCFCE7; color: #008236; }
    .badge-suspended { background-color: #FFE2E2; color: #C10007; }

    .actions-cell-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 14px;
    }
    .action-btn {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.15s ease;
    }
    .action-btn:hover { opacity: 0.7; }
    .action-btn img { width: 40px; height: 40px; }

    .catalog-pagination-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        padding-top: 12px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .text-zinc { color: #71717A; font-size: 0.85rem; font-weight: 600; }
    .pagination-nav { display: flex; align-items: center; gap: 8px; }
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
    .page-link:hover { background-color: #F4F1EA; color: #1A1A1A; }
    .page-link.active { background-color: #FF5722; color: #FFFFFF; }

    /* Modal Backdrop Layer */
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
        z-index: 10000;
    }
    .modal-overlay.modal-visible {
        display: flex !important;
    }

    /* Modal Surface Card */
    .suspend-modal-card {
        background-color: #FFFFFF;
        border-radius: 16px;
        padding: 32px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .modal-round-icon-frame {
        width: 56px;
        height: 56px;
        background-color: #FFE2E2;
        color: #C10007;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 16px;
    }
    .modal-main-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 8px;
    }
    .modal-warning-body {
        font-size: 0.875rem;
        color: #71717A;
        margin-bottom: 24px;
        line-height: 1.4;
        padding: 0 16px;
    }

    /* Info Field Rows Box */
    .modal-info-grid-box {
        width: 100%;
        background-color: #FAF8F5;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #F4F1EA;
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        text-align: left;
    }
    .info-grid-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
    }
    .info-grid-row .label {
        font-weight: 600;
        color: #71717A;
    }
    .info-grid-row .value {
        font-weight: 600;
        color: #52525B;
    }

    /* Modal Action Buttons */
    .modal-actions-footer {
        width: 100%;
        display: flex;
        gap: 12px;
    }
    .btn-modal-cancel {
        flex: 1;
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        color: #1A1A1A;
        border-radius: 12px;
        padding: 12px;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: background-color 0.15s;
    }
    .btn-modal-cancel:hover {
        background-color: #F9F6F0;
    }
    .btn-modal-delete {
        flex: 1;
        background-color: #C10007;
        border: none;
        color: #FFFFFF;
        border-radius: 12px;
        padding: 12px;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        transition: background-color 0.15s;
    }
    .btn-modal-delete:hover {
        background-color: #A00005;
    }
</style>