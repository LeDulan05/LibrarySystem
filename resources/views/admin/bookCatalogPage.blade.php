<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@100;200;400&display=swap" rel="stylesheet">    
    <title>IskoLib - Book Catalog</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Book Catalog</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">

                <div class="control-row-container">
                    <form action="{{ route('admin.bookCatalog') }}" method="GET" class="control-row" id="filterForm">
                        
                        <div class="search-box-wrapper">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" name="search" class="search-input" placeholder="Search books..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') this.form.submit();">
                        </div>

                        <div class="dropdown-wrapper">
                            <select name="category" class="custom-filter-dropdown" onchange="this.form.submit()">
                                <option value="all" {{ request('category') == 'all' ? 'selected' : '' }}>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="dropdown-wrapper">
                            <select name="status" class="custom-filter-dropdown" onchange="this.form.submit()">
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Status</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                        </div>

                        <a href="{{ route('admin.bookCatalog') }}" class="btn-export">
                            <span>Reset</span>
                        </a>
                    </form>
                </div>

                <div class="action-strip">
                    <a href="{{ route('admin.addBook') }}" class="btn-add-book" style="text-decoration: none;">
                        <span class="btn-plus-symbol">&#43;</span> Add New Book
                    </a>
                </div>

                <div class="catalog-panel">
                    <div class="table-responsive-wrapper">
                        <table class="catalog-data-table">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">ID</th>
                                    <th>TITLE</th>
                                    <th>AUTHOR</th>
                                    <th>CATEGORY</th>
                                    <th>STATUS</th>
                                    <th style="width: 100px; text-align: center;">ACTIONS</th>
                                </tr>
                            </thead>
                                <tbody>
                                    @foreach($books as $book)
                                        <tr>
                                            <td class="mono-text">#{{ str_pad($book->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td>
                                                <div class="book-title-cell">
                                                    <img src="{{ asset('AdminAssets/CatalogAssets/blueBookIcon.svg') }}" alt="Book" class="table-book-icon">
                                                    <span id="book-title-{{ $book->id }}">{{ $book->title }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $book->author }}</td>
                                            <td><span class="cat-badge badge-blue">{{ $book->category_name }}</span></td>
                                            <td>
                                                @if($book->available_copies > 0)
                                                    <span class="status-badge badge-success">Available ({{ $book->available_copies }})</span>
                                                @else
                                                    <span class="status-badge badge-due">Unavailable</span>
                                                @endif
                                            </td>
                                            <td class="actions-cell-row">
                                                <a href="{{ route('admin.editBook', $book->id) }}" class="action-btn-edit">
                                                    <img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit">
                                                </a>
                                                
                                                <form id="delete-form-{{ $book->id }}" action="{{ route('admin.bookCatalog.destroy', $book->id) }}" method="POST" style="display:none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>

                                                <button type="button" class="action-btn-delete" onclick="confirmDelete({{ $book->id }})">
                                                    <img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete">
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>

                    @if ($books->hasPages())
                        <div class="catalog-pagination-row">
                            <div class="pagination-info text-zinc">
                                Showing {{ $books->firstItem() }}-{{ $books->lastItem() }} of {{ $books->total() }}
                            </div>
                            <div class="pagination-nav">
                                @if ($books->onFirstPage())
                                    <span class="page-link disabled" style="opacity: 0.4; cursor: not-allowed;">&laquo;</span>
                                @else
                                    <a href="{{ $books->previousPageUrl() }}" class="page-link" style="text-decoration: none;">&laquo;</a>
                                @endif

                                @foreach ($books->getUrlRange(1, $books->lastPage()) as $page => $url)
                                    @if ($page == $books->currentPage())
                                        <span class="page-link active">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="page-link" style="text-decoration: none;">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($books->hasMorePages())
                                    <a href="{{ $books->nextPageUrl() }}" class="page-link" style="text-decoration: none;">&raquo;</a>
                                @else
                                    <span class="page-link disabled" style="opacity: 0.4; cursor: not-allowed;">&raquo;</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="catalog-pagination-row" style="justify-content: flex-start;">
                            <div class="pagination-info text-zinc">Total Books: {{ $books->total() }}</div>
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

/* Modal Overlay */
<div class="modal-overlay" id="deleteModalOverlay">
    <div class="delete-modal-card">
        <div class="modal-icon-header">
            <img src="{{ asset('AdminAssets/CatalogAssets/deleteBookConfirmationIcon.svg') }}" alt="Delete">
        </div>
        
        <h3 class="modal-main-title">Delete Book?</h3>
        <p class="modal-warning-body">
            Are you sure you want to delete <strong id="modalTargetBookTitle">"Book Title"</strong>? This cannot be undone.
        </p>
        
        <div class="modal-actions-footer">
            <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
            <button type="button" class="btn-modal-delete" id="modalConfirmDeleteBtn">Delete</button>
        </div>
    </div>
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
        margin-bottom: 20px;
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
        min-width: 240px; 
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

    .dropdown-wrapper {
        position: relative;
        flex: 1; 
        min-width: 170px;
    }
    .custom-filter-dropdown {
        width: 100%;
        height: 44px;
        padding: 0 36px 0 16px;
        background-color: #F4F1EA;
        border: none;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.875rem;
        font-weight: 600;
        color: #4B5563;
    }

    .custom-filter-dropdown:focus {
        background-color: #EAE6DF;
    }
    .custom-filter-dropdown option {
        background-color: #FFFFFF;
        color: #1A1A1A;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .btn-export {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0 24px;
        height: 44px;
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        cursor: pointer;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 0.875rem;
        color: #4B5563;
        flex-shrink: 0;
    }
    .btn-icon-svg {
        width: 16px;
        height: 16px;
    }

    /* Action Strip Resource Placement */
    .action-strip {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 24px;
    }
    .btn-add-book {
        background-color: #FF5722;
        color: #FFFFFF;
        border: none;
        padding: 12px 24px;
        border-radius: 14px;
        font-size: 0.875rem;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 10px rgba(255, 87, 34, 0.2);
    }
    .btn-plus-symbol {
        font-size: 1.15rem;
        font-weight: 500;
        line-height: 1;
    }

    .catalog-panel {
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

    .catalog-data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px; 
    }
    .catalog-data-table th {
        background-color: #FDFBF7;
        font-size: 0.75rem;
        font-weight: 700;
        color: #71717A;
        letter-spacing: 0.06em;
        padding: 16px;
        border-bottom: 1px solid #F4F1EA;
        text-align: left;
    }
    .catalog-data-table td {
        padding: 14px 16px;
        font-size: 0.875rem;
        color: #5A5A5A !important;
        border-bottom: 1px solid #F4F1EA;
        font-weight: 600;
        vertical-align: middle;
    }
    .catalog-data-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .mono-text {
        font-family: 'JetBrains Mono', monospace;
        font-weight: 200; 
        color: #A1A1A1 !important; 
        font-size: 0.825rem;
    }

    .book-title-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #1A1A1A;
        font-weight: 700;
    }
    .table-book-icon {
        width: 28px;
        height: 28px;
        flex-shrink: 0;
    }

    .cat-badge {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-blue { background-color: #EFF6FF; color: #2563EB; }
    .badge-light-blue { background-color: #E0F2FE; color: #0369A1; }
    .badge-medium-blue { background-color: #EEF2FF; color: #4F46E5; }
    .badge-dark-blue { background-color: #DBEAFE; color: #1D4ED8; }
    .badge-cyan { background-color: #E0F2FE; color: #0369A1; }
    .badge-teal { background-color: #F0FDF4; color: #16A34A; }

    .status-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        display: inline-block;
    }
    .badge-success { background-color: #DCFCE7; color: #008236; }
    .badge-due { background-color: #FFE2E2; color: #C10007; }

    .actions-cell-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    .action-btn-edit, .action-btn-delete {
        background: none;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.15s ease;
    }
    .action-btn-edit:hover, .action-btn-delete:hover {
        opacity: 0.7;
    }
    .action-btn-edit img, .action-btn-delete img {
        width: 50px;
        height: 50px;
    }

    .catalog-pagination-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 24px;
        padding-top: 12px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .text-zinc {
        color: #71717A;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 8px;
    }
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
    .page-link:hover {  
        background-color: #F4F1EA;
        color: #1A1A1A;
    }
    .page-link.active {
        background-color: #FF5722;
        color: #FFFFFF;
    }

.modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease;
    }
    .modal-overlay.modal-visible {
        opacity: 1;
        pointer-events: auto;
    }
    .delete-modal-card {
        background-color: #FFFFFF;
        border-radius: 24px;
        padding: 32px;
        width: 100%;
        max-width: 440px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
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

    .modal-main-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 12px;
        letter-spacing: -0.01em;
    }
    .modal-warning-body {
        font-size: 0.925rem;
        color: #71717A;
        line-height: 1.5;
        margin-bottom: 28px;
        font-weight: 500;
    }
    .modal-warning-body strong {
        color: #1A1A1A;
        font-weight: 700;
    }
    .modal-actions-footer {
        display: flex;
        gap: 12px;
    }
    .btn-modal-cancel {
        flex: 1;
        height: 48px;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.925rem;
        font-weight: 700;
        color: #4B5563;
        cursor: pointer;
    }
    .btn-modal-delete {
        flex: 1;
        height: 48px;
        background-color: #C10007;
        border: none;
        border-radius: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.925rem;
        font-weight: 700;
        color: #FFFFFF;
        cursor: pointer;
    }
</style>

<script>
    let activeDeleteFormId = null;

    function confirmDelete(bookId) {
        activeDeleteFormId = 'delete-form-' + bookId;
        
        const bookTitle = document.getElementById('book-title-' + bookId).innerText;
        document.getElementById('modalTargetBookTitle').innerText = `"${bookTitle}"`;
        
        document.getElementById('deleteModalOverlay').classList.add('modal-visible');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModalOverlay').classList.remove('modal-visible');
        activeDeleteFormId = null;
    }

    document.getElementById('modalConfirmDeleteBtn').addEventListener('click', function() {
        if(activeDeleteFormId) {
            document.getElementById(activeDeleteFormId).submit();
        }
    });
</script>