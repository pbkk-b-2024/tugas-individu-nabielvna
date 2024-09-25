<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg">
          <div>
              <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                  Forgot your password?
              </h2>
              <p class="mt-2 text-center text-sm text-gray-600">
                  No worries, we'll send you reset instructions.
              </p>
          </div>
          <form class="mt-8 space-y-6" action="{{ route('password.email') }}" method="POST">
              @csrf
              <div class="rounded-md shadow-sm -space-y-px">
                  <div>
                      <label for="email" class="sr-only">Email address</label>
                      <input id="email" name="email" type="email" required class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Email address">
                  </div>
              </div>

              <div>
                  <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                      Send Reset Link
                  </button>
              </div>

              <div class="text-sm text-center">
                  <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                      Remember your password? Sign in
                  </a>
              </div>
          </form>
      </div>
  </div>
</x-guest-layout>