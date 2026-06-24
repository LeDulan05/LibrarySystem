<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <button class="btn-add-member">
                        <span class="btn-plus-symbol">&#43;</span> Add Member
                    </button>
                    <div class="profile-avatar">LA</div>
                </div>
            </div>

            <div class="canvas-content">

                <div class="summary-metrics-grid">
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/totalMembersIcon.svg') }}" alt="Member">
                        <div class="sum-value">3,820</div>
                        <div class="sum-label">Total Members</div>
                    </div>
                        
                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/activeIcon.svg') }}" alt="Active">
                        <div class="sum-value">3,750</div>
                        <div class="sum-label">Active</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/suspendedIcon.svg') }}" alt="Suspended">
                        <div class="sum-value">45</div>
                        <div class="sum-label">Suspended</div>
                    </div>

                    <div class="summary-card">
                        <img src="{{ asset('AdminAssets/MemberAssets/newMemberIcon.svg') }}" alt="New Member">
                        <div class="sum-value">125</div>
                        <div class="sum-label">New This Month</div>
                    </div>
                </div>

                <div class="member-search-container">
                    <div class="search-box-wrapper">
                        <svg class="search-icon-svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" class="search-input" placeholder="Search members...">
                    </div>
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
                                <tr>
                                    <td>
                                        <div class="member-identity-cell">
                                            <div class="avatar-circle av-olive">Jd</div>
                                            <span class="member-fullname">Juan dela Cruz</span>
                                        </div>
                                    </td>
                                    <td class="mono-text">2024-00001</td>
                                    <td class="course-text">BS Computer Science</td>
                                    <td class="email-text">juan@university.edu</td>
                                    <td class="borrowed-count-cell">2</td>
                                    <td><span class="status-badge badge-success">Active</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="member-identity-cell">
                                            <div class="avatar-circle av-darkgreen">MS</div>
                                            <span class="member-fullname">Maria Santos</span>
                                        </div>
                                    </td>
                                    <td class="mono-text">2024-00002</td>
                                    <td class="course-text">BS Information Technology</td>
                                    <td class="email-text">maria@university.edu</td>
                                    <td class="borrowed-count-cell">0</td>
                                    <td><span class="status-badge badge-success">Active</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="member-identity-cell">
                                            <div class="avatar-circle av-forest">PR</div>
                                            <span class="member-fullname">Pedro Reyes</span>
                                        </div>
                                    </td>
                                    <td class="mono-text">2023-00045</td>
                                    <td class="course-text">BS Electronics Engineering</td>
                                    <td class="email-text">pedro@university.edu</td>
                                    <td class="borrowed-count-cell">1</td>
                                    <td><span class="status-badge badge-success">Active</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="member-identity-cell">
                                            <div class="avatar-circle av-olive">AL</div>
                                            <span class="member-fullname">Ana Lim</span>
                                        </div>
                                    </td>
                                    <td class="mono-text">2022-00134</td>
                                    <td class="course-text">BS Computer Science</td>
                                    <td class="email-text">ana@university.edu</td>
                                    <td class="borrowed-count-cell">3</td>
                                    <td><span class="status-badge badge-suspended">Suspended</span></td>
                                    <td class="actions-cell-row">
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                        <button class="action-btn"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

    /* Core Main Canvas Viewport Layout */
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
        flex-wrap: wrap; /* Allows wrap stacking natively on mobile screens */
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

    /* Add Member Action Button */
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

    /* Summary Analytic Metric Cards Responsive Auto-Fit Grid */
    .summary-metrics-grid {
        display: grid;
        /* auto-fit automatically wraps columns dynamically depending on available workspace width */
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
    .sum-icon-wrapper {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    .sum-svg-icon {
        width: 18px;
        height: 18px;
    }
    .sum-olive { background-color: #2E3A14; color: #FFFFFF; }
    .sum-green { background-color: #008236; color: #FFFFFF; }
    .sum-orange { background-color: #FF5722; color: #FFFFFF; }
    .sum-yellow { background-color: #A4C439; color: #FFFFFF; }

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

    /* Search Control Row Shell */
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
        width: 100%;
        position: relative;
    }
    .search-icon-svg {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 18px;
        height: 18px;
        color: #A1A1AA;
    }
    .search-input {
        width: 100%;
        padding: 12px 16px 12px 46px;
        background-color: #F4F1EA;
        border: none;
        border-radius: 12px;
        font-size: 0.925rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #1A1A1A;
        font-weight: 500;
        outline: none;
    }

    /* Core Directory Listing Table View Frame */
    .directory-panel {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 24px;
    }

    /* Swipe Box wrapper handling widescreen assets cleanly on compressed devices */
    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .directory-data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px; /* Forces structural consistency when width breaks down */
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

    /* Identity and Circular Avatar Structures */
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
    .course-text, .email-text {
        font-weight: 600;
    }
    .borrowed-count-cell {
        text-align: center;
        font-weight: 800;
        color: #1A1A1A;
        font-size: 0.95rem;
    }

    /* Custom Status Badges Matrix Context */
    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-success { background-color: #DCFCE7; color: #008236; }
    .badge-suspended { background-color: #FFE2E2; color: #C10007; }

    /* Operational Row Controls Actions Grid */
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
    .action-btn:hover {
        opacity: 0.7;
    }
    .action-btn img {
        width: 50px;
        height: 50px;
    }
</style>