@extends('Layout.Guest')
@section('title', 'Register')
@section('content')
    <div class="flex min-h-screen items-center justify-center bg-black p-4">
        <div class="w-full max-w-md space-y-4 rounded-lg border border-gray-800 bg-black p-6 shadow-lg">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-white">Create Account</h1>
                <p class="text-gray-400">Sign up for a new account</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4 py-2 pb-4" x-data="{ useNIM: true, loading: false }"            >
                @csrf

                <div class="space-y-2">
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-200">Nama Lengkap</label>
                    <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ old('nama_lengkap') }}" required
                        class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-200">Pilih Identitas</label>
                    <div class="flex space-x-4">
                        <button type="button" @click="useNIM = true"
                            :class="useNIM ? 'bg-white text-black' : 'bg-zinc-900 text-gray-300'"
                            class="w-1/2 rounded-md px-4 py-2 text-sm font-medium transition-all">NIM</button>
                        <button type="button" @click="useNIM = false"
                            :class="!useNIM ? 'bg-white text-black' : 'bg-zinc-900 text-gray-300'"
                            class="w-1/2 rounded-md px-4 py-2 text-sm font-medium transition-all">NIP</button>
                    </div>
                </div>

                <div class="space-y-2" x-show="useNIM">
                    <label for="nim" class="block text-sm font-medium text-gray-200">NIM <span
                            class="text-xs text-zinc-700">*Nomor Induk Mahasiswa</span></label>
                    <input id="nim" name="nim" type="text" value="{{ old('nim') }}"
                        x-bind:required="useNIM"
                        class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="123456789" />
                    @error('nim')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2" x-show="!useNIM">
                    <label for="nip" class="block text-sm font-medium text-gray-200">NIP <span
                            class="text-xs text-zinc-700">*Nomor Induk Pegawai</span></label>
                    <input id="nip" name="nip" type="text" value="{{ old('nip') }}"
                        x-bind:required="!useNIM"
                        class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                        placeholder="1987654321" />
                    @error('nip')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

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
                    <label for="password" class="block text-sm font-medium text-gray-200">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password-confirm" class="block text-sm font-medium text-gray-200">Confirm Password</label>
                    <input id="password-confirm" name="password_confirmation" type="password" required
                        class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
                </div>

                <button type="submit"
                    class="w-full rounded-md bg-white px-4 py-2 text-sm font-medium text-black transition-all hover:bg-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
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


            <div class="mt-4 text-center text-sm text-gray-400">
                <p>Already have an account? <a href="{{ route('login') }}" class="text-primary hover:underline">Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
