@extends('Layout.Admin')
@section('title', 'Dashboard')
@section('content-title', 'Dashboard')
@section('content')

    @if (Auth::user()->tim_id === null && Auth::user()->role_id == -3)
        <div class="mx-auto p-4 bg-black text-white rounded-lg shadow-lg border border-yellow-700">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M10.29 3.86l-6.3 11.26A1 1 0 005 17h14a1 1 0 00.87-1.48l-6.3-11.26a1 1 0 00-1.74 0z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01"></path>
                </svg>
                <span class="ml-3 text-lg font-semibold">Buat Dulu TIM Kamu</span>
            </div>
            <p class="mt-2 text-sm text-gray-300">
                Kamu belum memiliki TIM. Silakan buat atau bergabung dengan tim terlebih dahulu untuk melanjutkan.
            </p>
        </div>
    @else
        <div class="mx-auto p-4 bg-black text-white rounded-lg shadow-lg border border-gray-700">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zM15 5l4 4M19 19H5a2 2 0 01-2-2V5a2 2 0 012-2h7M19 14v6M19 19l-3-3">
                    </path>
                </svg>
                <span class="ml-3 text-lg font-semibold">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</span>
            </div>
            <p class="mt-2 text-sm text-gray-300">
                Semoga harimu menyenangkan! Gunakan platform ini dengan bijak.
            </p>
        </div>
    @endif


    <div class="controls mt-5">
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <input type="submit" value="Logout"
                class="px-4 py-2 border border-red-500 hover:bg-red-500 text-white rounded-md transition-all">
        </form>
    </div>


@endsection
