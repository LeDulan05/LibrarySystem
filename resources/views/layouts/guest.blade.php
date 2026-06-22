<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-[#faf6ee]">
        <div class="min-h-screen grid grid-cols-1 md:grid-cols-[55%_45%]">
            <!-- Left Panel -->
            <div class="bg-[#33411b] text-white flex flex-col p-8 md:p-16 justify-between min-h-screen">
                <div>
                    <div class="flex items-center space-x-2">
                        <!-- IskoLib Logo Area -->
                        <div class="text-3xl font-bold font-serif tracking-wide flex items-center">
                            <span class="mr-2 bg-white text-[#33411b] p-1 rounded-sm text-xl flex items-center justify-center">🎓</span> IskoLib
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex-grow flex flex-col justify-center">
                    @if (isset($leftPanel))
                        {{ $leftPanel }}
                    @endif
                </div>

                <div class="mt-12 text-xs md:text-sm text-gray-400">
                    &copy; {{ date('Y') }} ISKOLARS &mdash; Digital Library Management System
                </div>
            </div>

            <!-- Right Panel -->
            <div class="flex flex-col justify-center px-8 py-12 md:px-16 lg:px-24">
                <div class="mb-8">
                    <span class="inline-flex items-center px-3 py-1 bg-orange-100 text-[#f05c0a] text-xs font-bold rounded-full uppercase tracking-wider">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        Student Portal
                    </span>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
