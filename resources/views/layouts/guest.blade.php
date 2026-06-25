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
                            <svg width="48" height="48" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2">
                                <!-- Flag Pole -->
                                <rect x="30" y="4" width="4" height="18" fill="#FAF6EE"/>
                                <!-- Flag -->
                                <path d="M34 6H46C48 6 48 10 46 12H34V6Z" fill="#FAF6EE"/>
                                <!-- Building -->
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M32 18L10 38H16V60H48V38H54L32 18ZM32 28C28.686 28 26 30.686 26 34C26 37.314 28.686 40 32 40C35.314 40 38 37.314 38 34C38 30.686 35.314 28 32 28Z" fill="#FAF6EE"/>
                                <!-- Top Book Pages -->
                                <path d="M8 48C18 42 26 46 31.5 50L31.5 54C26 50 18 46 8 52V48Z" fill="#F05C0A"/>
                                <path d="M56 48C46 42 38 46 32.5 50L32.5 54C38 50 46 46 56 52V48Z" fill="#F05C0A"/>
                                <!-- Bottom Book Pages -->
                                <path d="M8 55C18 49 26 53 31.5 57L31.5 60C26 56 18 52 8 58V55Z" fill="#F05C0A"/>
                                <path d="M56 55C46 49 38 53 32.5 57L32.5 60C38 56 46 52 56 58V55Z" fill="#F05C0A"/>
                            </svg>
                            IskoLib
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
