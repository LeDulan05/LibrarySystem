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
                        <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? 'D', 0, 1)) }}</div>
                    @else
                        <div class="profile-avatar">JD</div>
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
                    
                    <!-- Dummy Active -->
                    <div class="loan-card active-border">
                        <div class="loan-cover bg-cover-blue">
                            <div class="cover-badge">AI <span class="availability-dot dot-available"></span></div>
                            <div class="cover-title">Introduction to Artificial Intelligence</div>
                            <div class="cover-author">Stuart Russell</div>
                        </div>
                        <div class="loan-details">
                            <div>
                                <span class="category-pill">AI</span>
                                <h3 class="book-title">Introduction to Artificial Intelligence</h3>
                                <div class="book-author">Stuart Russell</div>
                            </div>
                            <div class="loan-meta">
                                <div>
                                    <div class="meta-label">Borrowed</div>
                                    <div class="meta-value">Dec 10, 2024</div>
                                </div>
                                <div>
                                    <div class="meta-label">Due Date</div>
                                    <div class="meta-value">Dec 24, 2024</div>
                                </div>
                                <div>
                                    <div class="meta-label">Time Left</div>
                                    <div class="meta-value text-green">4d left</div>
                                </div>
                            </div>
                        </div>
                        <div class="loan-status">
                            <span class="status-pill status-active">Active</span>
                        </div>
                    </div>

                    <!-- Dummy Overdue -->
                    <div class="loan-card overdue-border">
                        <div class="loan-cover bg-cover-orange">
                            <div class="cover-badge">PROGRAMMING <span class="availability-dot dot-available"></span></div>
                            <div class="cover-title">Clean Code: A Handbook of Agile Software Craftsmanship</div>
                            <div class="cover-author">Robert C. Martin</div>
                        </div>
                        <div class="loan-details">
                            <div>
                                <span class="category-pill">Programming</span>
                                <h3 class="book-title">Clean Code: A Handbook of Agile Software Craftsmanship</h3>
                                <div class="book-author">Robert C. Martin</div>
                            </div>
                            <div class="loan-meta">
                                <div>
                                    <div class="meta-label">Borrowed</div>
                                    <div class="meta-value">Nov 30, 2024</div>
                                </div>
                                <div>
                                    <div class="meta-label">Due Date</div>
                                    <div class="meta-value">Dec 14, 2024</div>
                                </div>
                                <div>
                                    <div class="meta-label">Time Left</div>
                                    <div class="meta-value text-red">6d overdue</div>
                                </div>
                            </div>
                        </div>
                        <div class="loan-status">
                            <span class="status-pill status-overdue">Overdue</span>
                        </div>
                    </div>

                </div>

                <!-- Borrow History List -->
                <div id="list-history" class="books-list" style="display:none;">
                    
                    <!-- Dummy Returned -->
                    <div class="loan-card">
                        <div class="loan-cover bg-cover-purple">
                            <div class="cover-title" style="margin-top:20px;">Computer Networks</div>
                            <div class="cover-author">Andrew S. Tanenbaum</div>
                        </div>
                        <div class="loan-details">
                            <div>
                                <span class="category-pill">Networking</span>
                                <h3 class="book-title">Computer Networks</h3>
                                <div class="book-author">Andrew S. Tanenbaum</div>
                            </div>
                            <div class="loan-meta">
                                <div>
                                    <div class="meta-label">Borrowed</div>
                                    <div class="meta-value">Nov 1, 2024</div>
                                </div>
                                <div style="margin-left: 100px;">
                                    <div class="meta-label">Returned</div>
                                    <div class="meta-value">Nov 15, 2024</div>
                                </div>
                            </div>
                        </div>
                        <div class="loan-status">
                            <span class="status-pill status-returned">Returned</span>
                        </div>
                    </div>

                    <!-- Dummy Returned -->
                    <div class="loan-card">
                        <div class="loan-cover bg-cover-green">
                            <div class="cover-title" style="margin-top:20px;">Database System Concepts</div>
                            <div class="cover-author">Abraham Silberschatz</div>
                        </div>
                        <div class="loan-details">
                            <div>
                                <span class="category-pill">Database</span>
                                <h3 class="book-title">Database System Concepts</h3>
                                <div class="book-author">Abraham Silberschatz</div>
                            </div>
                            <div class="loan-meta">
                                <div>
                                    <div class="meta-label">Borrowed</div>
                                    <div class="meta-value">Oct 5, 2024</div>
                                </div>
                                <div style="margin-left: 100px;">
                                    <div class="meta-label">Returned</div>
                                    <div class="meta-value">Oct 19, 2024</div>
                                </div>
                            </div>
                        </div>
                        <div class="loan-status">
                            <span class="status-pill status-returned">Returned</span>
                        </div>
                    </div>

                    <!-- Dummy Returned Late -->
                    <div class="loan-card overdue-border">
                        <div class="loan-cover bg-cover-red">
                            <div class="cover-title" style="margin-top:20px;">Cybersecurity Essentials</div>
                            <div class="cover-author">Charles J. Brooks</div>
                        </div>
                        <div class="loan-details">
                            <div>
                                <span class="category-pill">Cybersecurity</span>
                                <h3 class="book-title">Cybersecurity Essentials</h3>
                                <div class="book-author">Charles J. Brooks</div>
                            </div>
                            <div class="loan-meta">
                                <div>
                                    <div class="meta-label">Borrowed</div>
                                    <div class="meta-value">Sep 10, 2024</div>
                                </div>
                                <div style="margin-left: 100px;">
                                    <div class="meta-label">Returned</div>
                                    <div class="meta-value">Sep 25, 2024</div>
                                </div>
                            </div>
                        </div>
                        <div class="loan-status">
                            <span class="status-pill status-late">Returned Late</span>
                        </div>
                    </div>

                </div>

            </div> 
        </main>
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
        align-items: flex-start;
        height: 100px;
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
