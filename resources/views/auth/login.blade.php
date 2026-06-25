<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Student Sign In</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-900">
    <div class="login-split-container">

        <div class="left-brand-panel">
            <div class="brand-top-row">
                <img src="{{ asset('AdminAssets/SidebarAssets/logoIcon.svg') }}" alt="IskoLib Logo" class="brand-logo-svg">
                <span class="brand-title-text">IskoLib</span>
            </div>

            <div class="hero-center-content">
                <img src="{{ asset('/loginLogo.svg') }}" alt="LoginLogo">

                <h1 class="hero-main-heading">Welcome back,<br>Student.</h1>
                <p class="hero-subtext">Access your library account to borrow books, manage reservations, and explore academic resources.</p>

                <div class="metrics-row">
                    <div class="metric-outline-card">
                        <div class="metric-value">{{ number_format($availableBooksCount ?? \App\Models\Book::count()) }}</div>
                        <div class="metric-label">Books Available</div>
                    </div>
                    <div class="metric-outline-card">
                        <div class="metric-value">{{ number_format($activeStudentsCount ?? \App\Models\User::where('role', 'member')->where('status', 'active')->count()) }}</div>
                        <div class="metric-label">Active Students</div>
                    </div>
                </div>
            </div>

            <div class="copyright-text">
                &copy; 2026 ISKOLARS &mdash; Digital Library Management System
            </div>
        </div>

        <div class="right-form-panel">

            <div class="portal-badge-toggle-container">
                <div class="portal-badge-toggle-pill student-pill-active">
                    <span class="dot-indicator green-dot"></span> Student Portal
                </div>
                <a href="{{ route('admin.login') }}" class="portal-badge-toggle-pill admin-pill-inactive">
                    <span class="dot-indicator grey-dot"></span> Admin Portal
                </a>
            </div>

            <div class="form-content-vertical-stack">
                <div class="form-header-block">
                    <h2 class="form-main-title">Sign In</h2>
                    <p class="form-sub-title">Enter your student credentials to access your library account.</p>
                </div>

                {{-- Session Status (e.g. password reset confirmation) --}}
                @if (session('status'))
                    <div class="form-session-status">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Display login errors --}}
                @if ($errors->any())
                    <div class="form-session-status" style="background-color: #FEE2E2; border-color: #FECACA; color: #991B1B;">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="login-inputs-form">
                    @csrf

                    <div class="input-field-group">
                        <label for="email" class="input-element-label">Student Email</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-envelope left-input-icon"></i>
                            <input id="email" class="standard-input-field @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="2022-0145@university.edu.ph" />
                        </div>
                        @error('email')
                            <span class="form-validation-error" style="color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-field-group">
                        <label for="password" class="input-element-label">Password</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-lock left-input-icon"></i>
                            <input id="password" class="standard-input-field @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                            <i class="bi bi-eye-slash right-toggle-icon" id="togglePasswordVisibility" onclick="togglePasswordMask()"></i>
                        </div>
                        @error('password')
                            <span class="form-validation-error" style="color: #dc3545;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="auxiliary-form-actions">
                        <label for="remember_me" class="checkbox-interaction-row">
                            <input id="remember_me" type="checkbox" class="native-form-checkbox" name="remember">
                            <span class="checkbox-text-label">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="forgot-password-link" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-primary-action-solid">
                        Sign In to Student Portal
                    </button>

                    <div class="form-splitter-row">
                        <div class="horizontal-splitter-line"></div>
                        <span class="splitter-text">or</span>
                        <div class="horizontal-splitter-line"></div>
                    </div>

                    <a href="{{ route('admin.login') }}" class="btn-outline-action-switch">
                        <i class="bi bi-shield-lock-fill"></i>
                        <span>Switch to Admin Portal</span>
                    </a>

                    @if (Route::has('register'))
                        <p class="register-prompt-text">
                            New student?
                            <a href="{{ route('register') }}" class="register-prompt-link">Register your account</a>
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordMask() {
            const passwordField = document.getElementById('password');
            const toggleIconSelector = document.getElementById('togglePasswordVisibility');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIconSelector.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordField.type = 'password';
                toggleIconSelector.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
</body>
</html>

<style>
    /* Design Variables and Global Reset Alignment Rules */
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; -webkit-font-smoothing: antialiased; }

    .login-split-container {
        display: grid;
        grid-template-columns: 55% 45%;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
    }

    /* Left Brand Panel Styles Architecture */
    .left-brand-panel {
        background-color: #2E3A14;
        color: #FFFFFF;
        padding: 56px 64px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
    }
    .brand-top-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .brand-logo-svg {
        width: 32px;
        height: 32px;
        filter: brightness(0) invert(1);
    }
    .brand-title-text {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 1.75rem;
        font-weight: 700;
        letter-spacing: -0.02em;
    }
    .hero-center-content {
        max-width: 460px;
        width: 100%;
        margin: auto 0;
    }
    .hero-main-heading {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 3.25rem;
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: -0.03em;
        margin-bottom: 16px;
    }
    .hero-subtext {
        font-size: 0.95rem;
        color: #D1D5DB;
        line-height: 1.5;
        font-weight: 500;
        margin-bottom: 40px;
    }
    .metrics-row {
        display: flex;
        gap: 16px;
        width: 100%;
    }
    .metric-outline-card {
        flex: 1;
        border: 1px solid rgba(255,255,255,0.15);
        background-color: rgba(255,255,255,0.02);
        border-radius: 14px;
        padding: 20px;
    }
    .metric-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.85rem;
        font-weight: 400;
        line-height: 1;
        margin-bottom: 4px;
    }
    .metric-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #A1A1AA;
        font-weight: 700;
    }
    .copyright-text {
        font-size: 0.8rem;
        color: #9CA3AF;
        opacity: 0.7;
        font-weight: 500;
    }

    /* Right Interactive Form Panel Styles Architecture */
    .right-form-panel {
        background-color: #FAF6F0;
        padding: 56px 80px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
        position: relative;
    }
    .portal-badge-toggle-container {
        position: absolute;
        top: 56px;
        right: 80px;
        display: flex;
        gap: 12px;
    }
    .portal-badge-toggle-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .admin-pill-inactive {
        background-color: #E2E6E9;
        color: #4B5563;
    }
    .admin-pill-inactive:hover {
        background-color: #d0d5db;
        color: #1a1a1a;
    }
    .student-pill-active {
        background-color: #FFEDE3;
        color: #FF5722;
        border: 1px solid #FFD9C4;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .dot-indicator {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }
    .grey-dot { background-color: #9CA3AF; }
    .green-dot { background-color: #FF5722; }

    .form-content-vertical-stack {
        max-width: 420px;
        width: 100%;
        margin: 0 auto;
    }
    .form-header-block {
        margin-bottom: 36px;
    }
    .form-main-title {
        font-size: 2rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }
    .form-sub-title {
        font-size: 0.875rem;
        color: #71717A;
        font-weight: 600;
        line-height: 1.4;
    }
    .form-session-status {
        margin-bottom: 20px;
        padding: 12px 16px;
        background-color: #EAF6E9;
        border: 1px solid #BFE3BC;
        border-radius: 10px;
        color: #2E3A14;
        font-size: 0.85rem;
        font-weight: 600;
    }
    .login-inputs-form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .input-field-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }
    .input-element-label {
        font-size: 0.825rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 8px;
    }
    .input-icon-wrapper {
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
    }
    .standard-input-field {
        width: 100%;
        height: 48px;
        padding: 0 16px 0 44px;
        background-color: #FFFFFF;
        border: 1px solid #EAE6DF;
        border-radius: 12px;
        font-family: inherit;
        font-size: 0.9rem;
        color: #1A1A1A;
        font-weight: 600;
        outline: none;
        transition: border-color 0.15s ease;
    }
    .standard-input-field:focus {
        border-color: #2E3A14;
    }
    .standard-input-field.is-invalid {
        border-color: #dc3545;
    }
    .left-input-icon {
        position: absolute;
        left: 16px;
        font-size: 1.15rem;
        color: #A1A1AA;
        pointer-events: none;
    }
    .right-toggle-icon {
        position: absolute;
        right: 16px;
        font-size: 1.15rem;
        color: #A1A1AA;
        cursor: pointer;
        transition: color 0.15s;
    }
    .right-toggle-icon:hover {
        color: #1A1A1A;
    }
    .form-validation-error {
        margin-top: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .auxiliary-form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }
    .checkbox-interaction-row {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    .native-form-checkbox {
        accent-color: #2E3A14;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }
    .checkbox-text-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #4B5563;
    }
    .forgot-password-link {
        font-size: 0.85rem;
        font-weight: 700;
        color: #FF5722;
        text-decoration: none;
    }
    .forgot-password-link:hover {
        text-decoration: underline;
    }
    .btn-primary-action-solid {
        width: 100%;
        height: 50px;
        background-color: #FF5722;
        border: none;
        border-radius: 12px;
        color: #FFFFFF;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: opacity 0.15s ease;
    }
    .btn-primary-action-solid:hover {
        opacity: 0.92;
    }
    .form-splitter-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin: 24px 0;
        width: 100%;
    }
    .horizontal-splitter-line {
        flex: 1;
        height: 1px;
        background-color: #EAE6DF;
    }
    .splitter-text {
        font-size: 0.8rem;
        color: #A1A1AA;
        font-weight: 700;
        text-transform: uppercase;
    }
    .btn-outline-action-switch {
        width: 100%;
        height: 50px;
        background-color: #FFFFFF;
        border: 1px solid #4338CA;
        border-radius: 12px;
        color: #4338CA;
        font-size: 0.9rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-outline-action-switch:hover {
        background-color: rgba(67, 56, 202, 0.05);
        border-color: #3730a3;
        color: #3730a3;
    }
    .register-prompt-text {
        text-align: center;
        margin-top: 20px;
        font-size: 0.85rem;
        color: #71717A;
        font-weight: 600;
    }
    .register-prompt-link {
        color: #FF5722;
        font-weight: 700;
        text-decoration: none;
        margin-left: 4px;
    }
    .register-prompt-link:hover {
        text-decoration: underline;
    }

    /* Responsive Constraints Window Handling */
    @media (max-width: 900px) {
        .login-split-container { grid-template-columns: 1fr; }
        .left-brand-panel { display: none; }
        .right-form-panel { padding: 40px; }
        .portal-badge-toggle-container { top: 40px; right: 40px; }
    }

    @media (max-width: 500px) {
        .right-form-panel { padding: 20px; }
        .portal-badge-toggle-container { 
            position: relative;
            top: 0;
            right: 0;
            margin-bottom: 24px;
            justify-content: center;
        }
        .form-main-title { font-size: 1.5rem; }
        .hero-main-heading { font-size: 2.5rem; }
        .auxiliary-form-actions { flex-direction: column; gap: 12px; align-items: flex-start; }
        .metrics-row { flex-direction: column; }
    }
</style>