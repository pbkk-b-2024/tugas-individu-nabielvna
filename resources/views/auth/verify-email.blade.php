<x-guest-layout>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
      <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-lg">
          <div>
              <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                  Verify Your Email Address
              </h2>
              <p class="mt-2 text-center text-sm text-gray-600">
                  Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
              </p>
          </div>

          @if (session('status') == 'verification-link-sent')
              <div class="mb-4 font-medium text-sm text-green-600">
                  A new verification link has been sent to the email address you provided during registration.
              </div>
          @endif

          <div class="mt-4 flex items-center justify-between">
              <form method="POST" action="{{ route('verification.send') }}">
                  @csrf
                  <div>
                      <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                          Resend Verification Email
                      </button>
                  </div>
              </form>

              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                      Log Out
                  </button>
              </form>
          </div>
      </div>
  </div>
</x-guest-layout>