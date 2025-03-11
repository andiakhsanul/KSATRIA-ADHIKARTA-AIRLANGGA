@extends('Layout.Guest')
@section('title', 'Register')
@section('content')

<div class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-md space-y-4 rounded-lg border border-gray-300 bg-white p-6 shadow-lg">
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">Create Account</h1>
            <p class="text-gray-600">Sign up for a new account</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4 py-2 pb-4" x-data="{ useNIM: true, loading: false }">
            @csrf

            <div class="space-y-2">
                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('nama_lengkap') }}" required
                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600" />
                @error('nama_lengkap')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Pilih Identitas</label>
                <div class="flex space-x-4">
                    <button type="button" @click="useNIM = true"
                        :class="useNIM ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="w-1/2 rounded-md px-4 py-2 text-sm font-medium transition-all">NIM</button>
                    <button type="button" @click="useNIM = false"
                        :class="!useNIM ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700'"
                        class="w-1/2 rounded-md px-4 py-2 text-sm font-medium transition-all">NIP</button>
                </div>
            </div>

            <div class="space-y-2" x-show="useNIM">
                <label for="nim" class="block text-sm font-medium text-gray-700">NIM</label>
                <input id="nim" name="nim" type="text" value="{{ old('nim') }}"
                    x-bind:required="useNIM"
                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    placeholder="123456789" />
                @error('nim')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2" x-show="!useNIM">
                <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                <input id="nip" name="nip" type="text" value="{{ old('nip') }}"
                    x-bind:required="!useNIM"
                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    placeholder="1987654321" />
                @error('nip')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                    placeholder="name@example.com" />
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600" />
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input id="password-confirm" name="password_confirmation" type="password" required
                    class="w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600" />
            </div>

            <button type="submit"
                class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"
                x-bind:disabled="loading">
                <span x-show="!loading">Register</span>
                <span x-show="loading" class="flex items-center justify-center">
                    <svg class="w-4 h-4 animate-spin mr-2" fill="none" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    Loading...
                </span>
            </button>
        </form>

        <div class="mt-4 text-center text-sm text-gray-600">
            <p>Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a></p>
        </div>
    </div>
</div>

@endsection
