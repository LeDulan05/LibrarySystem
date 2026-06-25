<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Sign In</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-900">
    <!-- ADMIN LOGIN -->
    <div class="login-split-screen-grid">
        
        <div class="left-brand-banner-panel">
            <div class="brand-logo-identity-row">
                <img src="{{ asset('AdminAssets/SidebarAssets/logoIcon.svg') }}" alt="IskoLib Logo" class="brand-logo-svg">
                <span class="brand-title-text">IskoLib</span>
            </div>

            <div class="hero-center-content-wrapper">
                <div class="stylized-book-artwork-frame">
                    <div class="book-graphic-art">
                        <div class="left-page-surface">
                            <span class="colored-badge-block"></span>
                            <span class="dummy-text-rule long-rule"></span>
                            <span class="dummy-text-rule short-rule"></span>
                        </div>
                        <div class="right-page-surface">
                            <span class="dummy-text-rule long-rule"></span>
                            <span class="dummy-text-rule long-rule"></span>
                        </div>
                    </div>
                </div>

                <h1 class="hero-main-heading">Library<br>Administration.</h1>
                <p class="hero-descriptor-body">
                    Manage books, members, borrowing transactions, and library operations from one central dashboard.
                </p>

                <div class="metrics-summary-row-cards">
                    <div class="metric-outline-card">
                        <div class="metric-numeric-value">{{ number_format($activeReservationsCount ?? 0) }}</div>
                        <div class="metric-text-label">Active Reservations</div>
                    </div>
                    <div class="metric-outline-card">
                        <div class="metric-numeric-value">{{ number_format($overdueBooksCount ?? 0) }}</div>
                        <div class="metric-text-label">Overdue Books</div>
                    </div>
                </div>
            </div>

            <div class="copyright-footer-text">
                &copy; 2026 ISKOLARS &mdash; Digital Library Management System
            </div>
        </div>

        <div class="right-form-interactive-panel">
            
            <div class="portal-badge-toggle-container">
                <a href="{{ route('login') }}" class="portal-badge-toggle-pill student-pill-inactive">
                    <span class="dot-indicator grey-dot"></span> Student Portal
                </a>
                <div class="portal-badge-toggle-pill admin-pill-active">
                    <span class="dot-indicator blue-dot"></span> Admin Portal
                </div>
            </div>
            
            <div class="form-content-vertical-stack">
                <div class="form-header-group-block">
                    <h2 class="form-title-heading">Admin Sign In</h2>
                    <p class="form-subtitle-descriptor">Access the library management dashboard with administrator credentials.</p>
                </div>

                <form method="POST" action="{{ route('admin.login') }}" class="actual-input-form">
                    @csrf

                    <div class="input-element-field-group">
                        <label for="email" class="input-element-field-label">Admin Email</label>
                        <div class="input-icon-field-wrapper">
                            <i class="bi bi-envelope icon-decorator-left"></i>
                            <input id="email" class="interactive-text-input-field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@university.edu.ph" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="form-validation-error-row" />
                    </div>

                    <div class="input-element-field-group">
                        <label for="password" class="input-element-field-label">Password</label>
                        <div class="input-icon-field-wrapper">
                            <i class="bi bi-lock icon-decorator-left"></i>
                            <input id="password" class="interactive-text-input-field" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                            <i class="bi bi-eye-slash icon-decorator-toggle-right" id="passwordVisibilityToggle" onclick="togglePasswordInputMask()"></i>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="form-validation-error-row" />
                    </div>

                    <div class="form-auxiliary-actions-row">
                        <label for="remember_me" class="checkbox-interaction-label-row">
                            <input id="remember_me" type="checkbox" class="native-form-checkbox-control" name="remember">
                            <span class="checkbox-text-label">Remember me</span>
                        </label>

                        <a class="forgot-password-navigation-link" href="#">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="btn-submit-action-solid">
                        Sign In to Admin Portal
                    </button>

                    <div class="form-logical-splitter-row">
                        <div class="horizontal-splitter-line"></div>
                        <span class="splitter-text-label">or</span>
                        <div class="horizontal-splitter-line"></div>
                    </div>

                    <a href="{{ route('login') }}" class="btn-navigation-action-outline-switch">
                        <i class="bi bi-mortarboard-fill"></i>
                        <span>Switch to Student Portal</span>
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordInputMask() {
            const passwordInputField = document.getElementById('password');
            const toggleIconSelector = document.getElementById('passwordVisibilityToggle');
            
            if (passwordInputField.type === 'password') {
                passwordInputField.type = 'text';
                toggleIconSelector.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                passwordInputField.type = 'password';
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
    
    .login-split-screen-grid {
        display: grid;
        grid-template-columns: 55% 45%;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
    }

    /* Left Brand Panel Styles Architecture */
    .left-brand-banner-panel {
        background-color: #2E3A14; /* Matched from sidebarAdmin standard setup */
        color: #FFFFFF;
        padding: 56px 64px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
    }
    .brand-logo-identity-row {
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
    .hero-center-content-wrapper {
        max-width: 460px;
        width: 100%;
        margin: auto 0;
    }
    
    /* Stylized Mockup Book Graphic Artwork Component */
    .stylized-book-artwork-frame {
        width: 150px;
        height: 110px;
        background-color: transparent;
        margin-bottom: 32px;
        position: relative;
    }
    .book-graphic-art {
        width: 100%;
        height: 100%;
        display: flex;
        background-color: transparent;
        border: 4px solid #3E4C1C;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        overflow: hidden;
    }
    .left-page-surface, .right-page-surface {
        flex: 1;
        background-color: #FAF6F0;
        padding: 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .left-page-surface {
        border-right: 3px solid #3E4C1C;
    }
    .colored-badge-block {
        width: 28px;
        height: 20px;
        background-color: #A4C439;
        border-radius: 3px;
        margin-bottom: 4px;
    }
    .dummy-text-rule {
        height: 3px;
        background-color: #3E4C1C;
        border-radius: 2px;
        opacity: 0.4;
    }
    .dummy-text-rule.long-rule { width: 100%; }
    .dummy-text-rule.short-rule { width: 60%; }

    .hero-main-heading {
        font-family: 'Fraunces', Georgia, serif;
        font-size: 3.25rem;
        line-height: 1.05;
        font-weight: 700;
        letter-spacing: -0.03em;
        margin-bottom: 16px;
    }
    .hero-descriptor-body {
        font-size: 0.95rem;
        color: #D1D5DB;
        line-height: 1.5;
        font-weight: 500;
        margin-bottom: 40px;
    }
    .metrics-summary-row-cards {
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
    .metric-numeric-value {
        font-family: 'JetBrains Mono', monospace;
        font-size: 1.85rem;
        font-weight: 400;
        line-height: 1;
        margin-bottom: 4px;
    }
    .metric-text-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #A1A1AA;
        font-weight: 700;
    }
    .copyright-footer-text {
        font-size: 0.8rem;
        color: #9CA3AF;
        opacity: 0.7;
        font-weight: 500;
    }

    /* Right Interactive Form Panel Styles Architecture */
    .right-form-interactive-panel {
        background-color: #FAF6F0; /* Uniform layout background mapping matching dashboard */
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
    }
    .student-pill-inactive {
        background-color: #E2E6E9;
        color: #4B5563;
    }
    .admin-pill-active {
        background-color: #FFFFFF;
        color: #1A1A1A;
        border: 1px solid #EAE6DF;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .dot-indicator {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }
    .grey-dot { background-color: #9CA3AF; }
    .blue-dot { background-color: #FF5722; }

    .form-content-vertical-stack {
        max-width: 420px;
        width: 100%;
        margin: 0 auto;
    }
    .form-header-group-block {
        margin-bottom: 36px;
    }
    .form-title-heading {
        font-size: 2rem;
        font-weight: 800;
        color: #1A1A1A;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
    }
    .form-subtitle-descriptor {
        font-size: 0.875rem;
        color: #71717A;
        font-weight: 600;
        line-height: 1.4;
    }
    .actual-input-form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .input-element-field-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }
    .input-element-field-label {
        font-size: 0.825rem;
        font-weight: 700;
        color: #1A1A1A;
        margin-bottom: 8px;
    }
    .input-icon-field-wrapper {
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
    }
    .interactive-text-input-field {
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
    .interactive-text-input-field:focus {
        border-color: #2E3A14;
    }
    .icon-decorator-left {
        position: absolute;
        left: 16px;
        font-size: 1.15rem;
        color: #A1A1AA;
        pointer-events: none;
    }
    .icon-decorator-toggle-right {
        position: absolute;
        right: 16px;
        font-size: 1.15rem;
        color: #A1A1AA;
        cursor: pointer;
        transition: color 0.15s;
    }
    .icon-decorator-toggle-right:hover {
        color: #1A1A1A;
    }
    .form-validation-error-row {
        margin-top: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .form-auxiliary-actions-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }
    .checkbox-interaction-label-row {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    .native-form-checkbox-control {
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
    .forgot-password-navigation-link {
        font-size: 0.85rem;
        font-weight: 700;
        color: #FF5722;
        text-decoration: none;
    }
    .btn-submit-action-solid {
        width: 100%;
        height: 50px;
        background-color: #2E3A14;
        border: none;
        border-radius: 12px;
        color: #FFFFFF;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        transition: opacity 0.15s ease;
    }
    .btn-submit-action-solid:hover {
        opacity: 0.95;
    }
    
    .form-logical-splitter-row {
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
    .splitter-text-label {
        font-size: 0.8rem;
        color: #A1A1AA;
        font-weight: 700;
        text-transform: uppercase;
    }
    .btn-navigation-action-outline-switch {
        width: 100%;
        height: 50px;
        background-color: #FFFFFF;
        border: 1px solid #FF5722;
        border-radius: 12px;
        color: #FF5722;
        font-size: 0.9rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        transition: background-color 0.15s ease;
    }
    .btn-navigation-action-outline-switch:hover {
        background-color: rgba(255, 87, 34, 0.02);
    }

    /* Responsive Constraints Window Handling */
    @media (max-width: 900px) {
        .login-split-screen-grid { grid-template-columns: 1fr; }
        .left-brand-banner-panel { display: none; }
        .right-form-interactive-panel { padding: 40px; }
        .portal-badge-toggle-container { top: 40px; right: 40px; }
    }
</style>