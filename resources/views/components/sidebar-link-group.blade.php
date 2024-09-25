@props(['label', 'icon', 'active' => false])

<div x-data="{ open: {{ $active ? 'true' : 'false' }} }" class="space-y-2">
    <button
        @click="open = !open"
        class="flex items-center w-full px-4 py-2 text-base font-medium rounded-md transition duration-150 ease-in-out
               {{ $active 
                  ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' 
                  : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' }}
               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
    >
        <i class="{{ $icon }} mr-4 text-xl flex-shrink-0"></i>
        {{ $label }}
        <i class="fas fa-chevron-right ml-auto transform transition-transform duration-200"
           :class="{'rotate-90': open, 'rotate-0': !open}"></i>
    </button>
    <div x-show="open" class="ps-6 space-y-1">
        {{ $slot }}
    </div>
</div>