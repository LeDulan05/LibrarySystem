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
    
    <title>IskoLib - Library Catalog</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Library Catalog</h1>
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
                
                <!-- Search and Filter Bar -->
                <div class="search-panel">
                    <form action="{{ route('library') }}" method="GET" class="search-form">
                        <div class="search-input-wrapper">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text" name="search" class="search-input" placeholder="Search by title, author, ISBN.." value="{{ request('search') }}">
                        </div>
                        
                        <!-- Category Filter -->
                        <select name="category" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Genres</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <!-- Availability Filter -->
                        <select name="availability" class="filter-select" onchange="this.form.submit()">
                            <option value="">All Books</option>
                            <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="unavailable" {{ request('availability') === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>

                        <!-- Sort Button -->
                        <button type="submit" name="sort" value="{{ request('sort') === 'asc' ? 'desc' : 'asc' }}" class="sort-button">
                            <i class="bi bi-sort-alpha-{{ request('sort') === 'desc' ? 'up' : 'down' }}"></i> Sort {{ request('sort') === 'asc' ? 'Z-A' : 'A-Z' }}
                        </button>
                    </form>
                </div>

                <div class="results-info">
                    {{ $books->count() }} books found
                </div>

                <!-- Books Grid -->
                <div class="books-grid">
                    @php
                        $coverClasses = ['bg-cover-blue', 'bg-cover-orange', 'bg-cover-purple', 'bg-cover-green', 'bg-cover-red', 'bg-cover-yellow'];
                    @endphp

                    @forelse($books as $index => $book)
                        @php
                            // Deterministically pick a cover color based on book ID
                            $colorClass = $coverClasses[$book->id % count($coverClasses)];
                            $categoryName = $book->category ? $book->category->name : 'UNCATEGORIZED';
                        @endphp
                        <a href="{{ route('library.show', $book->id) }}" class="book-card" style="text-decoration:none; color:inherit;">
                            @if($book->book_cover)
                                <div class="book-cover" style="background-image: url('{{ asset('storage/' . $book->book_cover) }}'); background-size: cover; background-position: center;">
                                    <div class="category-badge" style="background: rgba(0,0,0,0.6); color: white; padding: 4px 8px; border-radius: 12px; top: 8px;">
                                        {{ strtoupper($categoryName) }} <span class="availability-dot {{ $book->available_copies > 0 ? 'dot-available' : 'dot-unavailable' }}"></span>
                                    </div>
                                </div>
                            @else
                                <div class="book-cover {{ $colorClass }}">
                                    <div class="category-badge">
                                        {{ strtoupper($categoryName) }} <span class="availability-dot {{ $book->available_copies > 0 ? 'dot-available' : 'dot-unavailable' }}"></span>
                                    </div>
                                    <div class="book-cover-title">{{ $book->title }}</div>
                                    <div class="book-cover-author">{{ $book->author }}</div>
                                </div>
                            @endif
                            <div class="book-title">{{ $book->title }}</div>
                            <div class="book-author">{{ $book->author }}</div>
                        </a>
                    @empty
                        <div class="empty-state">No books found matching your criteria.</div>
                    @endforelse
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

    /* Search Panel */
    .search-panel {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
    }
    .search-form {
        display: flex;
        gap: 16px;
        align-items: center;
        width: 100%;
    }
    .search-input-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        background-color: #F9F6F0;
        border-radius: 8px;
        padding: 0 16px;
        height: 48px;
    }
    .search-icon {
        color: #A1A1AA;
        font-size: 1.1rem;
        margin-right: 12px;
    }
    .search-input {
        border: none;
        background: transparent;
        width: 100%;
        height: 100%;
        font-size: 0.95rem;
        color: #27272A;
        font-family: inherit;
        outline: none;
    }
    .search-input::placeholder {
        color: #A1A1AA;
    }
    .filter-select {
        background-color: #F4F1EA;
        border: 1px solid #EAE6DF;
        border-radius: 8px;
        padding: 0 36px 0 16px;
        height: 48px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #3F3F46;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233F3F46' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }
    .filter-select:hover, .filter-select:focus {
        background-color: #EAE6DF;
        color: #1A1A1A;
    }
    .sort-button {
        background-color: #F4F1EA;
        border: 1px solid #EAE6DF;
        border-radius: 8px;
        padding: 0 20px;
        height: 48px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        color: #3F3F46;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .sort-button:hover {
        background-color: #EAE6DF;
        color: #1A1A1A;
    }

    .results-info {
        font-size: 0.95rem;
        color: #A1A1AA;
        margin-bottom: 20px;
        font-weight: 500;
    }

    /* Books Grid */
    .books-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 32px 24px;
    }
    .book-card {
        display: flex;
        flex-direction: column;
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .book-card:hover {
        transform: translateY(-4px);
    }
    
    .book-cover {
        width: 100%;
        aspect-ratio: 2/3;
        border-radius: 12px 16px 16px 12px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 12px;
        color: white;
        box-shadow: 2px 4px 12px rgba(0,0,0,0.1), inset 6px 0 10px rgba(0,0,0,0.1);
        position: relative;
    }
    .book-cover::before {
        content: '';
        position: absolute;
        left: 12px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: rgba(255,255,255,0.2);
    }

    .category-badge {
        position: absolute;
        top: 12px;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        opacity: 0.9;
    }
    .availability-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .dot-available { background-color: #4ADE80; }
    .dot-unavailable { background-color: #F87171; }

    .book-cover-title {
        font-size: 0.9rem;
        font-weight: 800;
        margin-bottom: 8px;
        line-height: 1.25;
        padding: 0 10px;
    }
    .book-cover-author {
        font-size: 0.65rem;
        opacity: 0.8;
    }
    
    .bg-cover-blue { background: linear-gradient(135deg, #3B82F6, #2563EB); }
    .bg-cover-orange { background: linear-gradient(135deg, #F97316, #EA580C); }
    .bg-cover-purple { background: linear-gradient(135deg, #A855F7, #9333EA); }
    .bg-cover-green { background: linear-gradient(135deg, #10B981, #059669); }
    .bg-cover-red { background: linear-gradient(135deg, #EF4444, #DC2626); }
    .bg-cover-yellow { background: linear-gradient(135deg, #D97706, #B45309); }

    .book-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #27272A;
        margin-bottom: 4px;
        line-height: 1.3;
    }
    .book-author {
        font-size: 0.8rem;
        color: #71717A;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 64px 0;
        color: #71717A;
        font-size: 1.1rem;
    }
</style>
