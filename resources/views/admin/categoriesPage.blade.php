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
                                        <td class="cat-title-text" id="cat-name-{{ $category->id }}">{{ $category->name }}</td>
                                        <td class="count-text" id="cat-count-{{ $category->id }}" data-raw-count="{{ $category->books_count }}">
                                            {{ $category->books_count }} 
                                            <span class="sub-count-label">{{ Str::plural('book', $category->books_count) }}</span>
                                        </td>
                                        <td class="actions-cell-row">
                                            <a href="{{ route('admin.categories.show', $category->id) }}" class="action-btn-view">
                                                <img src="{{ asset('AdminAssets/CategoriesAssets/viewIcon.svg') }}" alt="View">
                                            </a>
                                            
                                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="action-btn-edit">
                                                <img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit">
                                            </a>
                                            
                                            <button type="button" class="action-btn-delete" onclick="triggerDeleteModal({{ $category->id }})">
                                                <img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete">
                                            </button>
                                            
                                            <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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

    <!-- DELETE CATEGORY INTERACTIVE CONFIRMATION MODAL -->
    <div class="modal-overlay" id="deleteCategoryModalOverlay">
        <div class="delete-modal-card">
            <div class="modal-icon-header">
                <div class="modal-round-icon-frame">
                    <i class="bi bi-trash3-fill"></i>
                </div>
            </div>
            
            <h3 class="modal-main-title">Delete Category</h3>
            <p class="modal-warning-body">
                Are you sure you want to delete this category? This action cannot be undone.
            </p>
            
            <div class="category-meta-summary-box">
                <div class="summary-box-row">
                    <span class="summary-box-label">Category</span>
                    <span class="summary-box-value font-extrabold" id="modalTargetCategoryName">Artificial Intelligence</span>
                </div>
                <div class="summary-box-row">
                    <span class="summary-box-label">Books</span>
                    <span class="summary-box-value" id="modalTargetBookCountStatus">0 &mdash; safe to delete</span>
                </div>
            </div>
            
            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="btn-modal-delete" id="modalConfirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>

    <script>
        let activeDeleteFormId = null;

        function triggerDeleteModal(categoryId) {
            activeDeleteFormId = 'delete-form-' + categoryId;
            
            const categoryName = document.getElementById('cat-name-' + categoryId).innerText;
            const bookCount = parseInt(document.getElementById('cat-count-' + categoryId).getAttribute('data-raw-count')) || 0;
            
            document.getElementById('modalTargetCategoryName').innerText = categoryName;
            
            const statusElement = document.getElementById('modalTargetBookCountStatus');
            if (bookCount === 0) {
                statusElement.innerHTML = '<span class="status-safe">0 &mdash; safe to delete</span>';
            } else {
                statusElement.innerHTML = `<span class="status-warning">${bookCount} ${bookCount === 1 ? 'book' : 'books'} remaining</span>`;
            }
            
            document.getElementById('deleteCategoryModalOverlay').classList.add('modal-visible');
        }

        function closeDeleteModal() {
            document.getElementById('deleteCategoryModalOverlay').classList.remove('modal-visible');
            activeDeleteFormId = null;
        }

        document.getElementById('modalConfirmDeleteBtn').addEventListener('click', function() {
            if (activeDeleteFormId) {
                document.getElementById(activeDeleteFormId).submit();
            }
        });
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

    /* Modal Context Style Overrides (image_23ed88.png / image_23eda5.png) */
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
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .modal-overlay.modal-visible {
        display: flex;
        opacity: 1;
    }
    .delete-modal-card {
        background-color: #FFFFFF;
        border-radius: 28px;
        padding: 36px;
        width: 100%;
        max-width: 460px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        text-align: center;
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }
    .modal-overlay.modal-visible .delete-modal-card {
        transform: scale(1);
    }
    .modal-icon-header {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }
    .modal-round-icon-frame {
        width: 64px;
        height: 64px;
        background-color: #FFE2E2;
        color: #C10007;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }
    .modal-main-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 12px;
        letter-spacing: -0.01em;
    }
    .modal-warning-body {
        font-size: 0.95rem;
        color: #71717A;
        line-height: 1.5;
        margin-bottom: 24px;
        font-weight: 500;
    }
    .category-meta-summary-box {
        background-color: #FDFBF7;
        border: 1px solid #F4F1EA;
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 28px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        text-align: left;
    }
    .summary-box-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.925rem;
    }
    .summary-box-label {
        font-weight: 600;
        color: #71717A;
    }
    .summary-box-value {
        font-weight: 700;
        color: #1A1A1A;
    }
    .status-safe {
        color: #008236;
        font-weight: 700;
    }
    .status-warning {
        color: #C10007;
        font-weight: 700;
    }
    .modal-actions-footer {
        display: flex;
        gap: 14px;
    }
    .btn-modal-cancel {
        flex: 1;
        height: 48px;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 700;
        color: #4B5563;
        cursor: pointer;
        transition: background-color 0.15s;
    }
    .btn-modal-cancel:hover {
        background-color: #F9FAFB;
    }
    .btn-modal-delete {
        flex: 1;
        height: 48px;
        background-color: #C10007;
        border: none;
        border-radius: 14px;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 700;
        color: #FFFFFF;
        cursor: pointer;
        transition: background-color 0.15s;
    }
    .btn-modal-delete:hover {
        background-color: #A30005;
    }
</style>