<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">My Teams</h2>
                        <a href="{{ route('teams.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                            Create New Team
                        </a>
                    </div>
                    
                    @if($teams->isEmpty())
                        <p class="text-gray-600 dark:text-gray-400 text-center py-8">You are not a member of any teams yet.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($teams as $team)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                    @if($team->cover_image)
                                        <img src="{{ Storage::url($team->cover_image) }}" alt="{{ $team->name }} cover" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-600"></div>
                                    @endif
                                    <div class="p-6">
                                        <h3 class="text-xl font-semibold mb-2 text-gray-800 dark:text-white">{{ $team->name }}</h3>
                                        <p class="text-gray-600 dark:text-gray-300 mb-2">Members: {{ $team->members->count() }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Your role: {{ $team->members->find(auth()->id())->pivot->role }}</p>
                                    </div>
                                    <div class="bg-gray-50 dark:bg-gray-600 px-6 py-4 flex justify-between items-center">
                                        <a href="{{ route('teams.show', $team) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">View Team</a>
                                        @if(auth()->id() == $team->owner_id)
                                            <form method="POST" action="{{ route('teams.destroy', $team) }}" onsubmit="return confirm('Are you sure you want to delete this team?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">Delete Team</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>