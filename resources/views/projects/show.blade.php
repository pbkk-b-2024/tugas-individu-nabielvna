<x-app-layout>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                  @if($project->cover_image)
                      <img src="{{ Storage::url($project->cover_image) }}" alt="{{ $project->name }} cover" class="w-full h-64 object-cover mb-6">
                  @endif
                  <div class="flex justify-between items-center mb-6">
                      <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $project->name }}</h2>
                      <p class="text-gray-600 dark:text-gray-300">Team: {{ $project->team->name }}</p>
                  </div>
                  <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $project->description }}</p>

                  <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-300">Project Members</h3>
                  <div class="overflow-x-auto mb-4">
                      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                          <thead class="bg-gray-50 dark:bg-gray-700">
                              <tr>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                              </tr>
                          </thead>
                          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                              @foreach ($members as $member)
                                  <tr>
                                      <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $member->name }}</td>
                                      <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $member->email }}</td>
                                      <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">{{ $member->pivot->role }}</td>
                                      <td class="px-6 py-4 whitespace-nowrap">
                                          @if(auth()->user()->can('manage-project-members', $project))
                                              <form method="POST" action="{{ route('projects.remove-member', [$project, $member]) }}" class="inline">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 mr-2" onclick="return confirm('Are you sure you want to remove this member?')">Remove</button>
                                              </form>
                                              <form method="POST" action="{{ route('projects.change-member-role', [$project, $member]) }}" class="inline">
                                                  @csrf
                                                  @method('PATCH')
                                                  <select name="role" onchange="this.form.submit()" class="text-sm text-gray-700 dark:text-gray-300">
                                                      <option value="member" {{ $member->pivot->role == 'member' ? 'selected' : '' }}>Member</option>
                                                      <option value="pic" {{ $member->pivot->role == 'pic' ? 'selected' : '' }}>PIC</option>
                                                  </select>
                                              </form>
                                          @endif
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>

                  @if(auth()->user()->can('manage-project-members', $project))
                      <div class="mt-8">
                          <h3 class="text-xl font-semibold mb-4 text-gray-700 dark:text-gray-300">Add Members</h3>
                          <form method="POST" action="{{ route('projects.add-members', $project) }}">
                              @csrf
                              <div class="mb-4">
                                  <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                                  <select name="members[0][user_id]" id="user_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                      @foreach($availableMembers as $user)
                                          <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="mb-4">
                                  <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                  <select name="members[0][role]" id="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                      <option value="member">Member</option>
                                      <option value="pic">PIC</option>
                                  </select>
                              </div>
                              <div class="flex items-center justify-end mt-4">
                                  <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                      Add Member
                                  </button>
                              </div>
                          </form>
                      </div>
                  @endif
              </div>
          </div>
      </div>
  </div>
</x-app-layout>