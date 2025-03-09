@extends('Layout.Admin')
@section('title', 'Tim Saya')
@section('content-title', 'Tim Saya')
@section('content')

    @if (session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    {{-- add anggota modal --}}
    <x-modal id="exampleModal" title="Tambah Anggota">
        <form action="{{ route('tim.anggota.add', $tim->id) }}" method="post">
            @csrf
            <div class="mb-4">
                <div id="anggota-container">
                    <div class="anggota-item mb-3">
                        <input type="text" name="anggota[0][nama_lengkap]" placeholder="Nama Lengkap"
                            class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white" required>
                        <input type="text" name="anggota[0][nim]" placeholder="NIM"
                            class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white">
                        <input type="email" name="anggota[0][email]" placeholder="Email"
                            class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="">Tambah</button>
        </form>
    </x-modal>

    @if ($tim)
        <div class="mt-6">
            <div class="flex justify-between items-center mb-3">
                <button onclick="openModal('exampleModal')"
                    class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-md transition text-sm">
                    + Tambah Anggota
                </button>
            </div>

            <div class="bg-zinc-900/50 rounded-lg overflow-hidden">
                @if ($tim->users->count() > 0)
                    <ul class="divide-y divide-zinc-700">
                        @foreach ($tim->users as $user)
                            <li class="p-4 hover:bg-zinc-800 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-white">{{ $user->nama_lengkap }} - {{ $user->nim }}
                                        </p>
                                        <p class="text-zinc-400 text-sm">{{ $user->email }}</p>
                                    </div>
                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                        <div class="flex space-x-2">
                                            <a onclick="openModal('editAnggota{{ $user->id }}')"
                                                class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-white rounded-md transition text-sm">
                                                Edit
                                            </a>
                                            <form
                                                action="{{ route('tim.anggota.remove', ['tim' => $tim->id, 'user' => $user->id]) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')"
                                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md transition text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </li>

                            {{-- edit anggota --}}
                            <x-modal id="editAnggota{{ $user->id }}" title="Edit Anggota">
                                <form action="{{ route('tim.anggota.edit', [$tim->id, $user->id]) }}" method="post">
                                    @csrf
                                    <div class="mb-4">
                                        <div id="anggota-container">
                                            <div class="anggota-item mb-3">
                                                <input type="text" name="nama_lengkap" placeholder="Nama Lengkap"
                                                    class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white"
                                                    value="{{ $user->nama_lengkap }}" required>
                                                <input type="text" name="nim" placeholder="NIM"
                                                    class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white"
                                                    value="{{ $user->nim }}">
                                                <input type="email" name="email" placeholder="Email"
                                                    class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white"
                                                    value="{{ $user->email }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="">Simpan Perubahan</button>
                                </form>
                            </x-modal>
                        @endforeach
                    </ul>
                @else
                    <div class="p-4 text-center text-zinc-500 italic">
                        Belum ada anggota tim
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class=" p-6 rounded-xl shadow-lg border border-zinc-700 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-zinc-600 mb-3" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <p class="text-zinc-400 text-lg">Anda belum tergabung dalam tim.</p>
            <a href="{{ route('tim.create') }}"
                class="mt-4 inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                Buat Tim Baru
            </a>
        </div>
    @endif


@endsection
