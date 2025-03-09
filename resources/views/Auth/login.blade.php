@extends('Layout.Guest')
@section('title', 'Login')
@section('content')
    <div class="flex min-h-screen items-center justify-center bg-black p-4">
        <div class="w-full max-w-md space-y-8 rounded-lg border border-gray-800 p-6 shadow-lg">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-white">KSATRIA ADHIKARTA AIRLANGGA</h1>
                <p class="text-gray-400">Sign in to your account</p>
            </div>

            {{-- alert --}}
            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif

            <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-4 py-2 pb-4">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-200">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="name@example.com" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary hover:underline">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-600 bg-zinc-900 text-primary focus:ring-primary" />
                    <label for="remember" class="text-sm font-medium leading-none text-gray-200">
                        Remember me
                    </label>
                </div>

                <button type="submit"
                    class="w-full rounded-md bg-white px-4 py-2 text-sm font-medium text-black transition-all hover:bg-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    Login
                </button>
            </form>

            <div class="mt-4 text-center text-sm text-gray-400">
                <p>Don't have an account? <a href="{{ route('register.index') }}"
                        class="text-blue-400 hover:underline">Register</a></p>
            </div>
        </div>
    </div>
@endsection
