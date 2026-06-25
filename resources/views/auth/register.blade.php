<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Student Registration</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700&family=Plus+Jakarta+Sans:wght@500;600;700;800&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-gray-900">
    <div class="login-split-container register-split-container">

        <div class="left-brand-panel">
            <div class="brand-top-row">
                <img src="{{ asset('AdminAssets/SidebarAssets/logoIcon.svg') }}" alt="IskoLib Logo" class="brand-logo-svg">
                <span class="brand-title-text">IskoLib</span>
            </div>

            <div class="hero-center-content">
                <img src="{{ asset('/loginLogo.svg') }}" alt="LoginLogo">

                <h1 class="hero-main-heading">Student<br>Registration.</h1>
                <p class="hero-subtext">Access your personal library dashboard, track borrowed books, and discover new titles.</p>

                <div class="metrics-row">
                    <div class="metric-outline-card">
                        <div class="metric-value">{{ number_format($availableBooksCount ?? \App\Models\Book::count()) }}</div>
                        <div class="metric-label">Books Available</div>
                    </div>
                    <div class="metric-outline-card">
                        <div class="metric-value">{{ number_format($activeStudentsCount ?? \App\Models\User::where('role', 'member')->count()) }}</div>
                        <div class="metric-label">Active Students</div>
                    </div>
                </div>
            </div>

            <div class="copyright-text">
                &copy; 2026 ISKOLARS &mdash; Digital Library Management System
            </div>
        </div>

        <div class="right-form-panel register-form-panel">

            <div class="portal-badge-toggle-container">
                <div class="portal-badge-toggle-pill student-pill-active">
                    <span class="dot-indicator green-dot"></span> Student Portal
                </div>
                <a href="{{ route('admin.login') }}" class="portal-badge-toggle-pill admin-pill-inactive">
                    <span class="dot-indicator grey-dot"></span> Admin Portal
                </a>
            </div>

            <div class="form-content-vertical-stack register-content-stack">
                <div class="form-header-block">
                    <h2 class="form-main-title">Create Account</h2>
                    <p class="form-sub-title">Register as a library member to get started.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="login-inputs-form">
                    @csrf

                    <div class="name-fields-row">
                        <div class="input-field-group">
                            <label for="first_name" class="input-element-label">First Name</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-person left-input-icon"></i>
                                <input id="first_name" class="standard-input-field" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="Juan" />
                            </div>
                            <x-input-error :messages="$errors->get('first_name')" class="form-validation-error" />
                        </div>

                        <div class="input-field-group">
                            <label for="last_name" class="input-element-label">Last Name</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-person left-input-icon"></i>
                                <input id="last_name" class="standard-input-field" type="text" name="last_name" value="{{ old('last_name') }}" required placeholder="dela Cruz" />
                            </div>
                            <x-input-error :messages="$errors->get('last_name')" class="form-validation-error" />
                        </div>
                    </div>

                    <div class="input-field-group">
                        <label for="student_id" class="input-element-label">Student ID</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-card-text left-input-icon"></i>
                            <input id="student_id" class="standard-input-field" type="text" name="student_id" value="{{ old('student_id') }}" required placeholder="2024-00001" />
                        </div>
                        <x-input-error :messages="$errors->get('student_id')" class="form-validation-error" />
                    </div>

                    <div class="input-field-group">
                        <label for="email" class="input-element-label">Email Address</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-envelope left-input-icon"></i>
                            <input id="email" class="standard-input-field" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="student@university.edu.ph" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="form-validation-error" />
                    </div>

                    <div class="input-field-group">
                        <label for="course" class="input-element-label">Course / Program</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-mortarboard left-input-icon"></i>
                            <input id="course" class="standard-input-field" type="text" name="course" value="{{ old('course') }}" placeholder="BS Computer Science" />
                        </div>
                        <x-input-error :messages="$errors->get('course')" class="form-validation-error" />
                    </div>

                    <div class="input-field-group">
                        <label for="password" class="input-element-label">Password</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-lock left-input-icon"></i>
                            <input id="password" class="standard-input-field" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
                            <i class="bi bi-eye-slash right-toggle-icon" id="togglePasswordVisibility" onclick="togglePasswordMask('password', 'togglePasswordVisibility')"></i>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="form-validation-error" />
                    </div>

                    <div class="input-field-group">
                        <label for="password_confirmation" class="input-element-label">Confirm Password</label>
                        <div class="input-icon-wrapper">
                            <i class="bi bi-lock left-input-icon"></i>
                            <input id="password_confirmation" class="standard-input-field" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password" />
                            <i class="bi bi-eye-slash right-toggle-icon" id="toggleConfirmVisibility" onclick="togglePasswordMask('password_confirmation', 'toggleConfirmVisibility')"></i>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="form-validation-error" />
                    </div>

                    <button type="submit" class="btn-primary-action-solid register-submit-btn">
                        Create My Account
                    </button>

                    <p class="register-prompt-text">
                        Already registered?
                        <a href="{{ route('login') }}" class="register-prompt-link">Sign in here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordMask(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIconSelector = document.getElementById(iconId);

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
    .register-split-container {
        height: auto;
        min-height: 100vh;
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
        margin: 24px 0 16px;
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
    .register-form-panel {
        height: auto;
        min-height: 100vh;
        padding: 96px 80px 56px;
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
    .admin-pill-inactive {
        background-color: #E2E6E9;
        color: #4B5563;
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
    }
    .grey-dot { background-color: #9CA3AF; }
    .green-dot { background-color: #FF5722; }

    .form-content-vertical-stack {
        max-width: 420px;
        width: 100%;
        margin: 0 auto;
    }
    .register-content-stack {
        max-width: 460px;
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
    .login-inputs-form {
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    .name-fields-row {
        display: flex;
        gap: 16px;
    }
    .name-fields-row .input-field-group {
        flex: 1;
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
    .register-submit-btn {
        margin-top: 8px;
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
        .register-form-panel { padding: 40px; }
        .portal-badge-toggle-container { top: 40px; right: 40px; }
        .name-fields-row { flex-direction: column; gap: 0; }
    }
</style>