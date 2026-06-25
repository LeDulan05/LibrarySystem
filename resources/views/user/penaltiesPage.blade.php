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
    
    <title>IskoLib - My Penalties</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">My Penalties</h1>
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
                
                <!-- Summary Cards -->
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-icon bg-green text-white">
                            <i class="bi bi-exclamation-circle"></i>
                        </div>
                        <div class="summary-number">₱0.00</div>
                        <div class="summary-label">Outstanding Balance</div>
                    </div>
                    
                    <div class="summary-card">
                        <div class="summary-icon bg-blue text-white">
                            <i class="bi bi-check-lg"></i>
                        </div>
                        <div class="summary-number">₱25.00</div>
                        <div class="summary-label">Total Paid</div>
                    </div>

                    <div class="summary-card">
                        <div class="summary-icon bg-yellow-light text-yellow">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="summary-number">2</div>
                        <div class="summary-label">Penalty Records</div>
                    </div>
                </div>

                <!-- Penalties List -->
                <div class="books-list">
                    
                    <!-- Dummy Paid -->
                    <div class="penalty-card active-border">
                        <div class="pen-cover bg-cover-green">
                            <div class="cover-badge">DATABASE</div>
                            <div class="cover-title">Database System Concepts</div>
                            <div class="cover-author">Abraham Silberschatz</div>
                        </div>
                        
                        <div class="pen-details">
                            <div class="pen-header">
                                <div>
                                    <span class="category-pill">Database</span>
                                    <h3 class="book-title">Database System Concepts</h3>
                                    <div class="book-author">Abraham Silberschatz</div>
                                </div>
                                <div>
                                    <span class="status-pill status-paid">Paid</span>
                                </div>
                            </div>
                            
                            <div class="pen-meta-row">
                                <div>
                                    <div class="meta-label">Days Overdue</div>
                                    <div class="meta-value text-red">5 days</div>
                                </div>
                                <div>
                                    <div class="meta-label">Amount</div>
                                    <div class="meta-value text-orange">₱25.00</div>
                                </div>
                                <div>
                                    <div class="meta-label">Date</div>
                                    <div class="meta-value">Nov 15, 2024</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dummy No Penalty -->
                    <div class="penalty-card">
                        <div class="pen-cover bg-cover-purple">
                            <div class="cover-badge">NETWORKING</div>
                            <div class="cover-title">Computer Networks</div>
                            <div class="cover-author">Andrew S. Tanenbaum</div>
                        </div>
                        
                        <div class="pen-details">
                            <div class="pen-header">
                                <div>
                                    <span class="category-pill">Networking</span>
                                    <h3 class="book-title">Computer Networks</h3>
                                    <div class="book-author">Andrew S. Tanenbaum</div>
                                </div>
                                <div>
                                    <span class="status-pill status-none">No Penalty</span>
                                </div>
                            </div>
                            
                            <div class="pen-meta-row">
                                <div>
                                    <div class="meta-label">Days Overdue</div>
                                    <div class="meta-value text-green">—</div>
                                </div>
                                <div>
                                    <div class="meta-label">Amount</div>
                                    <div class="meta-value text-orange">—</div>
                                </div>
                                <div>
                                    <div class="meta-label">Date</div>
                                    <div class="meta-value">—</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div> 
        </main>
    </div>
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

    /* Summary Cards */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 32px;
    }
    .summary-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 24px;
    }
    .summary-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        margin-bottom: 16px;
    }
    .bg-green { background-color: #059669; }
    .bg-blue { background-color: #3B82F6; }
    .bg-yellow-light { background-color: #FEF08A; }
    .text-yellow { color: #EAB308; }
    .text-white { color: white; }

    .summary-number { font-size: 2rem; font-weight: 800; color: #1A1A1A; margin-bottom: 4px; line-height: 1; }
    .summary-label { font-size: 0.9rem; color: #71717A; }

    /* Penalties List */
    .books-list { display: flex; flex-direction: column; gap: 16px; }

    .penalty-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 24px;
        transition: border-color 0.2s;
    }
    .active-border { border-color: #A7F3D0; }

    .pen-cover {
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
    .bg-cover-green { background: linear-gradient(135deg, #10B981, #047857); }
    .bg-cover-purple { background: linear-gradient(135deg, #A855F7, #7E22CE); }
    
    .cover-badge { font-size: 0.4rem; font-weight: 800; display:flex; justify-content:center; align-items:center; margin-bottom: auto;}
    .cover-title { font-size: 0.5rem; font-weight: 800; line-height: 1.2; margin-bottom: 2px;}
    .cover-author { font-size: 0.4rem; opacity: 0.8; }

    .pen-details {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .pen-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: auto;
    }

    .category-pill { display: inline-block; padding: 2px 8px; background-color: #F1F5F9; color: #475569; border-radius: 999px; font-size: 0.65rem; font-weight: 700; margin-bottom: 4px; }
    .book-title { font-size: 1.1rem; font-weight: 800; color: #1A1A1A; margin-bottom: 2px; line-height: 1.2; }
    .book-author { font-size: 0.85rem; color: #A1A1AA; }

    .status-pill { padding: 4px 16px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; }
    .status-paid { background-color: #D1FAE5; color: #059669; }
    .status-none { background-color: #F1F5F9; color: #475569; }

    .pen-meta-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        margin-top: 24px;
    }
    .meta-label { font-size: 0.7rem; color: #D4D4D8; margin-bottom: 2px; }
    .meta-value { font-size: 0.85rem; font-weight: 700; color: #1A1A1A; margin-bottom: 4px; }
    .text-red { color: #DC2626; }
    .text-green { color: #059669; }
    .text-orange { color: #EA580C; }

</style>
