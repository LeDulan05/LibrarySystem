<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Sign In</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .bg-admin-dark { background-color: #2D3A1B !important; }
            .bg-admin-card { background-color: #415127 !important; }
            .bg-admin-beige { background-color: #FAF6F0 !important; }
            .text-admin-dark { color: #2D3A1B !important; }
            .border-admin-dark { border-color: #2D3A1B !important; }
            .ring-admin-dark { --tw-ring-color: #2D3A1B !important; }
            .hover-bg-admin-dark:hover { background-color: #1f2913 !important; }
        </style>
    </head>
    <body class="antialiased text-gray-900 bg-admin-beige">
        <div class="min-h-screen grid grid-cols-1 md:grid-cols-[55%_45%]">
            <!-- Left Panel -->
            <div class="bg-admin-dark text-white flex flex-col p-8 md:p-16 justify-between min-h-screen">
                <div>
                    <div class="flex items-center space-x-2">
                        <!-- IskoLib Logo Area -->
                        <div class="text-3xl font-bold font-serif tracking-wide flex items-center">
                            <span class="mr-2 bg-white text-[#2D3A1B] p-1 rounded-sm text-xl flex items-center justify-center" style="color: #f05c0a;">🎓</span> IskoLib
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex-grow flex flex-col justify-center">
                    <div class="mb-6">
                        <svg width="180" height="140" viewBox="0 0 180 140" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-xl">
                            <!-- Simple stylized open book matching the mockup -->
                            <rect x="0" y="0" width="85" height="130" fill="#FCF9DA" stroke="#3E4A28" stroke-width="6"/>
                            <rect x="85" y="0" width="85" height="130" fill="#FCF9DA" stroke="#3E4A28" stroke-width="6"/>
                            <rect x="10" y="15" width="40" height="30" fill="#C5E5B4" stroke="#3E4A28" stroke-width="4"/>
                            <line x1="10" y1="55" x2="70" y2="55" stroke="#3E4A28" stroke-width="4" stroke-linecap="round"/>
                            <line x1="10" y1="70" x2="70" y2="70" stroke="#3E4A28" stroke-width="4" stroke-linecap="round"/>
                            <line x1="10" y1="85" x2="50" y2="85" stroke="#3E4A28" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">Library<br>Administration.</h1>
                    <p class="text-lg text-gray-300 font-light max-w-md mb-12">
                        Manage books, members, borrowing transactions, and library operations from one central dashboard.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="bg-admin-card p-6 rounded-xl flex-1 shadow-inner" style="box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);">
                            <div class="text-3xl font-bold mb-1">{{ number_format($activeReservationsCount ?? 0) }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-gray-300 font-semibold">ACTIVE RESERVATIONS</div>
                        </div>
                        <div class="bg-admin-card p-6 rounded-xl flex-1 shadow-inner" style="box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);">
                            <div class="text-3xl font-bold mb-1">{{ number_format($overdueBooksCount ?? 0) }}</div>
                            <div class="text-[10px] uppercase tracking-widest text-gray-300 font-semibold">OVERDUE BOOKS</div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-xs md:text-sm text-gray-400 opacity-60">
                    &copy; 2026 ISKOLARS &mdash; Digital Library Management System
                </div>
            </div>

            <!-- Right Panel -->
            <div class="flex flex-col justify-center px-8 py-12 md:px-16 lg:px-24">
                <div class="mb-8">
                    <span class="inline-flex items-center px-3 py-1 bg-[#E2E6E9] text-[#4B5563] text-xs font-bold rounded-full uppercase tracking-wider">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Admin Portal
                    </span>
                </div>
                
                <div class="mb-8">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Admin Sign In</h2>
                    <p class="text-sm text-gray-500">Access the library management dashboard with administrator credentials.</p>
                </div>

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Admin Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="email" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-admin-dark focus:border-admin-dark sm:text-sm pl-10 pr-4 py-3 bg-white" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@university.edu.ph" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-admin-dark focus:border-admin-dark sm:text-sm pl-10 pr-10 py-3 bg-white" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                                <svg class="h-5 w-5 hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-admin-dark shadow-sm focus:ring-admin-dark" name="remember">
                            <span class="ms-2 text-sm text-gray-600">Remember me</span>
                        </label>

                        <a class="text-sm font-semibold text-[#f05c0a] hover:text-[#d85208] focus:outline-none" href="#">
                            Forgot password?
                        </a>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-admin-dark hover-bg-admin-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-admin-dark transition-colors">
                        Sign In to Admin Portal
                    </button>

                    <div class="relative mt-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-admin-beige text-gray-400">or</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="w-full flex justify-center items-center py-3 px-4 border border-[#f05c0a] rounded-lg shadow-sm text-sm font-bold text-[#f05c0a] bg-white hover:bg-orange-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#f05c0a] transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                            Switch to Student Portal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
