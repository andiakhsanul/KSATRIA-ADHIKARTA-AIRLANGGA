@extends('Layout.Admin')
@section('title', 'Users - Edit')
@section('content-title', 'Users - Edit')
@section('content')


    <form method="POST" action="{{ route('user.update', $user->id) }}" class="space-y-4 py-2 pb-4" x-data="{ useNIM: true, loading: false }">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-800">Nama Lengkap</label>
            <input id="nama_lengkap" name="nama_lengkap" type="text" value="{{ $user->nama_lengkap }}" required
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600" />
            @error('nama_lengkap')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-800">Pilih Identitas</label>
            <div class="flex space-x-4">
                <button type="button" @click="useNIM = true"
                    :class="useNIM ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 border border-gray-300'"
                    class="w-1/2 rounded-md px-4 py-2 text-sm font-medium transition-all">NIM</button>
                <button type="button" @click="useNIM = false"
                    :class="!useNIM ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 border border-gray-300'"
                    class="w-1/2 rounded-md px-4 py-2 text-sm font-medium transition-all">NIP</button>
            </div>
        </div>

        <div class="space-y-2" x-show="useNIM">
            <label for="nim" class="block text-sm font-medium text-gray-800">NIM <span
                    class="text-xs text-gray-500">*Nomor Induk Mahasiswa</span></label>
            <input id="nim" name="nim" type="text"
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                value="{{ $user->nim }}" />
            @error('nim')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2" x-show="!useNIM">
            <label for="nip" class="block text-sm font-medium text-gray-800">NIP <span
                    class="text-xs text-gray-500">*Nomor Induk Pegawai</span></label>
            <input id="nip" name="nip" type="text"
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                value="{{ $user->nip }}" />
            @error('nip')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-gray-800">Email</label>
            <input id="email" name="email" type="email" required
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600"
                placeholder="name@example.com" value="{{ $user->email }}" />
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="role_id" class="block text-sm font-medium text-gray-800">Role</label>
            <select id="role_id" name="role_id" required
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600">
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
            <label for="password" class="block text-sm font-medium text-gray-800">Password <span
                    class="text-xs text-gray-500">*biarkan kosong jika tidak diganti</span></label>
            <input id="password" name="password" type="password"
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600" />
            @error('password')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="password-confirm" class="block text-sm font-medium text-gray-800">Confirm Password</label>
            <input id="password-confirm" name="password_confirmation" type="password"
                class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-gray-900 placeholder-gray-500 focus:border-blue-600 focus:outline-none focus:ring-1 focus:ring-blue-600" />
        </div>

        <button type="submit"
            class="w-full rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2"
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
