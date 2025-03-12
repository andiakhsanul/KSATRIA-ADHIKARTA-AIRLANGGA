@extends('Layout.Admin')
@section('title', 'Buat Tim')
@section('content-title', 'Buat Tim')
@section('content')


    @if (session('success'))
        <div class="bg-green-500 text-gray-700 p-4 rounded-lg mb-6 shadow-md flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded-lg mb-6 shadow-md flex items-center">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-300">

        <form action="{{ route('tim.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="nama_tim" class="block text-sm font-medium text-gray-700 mb-1">Nama Tim</label>
                <input type="text" name="nama_tim" id="nama_tim"
                    class="w-full p-3 border border-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-700"
                    required>
                @error('nama_tim')
                    <p class="text-red-400 text-sm mt-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="pkm_id" class="block text-gray-700 font-medium">Jenis PKM:</label>
                <select id="pkm_id" name="pkm_id" required
                    class="w-full bg-white border border-gray-300 rounded-md px-4 py-2.5 text-gray-700 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="" disabled selected>Pilih PKM</option>
                    @foreach ($pkm as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_pkm }}</option>
                    @endforeach
                </select>
                @error('pkm_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            

            <div class="mt-8 pt-4 ">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 transition-all text-white font-semibold py-3 px-6 rounded-md shadow flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Simpan Tim
                </button>
            </div>
        </form>
    </div>

@endsection
