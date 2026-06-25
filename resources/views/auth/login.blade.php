<x-guest-layout>
    <x-slot name="leftPanel">
        <div class="mb-6 flex justify-center">
            <img src="{{ asset('build/assets/login-illustration.png') }}" alt="Sign In" class="w-64 max-w-full h-auto mb-8 drop-shadow-xl" />
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">Welcome back,<br>Student.</h1>
        <p class="text-lg text-gray-300 font-light max-w-md mb-12">
            Access your library account to borrow books, manage reservations, and explore academic resources.
        </p>

        <div class="flex flex-col sm:flex-row gap-4">
            @php
                $totalBooks = \App\Models\Book::count() ?? 0;
                $totalStudents = \App\Models\User::count() ?? 0;
            @endphp
            <div class="bg-[#425028] p-6 rounded-xl flex-1 border border-[#4e5c33] shadow-inner">
                <div class="text-3xl font-bold mb-1">{{ number_format($totalBooks) }}</div>
                <div class="text-[10px] uppercase tracking-widest text-gray-300 font-semibold">BOOKS AVAILABLE</div>
            </div>
            <div class="bg-[#425028] p-6 rounded-xl flex-1 border border-[#4e5c33] shadow-inner">
                <div class="text-3xl font-bold mb-1">{{ number_format($totalStudents) }}</div>
                <div class="text-[10px] uppercase tracking-widest text-gray-300 font-semibold">ACTIVE STUDENTS</div>
            </div>
        </div>
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Sign In</h2>
        <p class="text-sm text-gray-500">Enter your student credentials to access your library account.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Student Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <input id="email" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm pl-10 pr-4 py-3 bg-white" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="2022-0145@university.edu.ph" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
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
                <input id="password" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm pl-10 pr-10 py-3 bg-white" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer" onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password';">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#f05c0a] shadow-sm focus:ring-[#f05c0a]" name="remember">
                <span class="ms-2 text-sm text-gray-600">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-[#f05c0a] hover:text-[#d85208] focus:outline-none" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#f05c0a] hover:bg-[#d85208] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#f05c0a] transition-colors">
            Sign In to Student Portal
        </button>

        <div class="relative mt-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-[#faf6ee] text-gray-500">or</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('login') }}" class="w-full flex justify-center items-center py-3 px-4 border border-indigo-200 rounded-lg shadow-sm text-sm font-bold text-indigo-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Switch to Admin Portal
            </a>
        </div>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">New student?</span>
            <a href="{{ route('register') }}" class="font-bold text-[#f05c0a] hover:text-[#d85208] ml-1">Register your account</a>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const rememberCheckbox = document.getElementById('remember_me');
            
            // Load saved email if exists
            const savedEmail = localStorage.getItem('remembered_email');
            if (savedEmail) {
                emailInput.value = savedEmail;
                rememberCheckbox.checked = true;
            }

            // Save email on form submit if remember me is checked
            document.querySelector('form').addEventListener('submit', function() {
                if (rememberCheckbox.checked) {
                    localStorage.setItem('remembered_email', emailInput.value);
                } else {
                    localStorage.removeItem('remembered_email');
                }
            });
        });
    </script>
</x-guest-layout>
