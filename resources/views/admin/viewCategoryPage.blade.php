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
    <title>IskoLib - Category Details</title>

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

        /* Core Canvas Layout Context Framing */
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

        /* Back Navigation Typography Link Anchor Controls */
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

        /* 1. Preview Shelf Structural Layout Panel Elements */
        .preview-shelf-panel {
            background-color: #FFFFFF;
            border: 1px solid #EAE6DF;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.01);
        }
        .panel-section-heading {
            font-size: 0.95rem;
            font-weight: 800;
            color: #1A1A1A;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .books-shelf-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .shelf-book-card {
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .book-cover-image, .book-cover-fallback {
            width: 100%;
            aspect-ratio: 2/3;
            border-radius: 8px 12px 12px 8px;
            position: relative;
            box-shadow: 2px 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 8px;
        }
        .book-cover-image {
            background-size: cover;
            background-position: center;
        }
        .book-cover-fallback {
            padding: 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
        }
        .fallback-title {
            font-size: 0.75rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 4px;
        }
        .fallback-author {
            font-size: 0.65rem;
            opacity: 0.8;
        }
        
        .shelf-availability-badge {
            position: absolute;
            top: 8px;
            right: 8px;
        }
        .availability-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: block;
            border: 1.5px solid white;
        }
        .dot-available { background-color: #4ADE80; }
        .dot-unavailable { background-color: #F87171; }
        
        .shelf-title {
            font-size: 0.825rem;
            font-weight: 700;
            color: #1A1A1A;
            margin-bottom: 2px;
        }
        .shelf-author {
            font-size: 0.75rem;
            font-weight: 600;
        }
        .empty-shelf-text {
            grid-column: 1 / -1;
            text-align: center;
            padding: 24px 0;
            color: #71717A;
            font-size: 0.875rem;
            font-weight: 600;
        }
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* 2. Core Workspace Tables Panels Elements */
        .catalog-panel {
            background-color: #FFFFFF;
            border: 1px solid #EAE6DF;
            border-radius: 16px;
            padding: 24px;
        }
        .table-title-search-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        /* Search Input System */
        .search-box-wrapper {
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

        /* Responsive Tables Elements */
        .table-responsive-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .categories-data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px; 
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
            text-transform: uppercase;
        }
        .categories-data-table td {
            padding: 14px 16px;
            font-size: 0.875rem;
            color: #5A5A5A !important;
            border-bottom: 1px solid #F4F1EA;
            font-weight: 700;
            vertical-align: middle;
        }
        .categories-data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cat-title-text { font-size: 0.9rem; color: #1A1A1A; }
        .count-text { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 0.875rem; color: #1A1A1A; }
        .mono-text { font-family: 'JetBrains Mono', monospace; font-weight: 200; color: #A1A1A1 !important; font-size: 0.825rem; }
        
        .book-title-cell { display: flex; align-items: center; gap: 12px; }
        .table-mini-book-color { width: 16px; height: 22px; border-radius: 3px; flex-shrink: 0; box-shadow: 1px 2px 4px rgba(0,0,0,0.05); }

        /* Library Asset Gradient Styles Mapping */
        .bg-cover-blue { background: linear-gradient(135deg, #3B82F6, #2563EB); }
        .bg-cover-orange { background: linear-gradient(135deg, #F97316, #EA580C); }
        .bg-cover-purple { background: linear-gradient(135deg, #A855F7, #9333EA); }
        .bg-cover-green { background: linear-gradient(135deg, #10B981, #059669); }
        .bg-cover-red { background: linear-gradient(135deg, #EF4444, #DC2626); }
        .bg-cover-yellow { background: linear-gradient(135deg, #D97706, #B45309); }

        .status-badge { padding: 6px 14px; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-block; }
        .badge-success { background-color: #DCFCE7; color: #008236; }
        .badge-due { background-color: #FFE2E2; color: #C10007; }

        /* Actions Controllers Asset Placements */
        .actions-cell-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
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
        .action-btn-edit:hover, .action-btn-delete:hover { opacity: 0.7; }
        .action-btn-edit img, .action-btn-delete img { width: 50px; height: 50px; }

        /* System Pagination Listing Controls interface elements */
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

        /* FIXED MODAL BASELINE: Uses display: none by default to completely block flashes */
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
            border-radius: 24px; 
            padding: 32px; 
            width: 100%; 
            max-width: 440px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); 
            text-align: center; 
            transform: scale(0.95); 
            transition: transform 0.2s ease;
        }
        .modal-overlay.modal-visible .delete-modal-card { transform: scale(1); }
        .modal-icon-header { display: flex; justify-content: center; margin-bottom: 20px; }
        .modal-main-title { font-size: 1.35rem; font-weight: 800; color: #1A1A1A; margin-bottom: 12px; letter-spacing: -0.01em; }
        .modal-warning-body { font-size: 0.925rem; color: #71717A; line-height: 1.5; margin-bottom: 28px; font-weight: 500; }
        .modal-warning-body strong { color: #1A1A1A; font-weight: 700; }
        .modal-actions-footer { display: flex; gap: 12px; }
        .btn-modal-cancel { flex: 1; height: 48px; background-color: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 14px; font-family: inherit; font-size: 0.925rem; font-weight: 700; color: #4B5563; cursor: pointer; }
        .btn-modal-delete { flex: 1; height: 48px; background-color: #C10007; border: none; border-radius: 14px; font-family: inherit; font-size: 0.925rem; font-weight: 700; color: #FFFFFF; cursor: pointer; }
    </style>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarAdmin')
        <main class="main-canvas">
            
            <div class="dashboard-header">
                <h1 class="dashboard-title">Category: {{ $category->name }}</h1>
                <div class="profile-avatar">LA</div>
            </div>

            <div class="canvas-content">
                
                <a href="{{ route('admin.bookCategories') }}" class="back-navigation-link">
                    <span class="left-arrow-chevron">&lsaquo;</span> Back to Categories
                </a>

                <div class="preview-shelf-panel">
                    <h2 class="panel-section-heading">Book Shelf Preview</h2>
                    <div class="books-shelf-grid">
                        @php
                            $coverClasses = ['bg-cover-blue', 'bg-cover-orange', 'bg-cover-purple', 'bg-cover-green', 'bg-cover-red', 'bg-cover-yellow'];
                        @endphp
                        @forelse($books as $index => $book)
                            @php
                                $colorClass = $coverClasses[$book->id % count($coverClasses)];
                            @endphp
                            <div class="shelf-book-card">
                                @if($book->book_cover)
                                    <div class="book-cover-image" style="background-image: url('{{ asset('storage/' . $book->book_cover) }}');">
                                        <div class="shelf-availability-badge">
                                            <span class="availability-dot {{ $book->available_copies > 0 ? 'dot-available' : 'dot-unavailable' }}"></span>
                                        </div>
                                    </div>
                                @else
                                    <div class="book-cover-fallback {{ $colorClass }}">
                                        <div class="shelf-availability-badge">
                                            <span class="availability-dot {{ $book->available_copies > 0 ? 'dot-available' : 'dot-unavailable' }}"></span>
                                        </div>
                                        <div class="fallback-title">{{ $book->title }}</div>
                                        <div class="fallback-author">{{ $book->author }}</div>
                                    </div>
                                @endif
                                <div class="shelf-title text-truncate">{{ $book->title }}</div>
                                <div class="shelf-author text-zinc text-truncate">{{ $book->author }}</div>
                            </div>
                        @empty
                            <div class="empty-shelf-text">No book cover previews available for this category collection.</div>
                        @endforelse
                    </div>
                </div>

                <div class="catalog-panel">
                    <div class="table-title-search-row">
                        <h2 class="panel-section-heading" style="margin-bottom: 0;">
                            Books in "{{ $category->name }}" &mdash; {{ $books->total() }} total
                        </h2>
                        
                        <form action="{{ url()->current() }}" method="GET" class="table-inline-search-form">
                            <div class="search-box-wrapper" style="min-width: 260px;">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" name="search" class="search-input" placeholder="Search books within genre.." value="{{ request('search') }}">
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive-wrapper">
                        <table class="categories-data-table">
                            <thead>
                                <tr>
                                    <th style="width: 90px;">ID</th>
                                    <th>TITLE</th>
                                    <th>AUTHOR</th>
                                    <th>YEAR</th>
                                    <th style="text-align: center; width: 100px;">COPIES</th>
                                    <th style="text-align: center; width: 120px;">AVAILABLE</th>
                                    <th>STATUS</th>
                                    <th style="width: 140px; text-align: center;">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                    <tr>
                                        <td class="mono-text">#{{ str_pad($book->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="cat-title-text" style="font-weight: 700;">
                                            <div class="book-title-cell">
                                                <div class="table-mini-book-color {{ $coverClasses[$book->id % count($coverClasses)] }}"></div>
                                                <span id="book-title-{{ $book->id }}">{{ $book->title }}</span>
                                            </div>
                                        </td>
                                        <td class="count-text" style="font-weight: 500; font-size: 0.875rem;">{{ $book->author }}</td>
                                        <td class="mono-text">{{ $book->year_published ?? 'N/A' }}</td>
                                        <td class="count-text" style="text-align: center;">{{ $book->total_copies }}</td>
                                        <td class="count-text" style="text-align: center; color: #008236;">{{ $book->available_copies }}</td>
                                        <td>
                                            @if($book->available_copies > 0)
                                                <span class="status-badge badge-success">Available</span>
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
                            <div class="text-zinc" style="font-size: 0.85rem; font-weight: 600;">
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
                    @endif
                </div>

            </div>
        </main>
    </div>

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
</body>
</html>