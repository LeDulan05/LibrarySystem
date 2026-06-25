<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <title>IskoLib - Book Details</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Book Details</h1>
                <div class="header-right">
                    <a href="{{ url('/notifications') }}" class="notification-icon">
                        <i class="bi bi-bell"></i>
                    </a>
                    @if(Auth::check())
                        <a href="{{ route('profile.edit') }}" class="profile-avatar" style="text-decoration:none;">{{ strtoupper(substr(Auth::user()->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? 'D', 0, 1)) }}</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="profile-avatar" style="text-decoration:none;">JD</a>
                    @endif
                </div>
            </div>

            <div class="canvas-content">
                
                <a href="{{ route('library.show', $book->id) }}" class="back-link">
                    <i class="bi bi-chevron-left"></i> Back to Catalog Card
                </a>

                @php
                    $coverClasses = ['bg-cover-blue', 'bg-cover-orange', 'bg-cover-purple', 'bg-cover-green', 'bg-cover-red', 'bg-cover-yellow'];
                    $colorClass = $coverClasses[$book->id % count($coverClasses)];
                    $isAvailable = $book->available_copies > 0;
                    $actionType = $isAvailable ? 'Borrow' : 'Reservation';
                    $actionIcon = $isAvailable ? 'bi-book' : 'bi-calendar';
                    $actionUrl = $isAvailable ? route('library.borrow', $book->id) : route('library.reserve', $book->id);
                @endphp

                <div class="details-layout">
                    <!-- Left Column -->
                    <div class="left-col">
                        @if($book->book_cover)
                            <div class="book-cover-large" style="background-image: url('{{ asset('storage/' . $book->book_cover) }}'); background-size: cover; background-position: center; position: relative;">
                                <div class="category-badge-large" style="position: absolute; top: 16px; left: 16px; background: rgba(0,0,0,0.6); padding: 6px 12px; border-radius: 8px;">{{ strtoupper($book->category->name ?? 'UNCATEGORIZED') }}</div>
                            </div>
                        @else
                            <div class="book-cover-large {{ $colorClass }}">
                                <div class="category-badge-large">{{ strtoupper($book->category->name ?? 'UNCATEGORIZED') }}</div>
                                <div class="cover-content">
                                    <div class="cover-title">{{ $book->title }}</div>
                                    <div class="cover-author">{{ $book->author }}</div>
                                </div>
                            </div>
                        @endif

                        <div class="status-card">
                            <div class="status-row">
                                <span class="status-label">Status</span>
                                @if($isAvailable)
                                    <span class="status-pill pill-available">Available</span>
                                @else
                                    <span class="status-pill pill-unavailable">Unavailable</span>
                                @endif
                            </div>
                            <div class="status-row">
                                <span class="status-label">Available Copies</span>
                                <span class="status-value {{ $isAvailable ? 'text-green' : 'text-red' }}">{{ $book->available_copies }}</span>
                            </div>
                            <div class="status-row">
                                <span class="status-label">Borrow Duration</span>
                                <span class="status-value">14 days</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="right-col">
                        <div class="info-card">
                            <span class="category-pill">{{ $book->category->name ?? 'Uncategorized' }}</span>
                            <h1 class="book-full-title">{{ $book->title }}</h1>
                            <div class="book-meta">
                                {{ $book->author }}<br>
                                <span style="color:#A1A1AA;">Prentice Hall, 2021 · ISBN {{ $book->isbn }}</span>
                            </div>

                            <div class="description-section">
                                <h3>Description</h3>
                                <p>
                                    This leading textbook offers comprehensive coverage of topics including agents, search, logic, planning, machine learning, and robotics. Ideal for undergraduate and graduate courses.
                                </p>
                            </div>

                            <div class="duration-box">
                                <div class="duration-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="duration-text">
                                    <strong>Borrow Duration: 14 days</strong><br>
                                    <span>Return by: {{ \Carbon\Carbon::now()->addDays(14)->format('M j, Y') }}</span>
                                </div>
                            </div>

                            <button type="button" class="action-btn {{ $isAvailable ? 'btn-borrow' : 'btn-reserve' }}" onclick="openModal()">
                                {{ $isAvailable ? 'Borrow This Book' : 'Reserve This Book' }}
                            </button>
                        </div>
                    </div>
                </div>

            </div> 
        </main>
    </div>

    <!-- Modal Overlay -->
    <div id="actionModal" class="modal-overlay" style="display:none;">
        <div class="modal-content" id="modalStateConfirm">
            <div class="modal-icon-container">
                <i class="bi {{ $actionIcon }} text-orange"></i>
            </div>
            <h2 class="modal-title">{{ $actionType }} Confirmation</h2>
            <p class="modal-desc">Your request will be submitted for approval.</p>
            
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="button" class="btn-confirm" onclick="submitRequest()">Confirm Request</button>
            </div>
        </div>

        <div class="modal-content" id="modalStateSuccess" style="display:none;">
            <div class="modal-icon-container bg-green">
                <i class="bi bi-check-lg text-white"></i>
            </div>
            <h2 class="modal-title">{{ $actionType }} Confirmation</h2>
            <p class="modal-desc">Your request has been submitted for approval.</p>
            
            <div class="receipt-box">
                <div class="receipt-row">
                    <span>Book</span>
                    <strong>{{ Str::limit($book->title, 30) }}</strong>
                </div>
                <div class="receipt-row">
                    <span>Author</span>
                    <strong>{{ $book->author }}</strong>
                </div>
                <div class="receipt-row">
                    <span>Borrow Duration</span>
                    <strong>14 days</strong>
                </div>
                <div class="receipt-row">
                    <span>Expected Due Date</span>
                    <strong>14 days after approval</strong>
                </div>
            </div>
            
            <div style="text-align: center; margin-top:24px;">
                <button type="button" class="btn-cancel" onclick="window.location.reload()" style="width:100%;">Close</button>
            </div>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('actionModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('actionModal').style.display = 'none';
        }
        function submitRequest() {
            const btn = document.querySelector('.btn-confirm');
            btn.innerHTML = 'Submitting...';
            btn.disabled = true;

            fetch('{{ $actionUrl }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('modalStateConfirm').style.display = 'none';
                document.getElementById('modalStateSuccess').style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Something went wrong.');
                btn.innerHTML = 'Confirm Request';
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>

<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #1C1C1C;
        overflow: hidden;
    }
    .layout-container { display: flex; height: 100vh; width: 100vw; overflow: hidden; }
    .main-canvas { flex: 1; background-color: #F9F6F0; overflow-y: auto; display: flex; flex-direction: column; }
    
    .dashboard-header { display: flex; justify-content: space-between; align-items: center; background-color: #FFFFFF; padding: 20px 40px; border-bottom: 1px solid #EAE6DF; }
    .dashboard-title { font-size: 1.5rem; font-weight: 800; color: #1A1A1A; }
    .header-right { display: flex; align-items: center; gap: 20px; }
    .notification-icon { font-size: 1.25rem; color: #52525B; cursor: pointer; text-decoration: none; }
    .profile-avatar { width: 40px; height: 40px; background-color: #E85D22; color: white; font-weight: 700; font-size: 14px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }

    .canvas-content { padding: 32px 40px; flex: 1; max-width: 1000px; margin: 0 auto; width: 100%; }

    .back-link { display: inline-flex; align-items: center; gap: 8px; font-size: 0.95rem; color: #52525B; text-decoration: none; margin-bottom: 24px; font-weight: 600; transition: color 0.2s; }
    .back-link:hover { color: #1A1A1A; }

    .details-layout { display: flex; gap: 32px; align-items: flex-start; }
    .left-col { width: 300px; flex-shrink: 0; display: flex; flex-direction: column; gap: 16px; }
    .right-col { flex: 1; }

    .book-cover-large {
        width: 100%;
        aspect-ratio: 2/3;
        border-radius: 12px;
        position: relative;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .bg-cover-blue { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
    .bg-cover-orange { background: linear-gradient(135deg, #F97316, #C2410C); }
    .bg-cover-purple { background: linear-gradient(135deg, #A855F7, #7E22CE); }
    .bg-cover-green { background: linear-gradient(135deg, #10B981, #047857); }
    .bg-cover-red { background: linear-gradient(135deg, #EF4444, #B91C1C); }
    .bg-cover-yellow { background: linear-gradient(135deg, #F59E0B, #B45309); }

    .category-badge-large { font-size: 0.75rem; font-weight: 800; opacity: 0.9; }
    .cover-title { font-size: 1.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 8px; }
    .cover-author { font-size: 0.9rem; opacity: 0.8; }

    .status-card { background: white; border: 1px solid #EAE6DF; border-radius: 12px; padding: 20px; }
    .status-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #F4F1EA; }
    .status-row:last-child { border-bottom: none; padding-bottom: 0; }
    .status-row:first-child { padding-top: 0; }
    .status-label { color: #71717A; font-size: 0.9rem; }
    .status-value { font-weight: 700; font-size: 0.95rem; }
    .text-green { color: #059669; }
    .text-red { color: #DC2626; }
    .status-pill { padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; }
    .pill-available { background-color: #D1FAE5; color: #059669; }
    .pill-unavailable { background-color: #FEE2E2; color: #DC2626; }

    .info-card { background: white; border-radius: 16px; padding: 32px; border: 1px solid #EAE6DF; }
    .category-pill { display: inline-block; padding: 4px 12px; background-color: #F1F5F9; color: #475569; border-radius: 999px; font-size: 0.75rem; font-weight: 700; margin-bottom: 16px; }
    .book-full-title { font-size: 1.75rem; font-weight: 800; color: #1A1A1A; margin-bottom: 8px; line-height: 1.2; }
    .book-meta { font-size: 0.95rem; color: #52525B; line-height: 1.6; margin-bottom: 32px; }

    .description-section h3 { font-size: 1rem; font-weight: 700; color: #1A1A1A; margin-bottom: 8px; }
    .description-section p { font-size: 0.95rem; color: #52525B; line-height: 1.6; margin-bottom: 32px; }

    .duration-box { background-color: #FAF8F5; border-radius: 8px; padding: 16px; display: flex; align-items: center; gap: 16px; margin-bottom: 32px; }
    .duration-icon { width: 40px; height: 40px; background-color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #EA580C; font-size: 1.2rem; }
    .duration-text strong { font-size: 0.95rem; color: #1A1A1A; }
    .duration-text span { font-size: 0.85rem; color: #71717A; }

    .action-btn { width: 100%; padding: 16px; border-radius: 8px; border: none; font-size: 1rem; font-weight: 700; color: white; cursor: pointer; transition: opacity 0.2s; }
    .action-btn:hover { opacity: 0.9; }
    .btn-borrow { background-color: #EA580C; }
    .btn-reserve { background-color: #DC2626; } /* Or another color for reserve */

    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; z-index: 1000; }
    .modal-content { background: white; width: 100%; max-width: 440px; border-radius: 24px; padding: 40px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .modal-icon-container { width: 72px; height: 72px; background-color: #FFF3EB; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 24px auto; }
    .modal-icon-container.bg-green { background-color: #059669; }
    .text-orange { color: #EA580C; }
    .text-white { color: white; }
    .modal-title { font-size: 1.5rem; font-weight: 800; color: #1A1A1A; margin-bottom: 8px; }
    .modal-desc { font-size: 0.95rem; color: #71717A; margin-bottom: 32px; }
    
    .modal-actions { display: flex; gap: 16px; }
    .modal-actions button { flex: 1; padding: 14px; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; }
    .modal-actions button:hover { opacity: 0.9; }
    .btn-cancel { background: white; border: 1px solid #EAE6DF; color: #52525B; }
    .btn-confirm { background: #059669; border: none; color: white; }

    .receipt-box { background-color: #FAF8F5; border-radius: 12px; padding: 20px; text-align: left; }
    .receipt-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.9rem; }
    .receipt-row:last-child { margin-bottom: 0; }
    .receipt-row span { color: #71717A; }
    .receipt-row strong { color: #1A1A1A; font-weight: 700; }

</style>
