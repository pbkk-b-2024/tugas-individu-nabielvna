<nav x-data="{ isProfileOpen: false }" class="bg-white dark:bg-slate-800 shadow transition-colors duration-200 border-b dark:border-zinc-700">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Sidebar toggle button - visible only on mobile -->
                <button 
                    @click="$store.sidebar.toggle()"
                    class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 lg:hidden"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center ml-4">
                    <span class="text-xl font-bold text-gray-800 dark:text-white">{{ config('app.name', 'Laravel') }}</span>
                </div>
            </div>

            <div class="flex items-center">
                <!-- Dark mode toggle -->
                <x-dark-mode-toggle/>

                <!-- Profile dropdown -->
                <div class="ml-3 relative">
                    <div>
                        <button @click="isProfileOpen = !isProfileOpen" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/150" alt="User avatar">
                        </button>
                    </div>
                    <div x-show="isProfileOpen" @click.away="isProfileOpen = false" class="origin-top-right z-50 absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <a href={{ route('profile.edit') }} class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem">Settings</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600" role="menuitem">Sign out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>