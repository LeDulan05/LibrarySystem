<x-guest-layout>
    <x-slot name="leftPanel">
        <div class="mb-6 flex justify-center">
            <img src="{{ asset('build/assets/register-illustration.png') }}" alt="Register" class="w-64 max-w-full h-auto mb-8 drop-shadow-xl" />
        </div>
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">Student<br>Registration</h1>
        <p class="text-lg text-gray-300 font-light max-w-md mb-12">
            Access your personal library dashboard, track borrowed books, and discover new titles.
        </p>

        <div class="flex flex-col sm:flex-row gap-4">
            <div class="bg-[#425028] p-6 rounded-xl flex-1 border border-[#4e5c33] shadow-inner">
                <div class="text-3xl font-bold mb-1">12,450</div>
                <div class="text-[10px] uppercase tracking-widest text-gray-300 font-semibold">BOOKS AVAILABLE</div>
            </div>
            <div class="bg-[#425028] p-6 rounded-xl flex-1 border border-[#4e5c33] shadow-inner">
                <div class="text-3xl font-bold mb-1">3,820</div>
                <div class="text-[10px] uppercase tracking-widest text-gray-300 font-semibold">ACTIVE STUDENTS</div>
            </div>
        </div>
    </x-slot>

    <div class="mb-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-2">Create Account</h2>
        <p class="text-sm text-gray-500">Register as a library member</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="flex gap-4 mb-4">
            <!-- First Name -->
            <div class="flex-1">
                <label for="first_name" class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                <input id="first_name" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm px-4 py-3 bg-white" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus placeholder="Juan" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div class="flex-1">
                <label for="last_name" class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                <input id="last_name" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm px-4 py-3 bg-white" type="text" name="last_name" value="{{ old('last_name') }}" required placeholder="dela Cruz" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <!-- Student ID -->
        <div class="mb-4">
            <label for="student_id" class="block text-sm font-semibold text-gray-700 mb-1">Student ID</label>
            <input id="student_id" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm px-4 py-3 bg-white" type="text" name="student_id" value="{{ old('student_id') }}" required placeholder="2024-00001" />
            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <input id="email" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm pl-10 pr-4 py-3 bg-white" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="2022-0145@university.edu.ph" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Course / Program -->
        <div class="mb-4">
            <label for="course" class="block text-sm font-semibold text-gray-700 mb-1">Course / Program</label>
            <input id="course" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm px-4 py-3 bg-white" type="text" name="course" value="{{ old('course') }}" required placeholder="BS Computer Science" />
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
            <input id="password" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm px-4 py-3 bg-white" type="password" name="password" required autocomplete="new-password" placeholder="Create a password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
            <input id="password_confirmation" class="block w-full border-gray-200 rounded-lg shadow-sm focus:ring-[#f05c0a] focus:border-[#f05c0a] sm:text-sm px-4 py-3 bg-white" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-[#f05c0a] hover:bg-[#d85208] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#f05c0a] transition-colors">
            Create My Account
        </button>

        <div class="mt-6 text-center text-sm">
            <span class="text-gray-500">Already registered?</span>
            <a href="{{ route('login') }}" class="font-bold text-[#f05c0a] hover:text-[#d85208] ml-1">Sign in here</a>
        </div>
    </form>
</x-guest-layout>
