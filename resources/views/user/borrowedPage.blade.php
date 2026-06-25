<!DOCTYPE html>
<html lang="en">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <title>IskoLib - My Borrowed Books</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">My Borrowed Books</h1>
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
                
                <!-- Tab Toggle -->
                <div class="tabs-container">
                    <button class="tab-btn active" id="btn-current" onclick="switchTab('current')">Current Loans</button>
                    <button class="tab-btn" id="btn-history" onclick="switchTab('history')">Borrow History</button>
                </div>

                <!-- Current Loans List -->
                <div id="list-current" class="books-list">
                    
                    @forelse($transactions->where('status', '!=', 'returned') as $loan)
                    @php
                        $book = $loan->book;
                        // For a clean UI look on placeholders
                        $colors = ['bg-cover-blue', 'bg-cover-orange', 'bg-cover-purple', 'bg-cover-green', 'bg-cover-red'];
                        $bgColor = $colors[$book->id % count($colors)];
                        
                        $isOverdue = $loan->status === 'active' && $loan->due_date && \Carbon\Carbon::parse($loan->due_date)->isPast();
                        $borderClass = $isOverdue ? 'overdue-border' : 'active-border';
                        
                        if ($loan->status === 'pending') {
                            $statusPill = 'status-active';
                            $statusText = 'Pending Approval';
                        } elseif ($loan->status === 'active') {
                            $statusPill = $isOverdue ? 'status-overdue' : 'status-active';
                            $statusText = $isOverdue ? 'Overdue' : 'Active';
                        } else {
                            $statusPill = 'status-overdue';
                            $statusText = ucfirst($loan->status);
                        }
                    @endphp
                    <div class="loan-card {{ $borderClass }}">
                        @if($book->book_cover)
                            <img src="{{ asset('storage/' . $book->book_cover) }}" alt="Cover" class="loan-cover" style="object-fit: cover; padding: 0; border: none;">
                        @else
                            <div class="loan-cover {{ $bgColor }}">
                                <div class="cover-badge">{{ strtoupper(Str::limit($book->category->name ?? 'Category', 10)) }}</div>
                                <div class="cover-title">{{ Str::limit($book->title, 40) }}</div>
                                <div class="cover-author">{{ Str::limit($book->author, 20) }}</div>
                            </div>
                        @endif
                        <div class="loan-details">
                            <div>
                                <span class="category-pill">{{ $book->category->name ?? 'Category' }}</span>
                                <h3 class="book-title">{{ $book->title }}</h3>
                                <div class="book-author">{{ $book->author }}</div>
                            </div>
                            <div class="loan-meta">
                                <div>
                                    <div class="meta-label">Borrowed</div>
                                    <div class="meta-value">{{ $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->format('M j, Y') : 'Pending' }}</div>
                                </div>
                                <div>
                                    <div class="meta-label">Due Date</div>
                                    <div class="meta-value">{{ $loan->due_date ? \Carbon\Carbon::parse($loan->due_date)->format('M j, Y') : 'Pending' }}</div>
                                </div>
                                <div>
                                    <div class="meta-label">Time Left</div>
                                    @if($loan->status === 'pending')
                                        <div class="meta-value text-gray-500">Awaiting Admin</div>
                                    @elseif($loan->due_date)
                                        @if($isOverdue)
                                            <div class="meta-value text-red">{{ \Carbon\Carbon::parse($loan->due_date)->diffInDays(now()) }}d overdue</div>
                                        @else
                                            <div class="meta-value text-green">{{ \Carbon\Carbon::parse($loan->due_date)->diffInDays(now()) }}d left</div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="loan-status">
                            <span class="status-pill {{ $statusPill }}">{{ $statusText }}</span>
                            @if($loan->status === 'pending')
                                <button type="button" class="btn-cancel-pill" onclick="openCancelModal({{ $loan->id }}, '{{ addslashes($book->title) }}')">Cancel Request</button>
                                <form id="cancel-form-{{ $loan->id }}" method="POST" action="{{ route('borrow.destroy', $loan->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                    @empty
                        <div class="text-sm text-gray-500">You don't have any active loans right now.</div>
                    @endforelse

                </div>

                <!-- Borrow History List -->
                <div id="list-history" class="books-list" style="display:none;">
                    
                    @forelse($transactions->where('status', 'returned') as $loan)
                    @php
                        $book = $loan->book;
                        $colors = ['bg-cover-blue', 'bg-cover-orange', 'bg-cover-purple', 'bg-cover-green', 'bg-cover-red'];
                        $bgColor = $colors[$book->id % count($colors)];
                        $returnedLate = $loan->due_date && $loan->return_date && \Carbon\Carbon::parse($loan->return_date)->greaterThan(\Carbon\Carbon::parse($loan->due_date));
                    @endphp
                    <div class="loan-card {{ $returnedLate ? 'overdue-border' : '' }}">
                        @if($book->book_cover)
                            <img src="{{ asset('storage/' . $book->book_cover) }}" alt="Cover" class="loan-cover" style="object-fit: cover; padding: 0; border: none;">
                        @else
                            <div class="loan-cover {{ $bgColor }}">
                                <div class="cover-title" style="margin-top:20px;">{{ Str::limit($book->title, 40) }}</div>
                                <div class="cover-author">{{ Str::limit($book->author, 20) }}</div>
                            </div>
                        @endif
                        <div class="loan-details">
                            <div>
                                <span class="category-pill">{{ $book->category->name ?? 'Category' }}</span>
                                <h3 class="book-title">{{ $book->title }}</h3>
                                <div class="book-author">{{ $book->author }}</div>
                            </div>
                            <div class="loan-meta">
                                <div>
                                    <div class="meta-label">Borrowed</div>
                                    <div class="meta-value">{{ $loan->borrow_date ? \Carbon\Carbon::parse($loan->borrow_date)->format('M j, Y') : 'Unknown' }}</div>
                                </div>
                                <div style="margin-left: 100px;">
                                    <div class="meta-label">Returned</div>
                                    <div class="meta-value">{{ $loan->return_date ? \Carbon\Carbon::parse($loan->return_date)->format('M j, Y') : 'Unknown' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="loan-status">
                            <span class="status-pill {{ $returnedLate ? 'status-late' : 'status-returned' }}">{{ $returnedLate ? 'Returned Late' : 'Returned' }}</span>
                        </div>
                    </div>
                    @empty
                        <div class="text-sm text-gray-500">You don't have any borrow history yet.</div>
                    @endforelse

                </div>

            </div> 
        </main>
    </div>

    <!-- Cancel Modal Overlay -->
    <div id="cancelModal" class="modal-overlay" style="display:none;">
        <div class="modal-content">
            <div class="modal-icon-container bg-red-light text-red">
                <i class="bi bi-x-circle"></i>
            </div>
            
            <h2 class="modal-title">Cancel Request?</h2>
            <p class="modal-desc" id="cancelModalText">Are you sure you want to cancel this borrow request?</p>
            
            <div class="modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeCancelModal()">Keep it</button>
                <button type="button" class="btn-modal-danger" onclick="confirmCancel()">Yes, Cancel</button>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Reset buttons
            document.getElementById('btn-current').classList.remove('active');
            document.getElementById('btn-history').classList.remove('active');
            
            // Hide all lists
            document.getElementById('list-current').style.display = 'none';
            document.getElementById('list-history').style.display = 'none';

            // Show selected
            document.getElementById('btn-' + tabName).classList.add('active');
            document.getElementById('list-' + tabName).style.display = 'flex';
        }

        let currentCancelId = null;

        function openCancelModal(id, title) {
            currentCancelId = id;
            document.getElementById('cancelModalText').innerText = `Cancel borrow request for "${title}"?`;
            document.getElementById('cancelModal').style.display = 'flex';
        }

        function closeCancelModal() {
            currentCancelId = null;
            document.getElementById('cancelModal').style.display = 'none';
        }

        function confirmCancel() {
            if (currentCancelId) {
                document.getElementById('cancel-form-' + currentCancelId).submit();
            }
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

    .canvas-content { padding: 32px 40px; flex: 1; max-width: 1400px; margin: 0 auto; width: 100%; }

    /* Modal Styles */
    .modal-overlay { position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; z-index: 1000; }
    .modal-content { background: white; width: 100%; max-width: 440px; border-radius: 24px; padding: 40px; text-align: center; box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .modal-icon-container { width: 72px; height: 72px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin: 0 auto 24px auto; }
    .bg-red-light { background-color: #FEE2E2; }
    .text-red { color: #DC2626; }
    .modal-title { font-size: 1.5rem; font-weight: 800; color: #1A1A1A; margin-bottom: 8px; }
    .modal-desc { font-size: 0.95rem; color: #71717A; margin-bottom: 32px; line-height: 1.5; }
    .modal-actions { display: flex; gap: 16px; }
    .modal-actions button { flex: 1; padding: 14px; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; transition: opacity 0.2s; }
    .btn-modal-cancel { background: white; border: 1px solid #E4E4E7; color: #3F3F46; }
    .btn-modal-cancel:hover { background: #F4F4F5; }
    .btn-modal-danger { background: #DC2626; border: none; color: white; }
    .btn-modal-danger:hover { opacity: 0.9; }

    .btn-cancel-pill {
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
        background-color: transparent;
        color: #DC2626;
        border: 1px solid #DC2626;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        text-align: center;
    }
    .btn-cancel-pill:hover { background-color: #FEE2E2; }

    /* Tabs */
    .tabs-container {
        display: inline-flex;
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 999px;
        padding: 4px;
        margin-bottom: 24px;
    }
    .tab-btn {
        background: transparent;
        border: none;
        padding: 10px 24px;
        border-radius: 999px;
        font-size: 0.9rem;
        font-weight: 700;
        color: #71717A;
        cursor: pointer;
        transition: all 0.2s;
    }
    .tab-btn:hover { color: #1A1A1A; }
    .tab-btn.active {
        background-color: #EA580C;
        color: white;
    }

    /* Books List */
    .books-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .loan-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 24px;
        align-items: center;
        transition: border-color 0.2s;
    }
    .active-border { border-color: #A7F3D0; } /* subtle green */
    .overdue-border { border-color: #FECACA; } /* subtle red */

    .loan-cover {
        width: 80px;
        height: 120px;
        border-radius: 8px;
        flex-shrink: 0;
        padding: 8px;
        display: flex;
        flex-direction: column;
        color: white;
        text-align: center;
        position: relative;
    }
    .bg-cover-blue { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
    .bg-cover-orange { background: linear-gradient(135deg, #F97316, #C2410C); }
    .bg-cover-purple { background: linear-gradient(135deg, #A855F7, #7E22CE); }
    .bg-cover-green { background: linear-gradient(135deg, #10B981, #047857); }
    .bg-cover-red { background: linear-gradient(135deg, #EF4444, #B91C1C); }

    .cover-badge { font-size: 0.4rem; font-weight: 800; display:flex; justify-content:center; align-items:center; gap:2px; margin-bottom: auto;}
    .availability-dot { width: 4px; height: 4px; border-radius: 50%; }
    .dot-available { background-color: #4ADE80; }
    .cover-title { font-size: 0.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 2px;}
    .cover-author { font-size: 0.4rem; opacity: 0.8; }

    .loan-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100px;
    }
    
    .category-pill { display: inline-block; padding: 2px 8px; background-color: #F1F5F9; color: #475569; border-radius: 999px; font-size: 0.65rem; font-weight: 700; margin-bottom: 4px; }
    .book-title { font-size: 1.1rem; font-weight: 800; color: #1A1A1A; margin-bottom: 2px; line-height: 1.2; }
    .book-author { font-size: 0.85rem; color: #A1A1AA; }

    .loan-meta {
        display: flex;
        gap: 64px;
        margin-top: auto;
    }
    .meta-label { font-size: 0.7rem; color: #D4D4D8; margin-bottom: 2px; }
    .meta-value { font-size: 0.85rem; font-weight: 700; color: #1A1A1A; }
    .text-green { color: #059669; }
    .text-red { color: #DC2626; }

    .loan-status {
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        height: 100px;
        gap: 8px;
    }
    .status-pill {
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 0.8rem;
        font-weight: 700;
    }
    .status-active { background-color: #D1FAE5; color: #059669; }
    .status-overdue { background-color: #FEE2E2; color: #DC2626; }
    .status-returned { background-color: #D1FAE5; color: #059669; }
    .status-late { background-color: #FEE2E2; color: #DC2626; }
</style>
