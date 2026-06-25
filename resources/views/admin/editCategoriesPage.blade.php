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
    <title>IskoLib - Edit Category Details</title>
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

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="edit-category-panel">
                    @csrf
                    @method('PUT')

                    <h2 class="form-section-title">Edit Category Details</h2>

                    <div class="input-entry-group">
                        <label class="field-entry-label">Category Name</label>
                        <input type="text" name="name" class="form-text-input" value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="input-entry-group">
                        <label class="field-entry-label">Description</label>
                        <textarea name="description" class="form-textarea-input" rows="4" placeholder="Enter collection genre meta details...">{{ old('description', $category->description ?? '') }}</textarea>
                    </div>

                    <div class="summary-metrics-grid">
                        <div class="summary-card flex-row-layout">
                            <img src="{{ asset('AdminAssets/CategoriesAssets/totalBooksIcon.svg') }}" alt="Total Books" class="icon-wrapper" style="width: 44px; height: 44px; margin-bottom: 0;">
                            <div>
                                <div class="sum-value">{{ number_format($books->total()) }}</div>
                                <div class="sum-label">Total Books</div>
                            </div>
                        </div>
                        <div class="summary-card flex-row-layout">
                            <img src="{{ asset('AdminAssets/CategoriesAssets/availableIcon.svg') }}" alt="Available" class="icon-wrapper" style="width: 44px; height: 44px; margin-bottom: 0;">
                            <div>
                                <div class="sum-value">{{ number_format($books->where('available_copies', '>', 0)->count()) }}</div>
                                <div class="sum-label">Available</div>
                            </div>
                        </div>
                        <div class="summary-card flex-row-layout">
                            <img src="{{ asset('AdminAssets/CategoriesAssets/checkedOutIcon.svg') }}" alt="Checked Out" class="icon-wrapper" style="width: 44px; height: 44px; margin-bottom: 0;">
                            <div>
                                <div class="sum-value">{{ number_format($books->where('available_copies', '==', 0)->count()) }}</div>
                                <div class="sum-label">Checked Out</div>
                            </div>
                        </div>
                    </div>

                    <div class="preview-shelf-panel">
                        <h3 class="panel-inner-heading">Book Shelf Preview</h3>
                        <div class="books-shelf-grid">
                            @php
                                $coverClasses = [
                                    'AdminAssets/CatalogAssets/blueBookIcon.svg',
                                    'AdminAssets/CatalogAssets/orangeBookIcon.svg',
                                    'AdminAssets/CatalogAssets/greenBookIcon.svg',
                                    'AdminAssets/CatalogAssets/purpleBookIcon.svg'
                                ];
                            @endphp
                            @forelse($books as $book)
                                <div class="shelf-book-card">
                                    @if($book->book_cover)
                                        <div class="book-cover-image" style="background-image: url('{{ asset('storage/' . $book->book_cover) }}');"></div>
                                    @else
                                        <div class="book-cover-fallback {{ $coverClasses[$book->id % count($coverClasses)] }}">
                                            <div class="fallback-title text-truncate">{{ $book->title }}</div>
                                            <div class="fallback-author text-truncate">{{ $book->author }}</div>
                                        </div>
                                    @endif
                                    <div class="shelf-title text-truncate">{{ $book->title }}</div>
                                </div>
                            @empty
                                <div class="empty-shelf-text">No shelf previews logged on file for this target parameter.</div>
                            @endforelse
                        </div>
                    </div>

                    <div class="catalog-panel">
                        <div class="table-title-search-row">
                            <h3 class="panel-inner-heading">Books in "{{ $category->name }}" &mdash; {{ $books->total() }} total</h3>
                        </div>

                        <div class="table-responsive-wrapper">
                            <table class="categories-data-table">
                                <thead>
                                    <tr>
                                        <th style="width: 90px;">ID</th>
                                        <th>TITLE</th>
                                        <th>AUTHOR</th>
                                        <th>YEAR</th>
                                        <th style="text-align: center;">COPIES</th>
                                        <th style="text-align: center;">AVAILABLE</th>
                                        <th>STATUS</th>
                                        <th style="width: 120px; text-align: center;">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                        <tr>
                                            <td class="mono-text">#{{ str_pad($book->id, 4, '0', STR_PAD_LEFT) }}</td>
                                            <td class="cat-title-text">
                                                <div class="book-title-cell">
                                                    <div class="table-mini-book-color {{ $coverClasses[$book->id % count($coverClasses)] }}"></div>
                                                    <span id="book-title-{{ $book->id }}">{{ $book->title }}</span>
                                                </div>
                                            </td>
                                            <td style="font-weight: 500;">{{ $book->author }}</td>
                                            <td class="mono-text">{{ $book->year_published ?? 'N/A' }}</td>
                                            <td style="text-align: center;">{{ $book->total_copies }}</td>
                                            <td style="text-align: center; color: #008236;">{{ $book->available_copies }}</td>
                                            <td>
                                                <span class="status-badge {{ $book->available_copies > 0 ? 'badge-success' : 'badge-due' }}">
                                                    {{ $book->available_copies > 0 ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </td>
                                            <td class="actions-cell-row">
                                                <a href="{{ route('admin.editBook', $book->id) }}" class="action-btn-edit">
                                                    <img src="{{ asset('AdminAssets/CatalogAssets/editIcon.svg') }}" alt="Edit">
                                                </a>
                                                <button type="button" class="action-btn-delete" onclick="confirmDelete({{ $book->id }})">
                                                    <img src="{{ asset('AdminAssets/CatalogAssets/deleteIcon.svg') }}" alt="Delete">
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-decision-footer-row">
                        <a href="{{ route('admin.bookCategories') }}" class="btn-footer-cancel">Cancel</a>
                        <button type="submit" class="btn-footer-save">Save Changes</button>
                    </div>
                </form>

            </div>
        </main>
    </div>

    <div class="modal-overlay" id="deleteModalOverlay">
        <div class="delete-modal-card">
            <div class="modal-icon-header">
                <i class="bi bi-trash3-fill warning-trash-icon"></i>
            </div>
            <h3 class="modal-main-title">Delete Book?</h3>
            <p class="modal-warning-body">Are you sure you want to delete <strong id="modalTargetBookTitle">"Book"</strong>? This cannot be undone.</p>
            <div class="modal-actions-footer">
                <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="btn-modal-delete" id="modalConfirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>

    <form id="global-delete-runner-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        let targetedBookDeleteId = null;

        function confirmDelete(bookId) {
            targetedBookDeleteId = bookId;
            const bookTitle = document.getElementById('book-title-' + bookId).innerText;
            document.getElementById('modalTargetBookTitle').innerText = `"${bookTitle}"`;
            document.getElementById('deleteModalOverlay').classList.add('modal-visible');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModalOverlay').classList.remove('modal-visible');
            targetedBookDeleteId = null;
        }

        document.getElementById('modalConfirmDeleteBtn').addEventListener('click', function() {
            if (targetedBookDeleteId) {
                const form = document.getElementById('global-delete-runner-form');
                form.action = "/admin/catalog/" + targetedBookDeleteId;
                form.submit();
            }
        });
    </script>
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
    .edit-category-panel {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 16px;
        padding: 32px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.01);
    }
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.01em;
    }
    .input-entry-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 100%;
    }
    .field-entry-label {
        font-size: 0.825rem;
        font-weight: 700;
        color: #1A1A1A;
    }
    .form-text-input, .form-textarea-input {
        width: 100%;
        padding: 12px 16px;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        color: #1A1A1A;
        font-weight: 500;
        outline: none;
    }
    .form-text-input:focus, .form-textarea-input:focus {
        border-color: #FF5722;
    }
    .summary-metrics-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        width: 100%;
    }
    .summary-card {
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 16px 20px;
    }
    .flex-row-layout {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .sum-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: #1A1A1A;
        line-height: 1.2;
    }
    .sum-label {
        font-size: 0.775rem;
        color: #71717A;
        font-weight: 600;
    }
    .preview-shelf-panel {
        width: 100%;
    }
    .panel-inner-heading {
        font-size: 0.9rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin-bottom: 16px;
    }
    .books-shelf-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 16px;
    }
    .shelf-book-card {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .book-cover-image, .book-cover-fallback {
        width: 100%;
        aspect-ratio: 2/3;
        border-radius: 8px;
        margin-bottom: 6px;
        box-shadow: 1px 3px 6px rgba(0,0,0,0.05);
    }
    .book-cover-image {
        background-size: cover;
        background-position: center;
    }
    .book-cover-fallback {
        padding: 8px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
    }
    .fallback-title { font-size: 0.7rem; font-weight: 800; }
    .fallback-author { font-size: 0.6rem; opacity: 0.7; }
    .shelf-title { font-size: 0.8rem; font-weight: 700; color: #1A1A1A; }
    .text-truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .catalog-panel {
        width: 100%;
        border-top: 1px solid #F4F1EA;
        padding-top: 24px;
    }
    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
    }
    .categories-data-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }
    .categories-data-table th {
        background-color: #FDFBF7;
        font-size: 0.725rem;
        font-weight: 700;
        color: #71717A;
        letter-spacing: 0.05em;
        padding: 12px 14px;
        border-bottom: 1px solid #F4F1EA;
        text-align: left;
    }
    .categories-data-table td {
        padding: 12px 14px;
        font-size: 0.85rem;
        color: #27272A;
        border-bottom: 1px solid #F4F1EA;
        font-weight: 600;
        vertical-align: middle;
    }
    .mono-text {
        font-family: 'JetBrains Mono', monospace;
        color: #A1A1AA!important;
        font-size: 0.8rem;
    }
    .book-title-cell {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        color: #1A1A1A;
    }
    .table-mini-book-color {
        width: 12px;
        height: 18px;
        border-radius: 2px;
        flex-shrink: 0;
    }
    .status-badge {
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.725rem;
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
        width: 40px;
        height: 40px;
    }
    .form-decision-footer-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 14px;
        margin-top: 12px;
        border-top: 1px solid #F4F1EA;
        padding-top: 24px;
    }
    .btn-footer-cancel {
        height: 46px;
        padding: 0 24px;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: #4B5563;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-footer-save {
        height: 46px;
        padding: 0 28px;
        background-color: #FF5722;
        border: none;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: #FFFFFF;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 87, 34, 0.15);
    }
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
        max-width: 420px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        text-align: center;
        transform: scale(0.95);
        transition: transform 0.2s ease;
    }
    .modal-overlay.modal-visible .delete-modal-card {
        transform: scale(1);
    }
    .warning-trash-icon {
        font-size: 2.2rem;
        color: #C10007;
        margin-bottom: 14px;
    }
    .modal-main-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1A1A1A;
        margin-bottom: 10px;
    }
    .modal-warning-body {
        font-size: 0.9rem;
        color: #71717A;
        line-height: 1.5;
        margin-bottom: 24px;
    }
    .modal-actions-footer {
        display: flex;
        gap: 12px;
    }
    .btn-modal-cancel {
        flex: 1;
        height: 44px;
        background-color: #FFFFFF;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: #4B5563;
        cursor: pointer;
    }
    .btn-modal-delete {
        flex: 1;
        height: 44px;
        background-color: #C10007;
        border: none;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        color: #FFFFFF;
        cursor: pointer;
    }
</style>