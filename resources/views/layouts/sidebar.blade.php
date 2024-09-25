<div
    x-data
    x-show="$store.sidebar.open"
    @click.away="if (window.innerWidth < 1024) $store.sidebar.open = false"
    :class="{'translate-x-0 ease-out': $store.sidebar.open, '-translate-x-full ease-in': !$store.sidebar.open}"
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0 bg-white dark:bg-slate-800"
>
    <nav class="py-6 px-3 space-y-2">
        <x-sidebar-link 
            href="{{ route('dashboard') }}"
            icon="fas fa-tachometer-alt"
            label="Dashboard"
            :active="request()->routeIs('dashboard')"
        />

        <x-sidebar-link-group
            label="Teams"
            icon="fas fa-users-cog"
            :active="request()->routeIs('teams.*')"
        >
            <x-sidebar-link 
                href="{{ route('teams.my-teams') }}"
                icon="fas fa-users"
                label="My Teams"
                :active="request()->routeIs('teams.my-teams')"
            />
            
            <x-sidebar-link 
                href="{{ route('teams.create') }}"
                icon="fas fa-plus-circle"
                label="New Team"
                :active="request()->routeIs('teams.create')"
            />
        </x-sidebar-link-group>

        <x-sidebar-link 
            href="#"
            icon="fas fa-file-alt"
            label="Documents"
            :active="request()->routeIs('documents.*')"
        />
    </nav>
</div>