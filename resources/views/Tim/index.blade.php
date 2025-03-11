@extends('Layout.Admin')
@section('title', 'Tim Saya')
@section('content-title', 'Tim Saya')
@section('content')

    {{-- Alert Messages --}}
    @if (session('error'))
        <x-alert type="error" :message="session('error')" />
    @endif
    @if (session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    {{-- Add Member Modal --}}
    <x-modal id="exampleModal" title="Tambah Anggota">
        <form action="{{ route('tim.anggota.add', $tim->id) }}" method="post" class="space-y-4">
            @csrf
            <div id="anggota-container" class="space-y-4">
                <div class="anggota-item p-4 border border-zinc-700 rounded-lg">
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-zinc-400 mb-1 block">Nama Lengkap</label>
                            <input type="text" name="anggota[0][nama_lengkap]"
                                class="w-full p-3 bg-zinc-800 border border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                                required>
                        </div>
                        <div>
                            <label class="text-sm text-zinc-400 mb-1 block">NIM</label>
                            <input type="text" name="anggota[0][nim]"
                                class="w-full p-3 bg-zinc-800 border border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black">
                        </div>
                        <div>
                            <label class="text-sm text-zinc-400 mb-1 block">Email</label>
                            <input type="email" name="anggota[0][email]"
                                class="w-full p-3 bg-zinc-800 border border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                                required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-black font-medium rounded-md transition-colors duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah
                </button>
            </div>
        </form>
    </x-modal>

    @if ($tim)
        <div class="mt-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-700"></h2>
                <button onclick="openModal('exampleModal')"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-black rounded-md transition-colors duration-200 flex items-center shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Anggota
                </button>
            </div>

            <div class="bg-white rounded-lg overflow-hidden border border-gray-400 shadow-md">
                @if ($tim->users->count() > 0)
                    <ul class=" bg-white">
                        @foreach ($tim->users as $user)
                            <li class="p-5 transition-colors duration-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-gray-100 rounded-full p-2 text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-black text-lg">{{ $user->nama_lengkap }}</p>
                                            <div class="flex flex-col sm:flex-row sm:space-x-4 text-sm">
                                                <p class="text-zinc-400">
                                                    <span
                                                        class="inline-block bg-blue-600 px-2 py-0.5 rounded text-xs mr-1 text-white">NIM</span>
                                                    {{ $user->nim }}
                                                </p>
                                                <p class="text-zinc-400">
                                                    <span
                                                        class="inline-block bg-blue-600 px-2 py-0.5 rounded text-xs mr-1 text-white">Email</span>
                                                    {{ $user->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                        <div class="flex space-x-2">
                                            <button onclick="openModal('editAnggota{{ $user->id }}')"
                                                class="px-3 py-1.5 bg-amber-600 hover:bg-amber-700 text-black rounded-md transition-colors duration-200 text-sm flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </button>
                                            <form
                                                action="{{ route('tim.anggota.remove', ['tim' => $tim->id, 'user' => $user->id]) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus anggota ini?')"
                                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-black rounded-md transition-colors duration-200 text-sm flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </li>

                            {{-- Edit Member Modal --}}
                            <x-modal id="editAnggota{{ $user->id }}" title="Edit Anggota">
                                <form action="{{ route('tim.anggota.edit', [$tim->id, $user->id]) }}" method="post"
                                    class="space-y-4">
                                    @csrf
                                    <div class="space-y-4 p-4 bg-zinc-800/50 border border-zinc-700 rounded-lg">
                                        <div>
                                            <label class="text-sm text-zinc-400 mb-1 block">Nama Lengkap</label>
                                            <input type="text" name="nama_lengkap"
                                                class="w-full p-3 bg-zinc-800 border border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                                                value="{{ $user->nama_lengkap }}" required>
                                        </div>
                                        <div>
                                            <label class="text-sm text-zinc-400 mb-1 block">NIM</label>
                                            <input type="text" name="nim"
                                                class="w-full p-3 bg-zinc-800 border border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                                                value="{{ $user->nim }}">
                                        </div>
                                        <div>
                                            <label class="text-sm text-zinc-400 mb-1 block">Email</label>
                                            <input type="email" name="email"
                                                class="w-full p-3 bg-zinc-800 border border-zinc-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-black"
                                                value="{{ $user->email }}" required>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-6">
                                        <button type="submit"
                                            class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-black font-medium rounded-md transition-colors duration-200 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </form>
                            </x-modal>
                        @endforeach
                    </ul>
                @else
                    <div class="p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-zinc-600 mb-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-zinc-400 text-lg">Belum ada anggota tim</p>
                        <p class="text-zinc-500 text-sm mt-2">Klik tombol 'Tambah Anggota' untuk menambahkan anggota baru
                        </p>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="p-10 rounded-xl shadow-lg border border-zinc-700 text-center bg-zinc-900/50 mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-zinc-600 mb-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <h2 class="text-black text-2xl font-bold mb-2">Tidak Dalam Tim</h2>
            <p class="text-zinc-400 text-lg mb-6">Anda belum tergabung dalam tim manapun.</p>
            <a href="{{ route('tim.create') }}"
                class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-black rounded-lg transition-colors duration-200 font-medium shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Buat Tim Baru
            </a>
        </div>
    @endif


@endsection
