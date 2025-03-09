@extends('Layout.Admin')
@section('title', 'Users - All')
@section('content-title', 'Users - All')
@section('content')


    <form method="POST" action="{{ route('user.update', $user->id) }}" class="space-y-4 py-2 pb-4" x-data="{ useNIM: true, loading: false }">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-200">Nama Lengkap</label>
            <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ $user->nama_lengkap }}" required
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
            <input id="nim" name="nim" type="text"
                class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                value="{{ $user->nim }}" />
            @error('nim')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2" x-show="!useNIM">
            <label for="nip" class="block text-sm font-medium text-gray-200">NIP <span
                    class="text-xs text-zinc-700">*Nomor Induk Pegawai</span></label>
            <input id="nip" name="nip" type="text"
                class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                value="{{ $user->nip }}" />
            @error('nip')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-gray-200">Email</label>
            <input id="email" name="email" type="email" required
                class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary"
                placeholder="name@example.com" value="{{ $user->email }}" />
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="role_id" class="block text-sm font-medium text-gray-200">Role</label>
            <select id="role_id" name="role_id" required
                class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary">
                <option value="" disabled selected>Pilih Role</option>
                @foreach ($role as $item)
                    <option value="{{ $item->id }}"
                        {{ isset($user) && $user->role_id == $item->id ? 'selected' : '' }}>
                        {{ $item->nama_role }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-gray-200">Password <span
                    class="text-xs text-zinc-700">*biarkan kosong jika tidak diganti</span></label>
            <input id="password" name="password" type="password"
                class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password-confirm" class="block text-sm font-medium text-gray-200">Confirm Password</label>
            <input id="password-confirm" name="password_confirmation" type="password"
                class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
        </div>

        <button type="submit"
            class="w-full rounded-md bg-white px-4 py-2 text-sm font-medium text-black transition-all hover:bg-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
            x-bind:disabled="loading">
            <span x-show="!loading">Simpan</span>
            <span x-show="loading" class="flex items-center justify-center">
                <svg class="w-4 h-4 animate-spin mr-2" fill="none" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                Loading...
            </span>
        </button>
    </form>


@endsection
