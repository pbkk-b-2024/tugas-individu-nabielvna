@props(['href', 'icon', 'label'])

@php
    $isActive = request()->url() === $href;
@endphp

<a href="{{ $href }}" @class([
    'flex items-center w-full px-4 py-2 text-base font-medium rounded-md transition duration-150 ease-in-out',
    'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white' => !$isActive,
    'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' => $isActive,
    'focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800'
])>
    <i class="{{ $icon }} mr-4 text-xl flex-shrink-0"></i>
    {{ $label }}
</a>