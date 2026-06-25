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
    
    <title>IskoLib - My Profile</title>
</head>
<body>
    <div class="layout-container">
        @include('common.sidebarUser')
        <main class="main-canvas">
            <div class="dashboard-header">
                <h1 class="dashboard-title">My Profile</h1>
                <div class="header-right">
                    <a href="{{ url('/notifications') }}" class="notification-icon">
                        <i class="bi bi-bell"></i>
                    </a>
                    <div class="profile-avatar">{{ strtoupper(substr(Auth::user()->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? 'D', 0, 1)) }}</div>
                </div>
            </div>

            <div class="canvas-content">
                
                <div class="profile-layout">
                    
                    <!-- Left Column: User Card -->
                    <div class="left-col">
                        <div class="user-card">
                            <div class="user-avatar-large">
                                {{ strtoupper(substr(Auth::user()->first_name ?? 'J', 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? 'D', 0, 1)) }}
                            </div>
                            <h2 class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
                            <div class="user-course">{{ Auth::user()->course ?? 'BS Computer Science' }}</div>
                            
                            <div class="user-details-list">
                                <div class="detail-row">
                                    <span class="detail-label">Student ID</span>
                                    <span class="detail-value">{{ Auth::user()->student_id ?? '2024-00001' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Year Level</span>
                                    <span class="detail-value">3rd Year</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Member Since</span>
                                    <span class="detail-value">{{ Auth::user()->created_at ? Auth::user()->created_at->format('M Y') : 'Jan 2024' }}</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Status</span>
                                    <span class="status-pill status-active">Active</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Forms -->
                    <div class="right-col">
                        
                        <!-- Personal Info Form -->
                        <div class="form-card">
                            <h3 class="form-title">Personal Information</h3>
                            
                            <form method="post" action="{{ route('profile.update') }}" class="form-grid">
                                @csrf
                                @method('patch')
                                
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', Auth::user()->first_name) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', Auth::user()->last_name) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" value="+63 912 345 6789" placeholder="+63 912 345 6789">
                                </div>
                                
                                <div class="form-group full-width">
                                    <label>Course / Program</label>
                                    <input type="text" name="course" value="{{ old('course', Auth::user()->course) }}">
                                </div>

                                <input type="hidden" name="student_id" value="{{ Auth::user()->student_id }}">

                                <div class="form-actions full-width">
                                    <button type="submit" class="btn-orange">Save Changes</button>
                                    @if (session('status') === 'profile-updated')
                                        <span style="color:#059669; font-size: 0.9rem; margin-left: 12px;">Saved.</span>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Form -->
                        <div class="form-card">
                            <h3 class="form-title">Change Password</h3>
                            
                            <form method="post" action="{{ route('password.update') }}" class="form-col">
                                @csrf
                                @method('put')
                                
                                <div class="form-group full-width">
                                    <label>Current Password</label>
                                    <input type="password" name="current_password" required placeholder="••••••••">
                                </div>
                                
                                <div class="form-group full-width">
                                    <label>New Password</label>
                                    <input type="password" name="password" required placeholder="••••••••">
                                </div>
                                
                                <div class="form-group full-width">
                                    <label>Confirm Password</label>
                                    <input type="password" name="password_confirmation" required placeholder="••••••••">
                                </div>

                                <div class="form-actions full-width">
                                    <button type="submit" class="btn-blue">Update Password</button>
                                    @if (session('status') === 'password-updated')
                                        <span style="color:#059669; font-size: 0.9rem; margin-left: 12px;">Saved.</span>
                                    @endif
                                </div>
                            </form>
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

    .canvas-content { padding: 32px 40px; flex: 1; max-width: 1200px; margin: 0 auto; width: 100%; }

    .profile-layout {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    .left-col { width: 320px; flex-shrink: 0; }
    .right-col { flex: 1; display: flex; flex-direction: column; gap: 24px; }

    /* User Card */
    .user-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 40px 24px;
        text-align: center;
    }
    .user-avatar-large {
        width: 80px;
        height: 80px;
        background-color: #EA580C;
        color: white;
        font-size: 1.75rem;
        font-weight: 800;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px auto;
    }
    .user-name { font-size: 1.25rem; font-weight: 800; color: #1A1A1A; margin-bottom: 4px; }
    .user-course { font-size: 0.9rem; color: #71717A; margin-bottom: 40px; }

    .user-details-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        text-align: left;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .detail-label { font-size: 0.85rem; color: #A1A1AA; }
    .detail-value { font-size: 0.85rem; font-weight: 700; color: #1A1A1A; }
    
    .status-pill { padding: 4px 12px; border-radius: 999px; font-size: 0.75rem; font-weight: 700; }
    .status-active { background-color: #D1FAE5; color: #059669; }

    /* Form Cards */
    .form-card {
        background-color: white;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        padding: 32px;
    }
    .form-title { font-size: 1.1rem; font-weight: 800; color: #1A1A1A; margin-bottom: 24px; }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }
    .form-col {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }
    .full-width { grid-column: 1 / -1; }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .form-group label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #1A1A1A;
    }
    .form-group input {
        padding: 12px 16px;
        border: 1px solid #EAE6DF;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #52525B;
        font-family: inherit;
        outline: none;
        transition: border-color 0.2s;
    }
    .form-group input:focus { border-color: #EA580C; }
    .form-group input::placeholder { color: #D4D4D8; }

    .btn-orange {
        background-color: #EA580C;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: opacity 0.2s;
        font-family: inherit;
    }
    .btn-orange:hover { opacity: 0.9; }

    .btn-blue {
        background-color: #3B82F6;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        transition: opacity 0.2s;
        font-family: inherit;
    }
    .btn-blue:hover { opacity: 0.9; }
</style>
