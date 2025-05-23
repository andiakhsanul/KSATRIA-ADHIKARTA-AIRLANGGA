@extends('Layout.Guest')
@section('title', 'Login')
@section('content')


    <div class="flex min-h-screen items-center justify-center p-4 bg-gray-50">
        <div class="w-full max-w-md space-y-8 rounded-lg border border-gray-300 bg-white p-6 shadow-lg">
            
            <img src="{{ asset('assets/unair-ditmawa.png') }}" alt="unair-ditmawa" class="w-full">

            <div class="text-center">
                <h1 class="text-2xl font-bold text-gray-900">KSATRIA ADHIKARTA AIRLANGGA</h1>
                <p class="text-gray-600">Sign in to your account</p>
            </div>

            {{-- alert --}}
            @if (session('error'))
                <x-alert type="error" :message="session('error')" />
            @endif
            @if (session('success'))
                <x-alert type="success" :message="session('success')" />
            @endif
            @if (session('warning'))
                <x-alert type="warning" :message="session('warning')" />
            @endif

            <form method="POST" action="{{ route('login.authenticate') }}" class="space-y-4 py-2 pb-4">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 placeholder-gray-400 focus:border-[#0975cb] focus:outline-none focus:ring-1 focus:ring-[#0975cb]"
                        placeholder="name@example.com" />
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#0975cb] hover:underline">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 placeholder-gray-400 focus:border-[#0975cb] focus:outline-none focus:ring-1 focus:ring-[#0975cb]" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                        class="h-4 w-4 rounded border-gray-300 bg-white text-[#0975cb] focus:ring-[#0975cb]" />
                    <label for="remember" class="text-sm font-medium leading-none text-gray-700">
                        Remember me
                    </label>
                </div>

                <button type="submit"
                    class="w-full rounded-md bg-[#0975cb] px-4 py-2 text-sm font-medium text-white transition-all hover:bg-[#0864ad] focus:outline-none focus:ring-2 focus:ring-[#0975cb] focus:ring-offset-2">
                    Login
                </button>
            </form>

            <div class="mt-4 text-center text-sm text-gray-600">
                <p>Don't have an account? <a href="{{ route('register.index') }}"
                        class="text-[#0975cb] hover:underline">Register</a></p>
            </div>
        </div>
    </div>

   

@endsection
