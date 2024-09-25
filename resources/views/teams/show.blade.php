<x-app-layout>
    <div x-data="{ 
        showEditNameModal: false, 
        showEditCoverModal: false,
        teamName: '{{ $team->name }}',
        updateTeamName() {
            fetch('{{ route('teams.update', $team) }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: this.teamName })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Failed to update team name');
                }
            });
        }
    }">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Team Header and Members Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="relative">
                        @if($team->cover_image)
                            <img src="{{ Storage::url($team->cover_image) }}" alt="{{ $team->name }} cover" class="w-full h-64 object-cover">
                        @else
                            <div class="w-full h-64 bg-gray-300 dark:bg-gray-600"></div>
                        @endif
                        @if(auth()->id() == $team->owner_id || auth()->user()->teamRole($team) == 'admin')
                            <button @click="showEditCoverModal = true" class="absolute top-4 right-4 p-2 rounded-full bg-white dark:bg-gray-800 shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </button>
                        @endif
                        <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black to-transparent">
                            <div class="flex items-center">
                                <h2 class="text-3xl font-bold text-white mr-2">{{ $team->name }}</h2>
                                @if(auth()->id() == $team->owner_id || auth()->user()->teamRole($team) == 'admin')
                                    <button @click="showEditNameModal = true" class="p-1 rounded-full bg-white dark:bg-gray-800 shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            <p class="text-white opacity-75">Owner: {{ $team->owner->name }}</p>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800 dark:text-white">Team Members</h3>
                        
                        <!-- Search form for team members -->
                        <form action="{{ route('teams.show', $team) }}" method="GET" class="mb-4">
                            <div class="flex items-center">
                                <input type="text" name="search" id="memberSearch" class="flex-grow px-3 py-2 border border-gray-300 dark:border-gray-500 dark:bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search members..." value="{{ $search ?? '' }}">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                    Search
                                </button>
                                @if(isset($search) && $search)
                                    <a href="{{ route('teams.show', $team) }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </form>

                        <div class="overflow-x-auto rounded-md">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" data-sort="name">
                                            Name
                                            <span class="sort-icon ml-1">&#8645;</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" data-sort="email">
                                            Email
                                            <span class="sort-icon ml-1">&#8645;</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer" data-sort="role">
                                            Role
                                            <span class="sort-icon ml-1">&#8645;</span>
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($members as $member)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $member->name }}
                                                @if ($member->id === auth()->id())
                                                    <span class="ml-2 text-green-500 font-semibold">(you)</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $member->email }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ ucfirst($member->pivot->role) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if (auth()->id() == $team->owner_id)
                                                    @if ($member->id != $team->owner_id)
                                                        <form method="POST" action="{{ route('teams.members.remove', [$team, $member]) }}" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 mr-2" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                                                        </form>
                                                        @if ($member->pivot->role == 'member')
                                                            <form method="POST" action="{{ route('teams.members.promote', [$team, $member]) }}" class="inline">
                                                                @csrf
                                                                <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-900 mr-2">Promote to Admin</button>
                                                            </form>
                                                        @elseif ($member->pivot->role == 'admin')
                                                            <form method="POST" action="{{ route('teams.members.demote', [$team, $member]) }}" class="inline">
                                                                @csrf
                                                                <button type="submit" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900">Demote to Member</button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @elseif (auth()->user()->teamRole($team) == 'admin' && $member->pivot->role == 'member')
                                                    <form method="POST" action="{{ route('teams.members.remove', [$team, $member]) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                                                    </form>
                                                @endif
                                                @if (auth()->id() == $member->id && auth()->id() != $team->owner_id)
                                                    <form method="POST" action="{{ route('teams.leave', $team) }}" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-blue-600 dark:text-blue-400 hover:text-blue-900" onclick="return confirm('Are you sure you want to leave this team?')">Leave Team</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="noResults" class="hidden text-center py-4 text-gray-500 dark:text-gray-400">
                                No results found.
                            </div>
                        </div>
                        <div class="mt-4">
                            {{ $members->appends(['search' => $search ?? null])->links() }}
                        </div>

                        @if (auth()->id() == $team->owner_id || auth()->user()->teamRole($team) == 'admin')
                            <div class="mt-8">
                                <h4 class="text-xl font-semibold mb-4 text-gray-800 dark:text-white">Add Members</h4>
                                <form method="POST" action="{{ route('teams.members.add', $team) }}" id="addMembersForm">
                                    @csrf
                                    <div id="memberInputs">
                                        <!-- Member inputs will be dynamically added here -->
                                    </div>
                                    <div class="mt-2 flex space-x-2">
                                        <button type="button" id="addMoreMembers" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                            Add Member
                                        </button>
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                            Save Members
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Projects Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800 dark:text-white">Projects</h3>
                            @if(auth()->id() == $team->owner_id || auth()->user()->teamRole($team) == 'admin')
                                <a href="{{ route('projects.create', $team) }}" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                    Create New Project
                                </a>
                            @endif
                        </div>
                
                        <!-- Search form for projects -->
                        <form action="{{ route('teams.show', $team) }}" method="GET" class="mb-4">
                            <div class="flex items-center">
                                <input type="text" name="project_search" id="projectSearch" class="flex-grow px-3 py-2 border border-gray-300 dark:border-gray-500 dark:bg-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search projects..." value="{{ $projectSearch ?? '' }}">
                                <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                    Search
                                </button>
                                @if(isset($projectSearch) && $projectSearch)
                                    <a href="{{ route('teams.show', $team) }}" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-colors">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @forelse($projects as $project)
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                    @if($project->cover_image)
                                        <img src="{{ Storage::url($project->cover_image) }}" alt="{{ $project->name }} cover" class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 dark:bg-gray-600"></div>
                                    @endif
                                    <div class="p-4">
                                        <h4 class="text-lg font-semibold mb-2 text-gray-800 dark:text-white">{{ $project->name }}</h4>
                                        <p class="text-gray-600 dark:text-gray-300 mb-4">{{ Str::limit($project->description, 100) }}</p>
                                        <a href="{{ route('projects.show', $project) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">View Project</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600 dark:text-gray-400 col-span-3">No projects found.</p>
                            @endforelse
                        </div>
                
                        <div class="mt-4">
                            {{ $projects->appends(['project_search' => $projectSearch ?? null, 'search' => $search ?? null])->links() }}
                        </div>
                    </div>
                </div>
                
                <!-- Edit Team Name Modal -->
                <div x-show="showEditNameModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="showEditNameModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity dark:bg-gray-800 dark:bg-opacity-75" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="showEditNameModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Edit Team Name</h3>
                                <div class="mt-2">
                                    <input type="text" x-model="teamName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 dark:focus:border-indigo-500">
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 sm:ml-3 sm:w-auto sm:text-sm" @click="updateTeamName(); showEditNameModal = false">Save</button>
                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showEditNameModal = false">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Cover Image Modal -->
                <div x-show="showEditCoverModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div x-show="showEditCoverModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity dark:bg-gray-800 dark:bg-opacity-75" aria-hidden="true"></div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div x-show="showEditCoverModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <form action="{{ route('teams.update-cover-image', $team) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="bg-white dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Edit Cover Image</h3>
                                    <div class="mt-2">
                                        <input type="file" name="cover_image" accept="image/*" class="mt-1 block w-full dark:bg-gray-800 dark:text-gray-100">
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-900 sm:ml-3 sm:w-auto sm:text-sm">Upload</button>
                                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showEditCoverModal = false">Cancel</button>
                                </div>
                            </form>

                            <!-- Delete Cover Image Button -->
                            <form action="{{ route('teams.delete-cover-image', $team) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-900 sm:w-auto sm:text-sm">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addMembersForm = document.getElementById('addMembersForm');
            const memberInputs = document.getElementById('memberInputs');
            const addMoreMembersBtn = document.getElementById('addMoreMembers');
            const isTeamOwner = {{ auth()->id() == $team->owner_id ? 'true' : 'false' }};

            let memberCount = 0;
            const availableUsers = {!! json_encode($availableUsers) !!};

            function createMemberInput(index) {
                const div = document.createElement('div');
                div.className = 'mb-4 flex items-center space-x-4';
                div.innerHTML = `
                    <div class="flex-grow relative">
                        <label for="members[${index}][user_id]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                        <input type="text" class="user-search mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search users...">
                        <select name="members[${index}][user_id]" class="user-select hidden">
                            <option value="">Select a user</option>
                            ${getUserOptions()}
                        </select>
                        <div class="user-dropdown absolute z-10 mt-1 w-full bg-white dark:bg-gray-700 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm hidden">
                            ${getUserDropdownOptions()}
                        </div>
                    </div>
                    <div>
                        <label for="members[${index}][role]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                        <select name="members[${index}][role]" class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="member">Member</option>
                            ${isTeamOwner ? '<option value="admin">Admin</option>' : ''}
                        </select>
                    </div>
                    <button type="button" class="remove-member mt-6 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300">Remove</button>
                `;
                return div;
            }

            function getUserOptions() {
                return availableUsers
                    .map(user => `<option value="${user.id}">${user.name} (${user.email})</option>`)
                    .join('');
            }

            function getUserDropdownOptions() {
                return availableUsers
                    .map(user => `<div class="user-option cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100 dark:hover:bg-gray-600" data-value="${user.id}">${user.name} (${user.email})</div>`)
                    .join('');
            }

            function addMemberInput() {
                const newInput = createMemberInput(memberCount);
                memberInputs.appendChild(newInput);
                memberCount++;
                setupSearchSelect(newInput);
                updateUserSelects();
            }

            function removeMemberInput(event) {
                if (event.target.classList.contains('remove-member')) {
                    event.target.closest('.mb-4').remove();
                    updateUserSelects();
                }
            }

            function setupSearchSelect(container) {
                const searchInput = container.querySelector('.user-search');
                const select = container.querySelector('.user-select');
                const dropdown = container.querySelector('.user-dropdown');

                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const options = dropdown.querySelectorAll('.user-option');

                    options.forEach(option => {
                        const text = option.textContent.toLowerCase();
                        if (text.includes(searchTerm) && !option.classList.contains('opacity-50')) {
                            option.classList.remove('hidden');
                        } else {
                            option.classList.add('hidden');
                        }
                    });

                    dropdown.classList.remove('hidden');
                });

                searchInput.addEventListener('focus', () => {
                    dropdown.classList.remove('hidden');
                });

                document.addEventListener('click', (e) => {
                    if (!container.contains(e.target)) {
                        dropdown.classList.add('hidden');
                    }
                });

                dropdown.addEventListener('click', (e) => {
                    if (e.target.classList.contains('user-option') && !e.target.classList.contains('opacity-50')) {
                        const selectedId = e.target.dataset.value;
                        const selectedText = e.target.textContent;
                        select.value = selectedId;
                        searchInput.value = selectedText;
                        dropdown.classList.add('hidden');
                        updateUserSelects();
                    }
                });
            }

            function updateUserSelects() {
                const selects = document.querySelectorAll('.user-select');
                const selectedUsers = Array.from(selects).map(select => select.value).filter(Boolean);

                selects.forEach(select => {
                    const selectedValue = select.value;
                    const searchInput = select.previousElementSibling;
                    const dropdown = select.nextElementSibling;

                    select.innerHTML = '<option value="">Select a user</option>' + getUserOptions();
                    dropdown.innerHTML = getUserDropdownOptions();

                    Array.from(select.options).forEach(option => {
                        if (option.value) {
                            const isDisabled = selectedUsers.includes(option.value) && option.value !== selectedValue;
                            option.disabled = isDisabled;
                            const dropdownOption = dropdown.querySelector(`[data-value="${option.value}"]`);
                            if (isDisabled) {
                                dropdownOption.classList.add('opacity-50', 'cursor-not-allowed', 'bg-gray-200', 'dark:bg-gray-600');
                                dropdownOption.classList.remove('hover:bg-gray-100', 'dark:hover:bg-gray-600');
                            } else {
                                dropdownOption.classList.remove('opacity-50', 'cursor-not-allowed', 'bg-gray-200', 'dark:bg-gray-600');
                                dropdownOption.classList.add('hover:bg-gray-100', 'dark:hover:bg-gray-600');
                            }
                        }
                    });

                    select.value = selectedValue;
                    if (selectedValue) {
                        searchInput.value = select.options[select.selectedIndex].text;
                    } else {
                        searchInput.value = '';
                    }
                });
            }

            addMoreMembersBtn.addEventListener('click', addMemberInput);
            memberInputs.addEventListener('click', removeMemberInput);
            addMembersForm.addEventListener('change', updateUserSelects);

            // Initialize with one member input
            addMemberInput();

            // Table sorting functionality
            const tableHeaders = document.querySelectorAll('th[data-sort]');
            let currentSort = { column: null, direction: 'asc' };

            tableHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const column = header.dataset.sort;
                    const direction = currentSort.column === column && currentSort.direction === 'asc' ? 'desc' : 'asc';
                    
                    sortTable(column, direction);
                    updateSortIcons(header);

                    currentSort = { column, direction };
                });
            });

            function sortTable(column, direction) {
                const tbody = document.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                const sortedRows = rows.sort((a, b) => {
                    const aValue = a.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                    const bValue = b.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();

                    if (column === 'role') {
                        // Custom sorting for roles (owner > admin > member)
                        const roleOrder = { 'owner': 0, 'admin': 1, 'member': 2 };
                        return direction === 'asc' 
                            ? roleOrder[aValue.toLowerCase()] - roleOrder[bValue.toLowerCase()]
                            : roleOrder[bValue.toLowerCase()] - roleOrder[aValue.toLowerCase()];
                    } else {
                        return direction === 'asc' 
                            ? aValue.localeCompare(bValue)
                            : bValue.localeCompare(aValue);
                    }
                });

                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }

                sortedRows.forEach(row => tbody.appendChild(row));
            }

            function getColumnIndex(column) {
                switch (column) {
                    case 'name': return 1;
                    case 'email': return 2;
                    case 'role': return 3;
                    default: return 1;
                }
            }

            function updateSortIcons(clickedHeader) {
                tableHeaders.forEach(header => {
                    const icon = header.querySelector('.sort-icon');
                    if (header === clickedHeader) {
                        icon.textContent = currentSort.direction === 'asc' ? '▲' : '▼';
                    } else {
                        icon.textContent = '↕';
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>