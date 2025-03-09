@extends('Layout.Admin')
@section('title', 'Buat Tim')
@section('content-title', 'Buat Tim')
@section('content')


    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tim.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="nama_tim" class="block text-sm font-medium">Nama Tim</label>
            <input type="text" name="nama_tim" id="nama_tim"
                class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded focus:outline-none focus:ring focus:ring-blue-500"
                required>
            @error('nama_tim')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Anggota Tim</h3>
            <div id="anggota-container">
                <div class="anggota-item mb-3">
                    <input type="text" name="anggota[0][nama_lengkap]" placeholder="Nama Lengkap"
                        class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white" required>
                    <input type="text" name="anggota[0][nim]" placeholder="NIM"
                        class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white" required>
                    <input type="email" name="anggota[0][email]" placeholder="Email"
                        class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white" required>
                </div>
            </div>
            <button type="button" id="add-anggota"
                class="bg-blue-600 hover:bg-blue-700 transition-all text-white font-semibold py-2 px-4 rounded mt-2">
                Tambah Anggota
            </button>
        </div>

        <div class="flex items-center gap-2">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 transition-all text-white font-semibold py-2 px-4 rounded">
                Simpan Tim
            </button>
            <p class="text-zinc-500 text-xs">*Anda otomatis menjadi ketua dalam tim yang anda buat.</p>
        </div>
    </form>

    <script>
        document.getElementById('add-anggota').addEventListener('click', function() {
            let container = document.getElementById('anggota-container');
            let count = container.getElementsByClassName('anggota-item').length;

            let anggotaHTML = `
                <div class="anggota-item mb-3">
                    <input type="text" name="anggota[${count}][nama_lengkap]" placeholder="Nama Lengkap"
                        class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white" required>
                    <input type="text" name="anggota[${count}][nim]" placeholder="NIM (Opsional)"
                        class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white">
                    <input type="email" name="anggota[${count}][email]" placeholder="Email"
                        class="w-full mt-1 p-2 bg-zinc-800 border border-gray-700 rounded text-white" required>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', anggotaHTML);
        });
    </script>

@endsection
