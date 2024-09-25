<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-6 p-10 bg-white rounded-xl shadow-lg">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Create your account
                </h2>
            </div>
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <ul class="mt-3 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
  
            <form x-data="{ 
                    name: '', 
                    email: '',
                    password: '', 
                    passwordConfirmation: '',
                    get nameValid() { return this.name.length > 0 },
                    get emailValid() { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email) },
                    get passwordLength() { return this.password.length >= 8 },
                    get passwordsMatch() { return this.password === this.passwordConfirmation && this.password !== '' }
                }" 
                class="mt-8 space-y-6" 
                action="{{ route('register') }}" 
                method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="name" class="sr-only">Name</label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            required 
                            x-model="name"
                            :class="{'border-red-500': name.length > 0 && !nameValid}"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                            placeholder="Name" 
                            value="{{ old('name') }}"
                        >
                    </div>
                    <div>
                        <label for="email" class="sr-only">Email address</label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            x-model="email"
                            :class="{'border-red-500': email.length > 0 && !emailValid}"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                            placeholder="Email address" 
                            value="{{ old('email') }}"
                        >
                    </div>
                    <div x-data="{ show: false }">
                        <label for="password" class="sr-only">Password</label>
                        <div class="relative">
                            <input 
                                id="password" 
                                name="password" 
                                :type="show ? 'text' : 'password'" 
                                required 
                                x-model="password"
                                :class="{'border-red-500': password.length > 0 && !passwordLength}"
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10" 
                                placeholder="Password"
                            >
                            <x-password-visibility-toggle @click="show = !show" />
                        </div>
                    </div>
                    <div x-data="{ show: false }">
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                name="password_confirmation" 
                                :type="show ? 'text' : 'password'" 
                                required 
                                x-model="passwordConfirmation"
                                :class="{'border-red-500': passwordConfirmation.length > 0 && !passwordsMatch}"
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm pr-10" 
                                placeholder="Confirm Password"
                            >
                            <x-password-visibility-toggle @click="show = !show" />
                        </div>
                    </div>
                </div>

                <div class="space-y-1 text-xs">
                    <div class="flex items-center">
                        <svg class="h-3 w-3 mr-2" :class="{ 'text-green-500': nameValid, 'text-gray-300': !nameValid }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span :class="{ 'text-green-500': nameValid, 'text-gray-500': !nameValid }">
                            Name is not empty
                        </span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-3 w-3 mr-2" :class="{ 'text-green-500': emailValid, 'text-gray-300': !emailValid }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span :class="{ 'text-green-500': emailValid, 'text-gray-500': !emailValid }">
                            Valid email address
                        </span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-3 w-3 mr-2" :class="{ 'text-green-500': passwordLength, 'text-gray-300': !passwordLength }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span :class="{ 'text-green-500': passwordLength, 'text-gray-500': !passwordLength }">
                            Password should be at least 8 characters
                        </span>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-3 w-3 mr-2" :class="{ 'text-green-500': passwordsMatch, 'text-gray-300': !passwordsMatch }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span :class="{ 'text-green-500': passwordsMatch, 'text-gray-500': !passwordsMatch }">
                            Passwords match
                        </span>
                    </div>
                </div>
  
                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
                        :disabled="!nameValid || !emailValid || !passwordLength || !passwordsMatch"
                        :class="{ 'opacity-50 cursor-not-allowed': !nameValid || !emailValid || !passwordLength || !passwordsMatch, 'hover:bg-indigo-500': nameValid && emailValid && passwordLength && passwordsMatch }"
                    >
                        Register
                    </button>
                </div>
  
                <div class="text-sm text-center">
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Already have an account? Sign in
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>