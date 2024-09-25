<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg">
          <div>
              <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                  Confirm Password
              </h2>
              <p class="mt-2 text-center text-sm text-gray-600">
                  This is a secure area. Please confirm your password before continuing.
              </p>
          </div>
          <form class="mt-8 space-y-6" action="{{ route('password.confirm') }}" method="POST">
              @csrf
              <div class="rounded-md shadow-sm -space-y-px">
                  <div>
                      <label for="password" class="sr-only">Password</label>
                      <input id="password" name="password" type="password" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                  </div>
              </div>

              <div>
                  <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Confirm Password
                  </button>
              </div>
          </form>
      </div>
  </div>
</x-guest-layout>