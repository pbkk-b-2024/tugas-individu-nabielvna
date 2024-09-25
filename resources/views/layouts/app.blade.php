<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('scripts')
        
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
    </head>
    <body class="font-sans antialiased h-full">
        <div 
            x-data
            x-init="
                $store.darkMode.initialize();
            "
            :class="{ 'dark': $store.darkMode.enabled }"
            class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
        >
            <div class="flex flex-col h-screen">
                <!-- Navbar -->
                @include('layouts.navbar')

                <div class="flex flex-1 overflow-hidden">
                    <!-- Sidebar -->
                    @include('layouts.sidebar')

                    <!-- sidebar overlay -->
                    <!-- Overlay for mobile -->
                    <div
                        x-show="$store.sidebar.open"
                        @click="$store.sidebar.toggle()"
                        class="fixed inset-0 z-20 bg-black bg-opacity-55 lg:hidden"
                        x-transition:enter="transition-opacity ease-linear duration-100"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-linear duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    ></div>

                    <!-- Page Content -->
                    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
                        <div class="container mx-auto p-4">
                            {{ $slot }}
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('darkMode', {
                    enabled: localStorage.getItem('darkMode') === 'true',
                    toggle() {
                        this.enabled = !this.enabled;
                        localStorage.setItem('darkMode', this.enabled.toString());
                        this.updateTheme();
                    },
                    updateTheme() {
                        if (this.enabled) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    },
                    initialize() {
                        if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                            localStorage.setItem('darkMode', 'true');
                            this.enabled = true;
                        }
                        this.updateTheme();
                    }
                });

                Alpine.store('sidebar', {
                    open: window.innerWidth >= 1024,
                    toggle() {
                        this.open = !this.open;
                    },
                    init() {
                        window.addEventListener('resize', () => {
                            this.open = window.innerWidth >= 1024;
                        });
                    }
                });

                Alpine.store('sidebar').init();
            });
        </script>
    </body>
</html>