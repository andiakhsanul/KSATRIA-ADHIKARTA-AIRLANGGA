@extends('Layout.Admin')
@section('title', 'Users - All')
@section('content-title', 'Users - All')
@section('content')



    <button onclick="openModal('createUser')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Add User
    </button>

    @if (session('success'))
        <div class="mt-4 bg-green-500 text-white p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6 rounded-lg shadow-md">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-zinc-900 text-left">
                    <th class="p-3"></th>
                    <th class="p-3">NIM / NIP</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $user->nim ?? $user->nip }}</td>
                        <td class="p-3">{{ $user->nama_lengkap }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">{{ $user->nama_role }}</td>
                        <td class="p-3">
                            <a href="{{ route('user.edit', $user->id) }}" class="text-yellow-400 hover:underline">Edit</a>
                            <form action="" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
    </div>

    <x-modal id="createUser" title="User Baru">
        <form method="POST" action="{{ route('register') }}" class="space-y-4 py-2 pb-4" x-data="{ useNIM: true, loading: false }">
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
                <label for="password-confirm" class="block text-sm font-medium text-gray-200">Confirm
                    Password</label>
                <input id="password-confirm" name="password_confirmation" type="password" required
                    class="w-full rounded-md border border-gray-700 bg-zinc-900 px-3 py-2 text-white placeholder-gray-400 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary" />
            </div>

            <button type="submit"
                class="w-full rounded-md bg-white px-4 py-2 text-sm font-medium text-black transition-all hover:bg-zinc-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                x-bind:disabled="loading">
                <span x-show="!loading">Buat User</span>
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
    </x-modal>



@endsection
