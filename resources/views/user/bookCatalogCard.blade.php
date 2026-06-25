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
    
    <title>IskoLib - Book Catalog</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Book Catalog</h1>
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
                
                <a href="{{ route('library') }}" class="back-link">
                    <i class="bi bi-chevron-left"></i> Back to Library
                </a>

                <div class="catalog-card-container">
                    <div class="catalog-card">
                        
                        <div class="card-header">
                            <div class="card-title">
                                <i class="bi bi-box-seam" style="color:#F59E0B; margin-right:8px;"></i>
                                ISKOLIB LIBRARY CATALOG
                            </div>
                            <div class="card-record">
                                Record No. {{ str_pad($book->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="field-row">
                                <div class="field-label">CALL NUMBER</div>
                                <div class="field-value">Q335 .R86 2021</div>
                            </div>
                            
                            <div class="field-row">
                                <div class="field-label">AUTHOR</div>
                                <div class="field-value">{{ $book->author }}</div>
                            </div>
                            
                            <div class="field-row">
                                <div class="field-label">TITLE</div>
                                <div class="field-value" style="font-weight: 700;">{{ $book->title }}</div>
                            </div>
                            
                            <div class="field-row">
                                <div class="field-label">PLACE OF PUBLICATION</div>
                                <div class="field-value">Upper Saddle River, N.J. :<br>Prentice Hall, 2021</div>
                            </div>
                            
                            <div class="field-row">
                                <div class="field-label">PHYSICAL DESCRIPTION</div>
                                <div class="field-value">1132 pages<br>illustrations</div>
                            </div>
                            
                            <div class="field-row">
                                <div class="field-label">ISBN</div>
                                <div class="field-value">{{ $book->isbn }}</div>
                            </div>
                            
                            <div class="field-row" style="border-bottom: 1px dashed #E5E0D5; padding-bottom:20px; margin-bottom:20px;">
                                <div class="field-label">SUBJECT / CATEGORY</div>
                                <div class="field-value">{{ $book->category ? $book->category->name : 'UNCATEGORIZED' }}</div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <div class="copies-info">
                                <div class="copies-label">AVAILABLE COPIES</div>
                                <div class="copies-count {{ $book->available_copies > 0 ? 'text-green' : 'text-red' }}">{{ $book->available_copies }}</div>
                            </div>
                            <div>
                                <a href="{{ route('library.details', $book->id) }}" class="btn-details {{ $book->available_copies > 0 ? 'btn-available' : 'btn-unavailable' }}">
                                    @if($book->available_copies > 0)
                                        ✓ Available — View Details
                                    @else
                                        ✗ Unavailable — View Details
                                    @endif
                                </a>
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

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.95rem;
        color: #52525B;
        text-decoration: none;
        margin-bottom: 24px;
        font-weight: 600;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #1A1A1A;
    }

    /* Catalog Card */
    .catalog-card-container {
        max-width: 700px;
    }

    .catalog-card {
        background-color: #FFFCF7;
        border: 1px solid #E6D0AC;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.03);
        overflow: hidden;
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid #E6D0AC;
        background-color: #FFFDF8;
    }
    .card-title {
        font-size: 0.8rem;
        font-weight: 800;
        color: #52525B;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .card-record {
        font-family: 'DM Mono', monospace;
        font-size: 0.75rem;
        color: #A1A1AA;
    }

    .card-body {
        padding: 32px 24px 16px 24px;
    }

    .field-row {
        margin-bottom: 24px;
    }
    .field-label {
        font-size: 0.75rem;
        color: #A1A1AA;
        margin-bottom: 8px;
        letter-spacing: 0.05em;
    }
    .field-value {
        font-family: 'DM Mono', monospace;
        font-size: 1rem;
        color: #27272A;
        line-height: 1.6;
    }

    .card-footer {
        padding: 20px 24px;
        background-color: #FDF9F1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .copies-label {
        font-size: 0.75rem;
        font-weight: 800;
        color: #A1A1AA;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }
    .copies-count {
        font-size: 1.5rem;
        font-weight: 800;
    }
    .text-green { color: #059669; }
    .text-red { color: #DC2626; }

    .btn-details {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 8px;
        color: white;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        transition: opacity 0.2s;
    }
    .btn-details:hover {
        opacity: 0.9;
    }
    .btn-available { background-color: #059669; }
    .btn-unavailable { background-color: #DC2626; }
</style>
