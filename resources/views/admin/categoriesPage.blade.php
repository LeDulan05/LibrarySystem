<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <title>IskoLib - Categories</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Categories</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">

                <div class="control-row-container">
                    <form action="{{ route('admin.bookCategories') }}" method="GET" class="control-row" id="searchCategoryForm">
                        <div class="search-box-wrapper">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" name="search" class="search-input" placeholder="Search category..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit();">
                        </div>
                        
                        @if(request('search'))
                            <a href="{{ route('admin.bookCategories') }}" class="btn-reset-filters" style="text-decoration:none; display:flex; align-items:center; color:#FF5722; font-size:0.875rem; font-weight:700;">
                                Clear Search
                            </a>
                        @endif
                        
                        <div class="dropdown-wrapper-spacer"></div>
                        <div class="dropdown-wrapper-spacer"></div>
                    </form>
                </div>

                <div class="categories-panel">
                    <div class="table-responsive-wrapper">
                        <table class="categories-data-table">
                            <thead>
                                <tr>
                                    <th>CATEGORY NAME</th>
                                    <th>BOOK COUNT</th>
                                    <th style="width: 140px; text-align: center;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="cat-title-text">{{ $category->name }}</td>
                                        <td class="count-text">
                                            {{ $category->books_count }} 
                                            <span class="sub-count-label">{{ Str::plural('book', $category->books_count) }}</span>
                                        </td>
                                        <td class="actions-cell-row">
                                            <!-- ROUTE FIXED: Now routes to your custom single category layout view -->
                                            <a href="{{ route('admin.categories.show', $category->id) }}" class="action-btn-view">
                                                <img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View">
                                            </a>
                                            <button class="action-btn-edit"><img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit"></button>
                                            <button class="action-btn-delete"><img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete"></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center; color: #71717A; padding: 40px 0; font-weight: 600;">
                                            No collection categories match your search parameters.
                                        </td>
                                    </tr>
                                @endforelse
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

    /* Core Workspace Elements Styling Layout */
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

    .control-row-container {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 16px 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        width: 100%;
    }

    .control-row {
        display: flex;
        align-items: center;
        gap: 16px;
        width: 100%;
        flex-wrap: wrap; 
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
    .search-input::placeholder {
        color: #A1A1AA;
    }

    .dropdown-wrapper-spacer {
        flex: 1;
        min-width: 120px; 
    }

    .categories-panel {
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

    .categories-data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px; 
    }
    .categories-data-table th {
        background-color: #FDFBF7;
        font-size: 0.75rem;
        font-weight: 700;
        color: #71717A;
        letter-spacing: 0.06em;
        padding: 16px;
        border-bottom: 1px solid #F4F1EA;
        text-align: left;
    }
    .categories-data-table td {
        padding: 18px 16px;
        font-size: 0.875rem;
        color: #1A1A1A;
        border-bottom: 1px solid #F4F1EA;
        font-weight: 700;
        vertical-align: middle;
    }
    .categories-data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .cat-title-text {
        font-size: 0.95rem;
    }
    .count-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 0.95rem;
        color: #1A1A1A;
    }
    .sub-count-label {
        font-weight: 500;
        color: #A1A1AA;
        font-size: 0.875rem;
    }

    .actions-cell-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 16px;
    }
    .action-btn-view, .action-btn-edit, .action-btn-delete {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.15s ease;
    }
    .action-btn-view:hover, .action-btn-edit:hover, .action-btn-delete:hover {
        opacity: 0.7;
    }
    .action-btn-view img, .action-btn-edit img, .action-btn-delete img {
        width: 50px;
        height: 50px;
    }
</style>