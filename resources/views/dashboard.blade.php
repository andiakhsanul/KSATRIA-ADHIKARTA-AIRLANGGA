@extends('Layout.Admin')
@section('title', 'Dashboard')
@section('content-title', 'Dashboard')
@section('content')

    @if (Auth::user()->tim_id === null && Auth::user()->role_id === 3)
        <div class="mx-auto p-4 bg-white rounded-lg shadow-lg border border-gray-200 mb-5">
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
            <p class="mt-2 text-sm text-gray-700">
                Kamu belum memiliki TIM. Silakan buat atau bergabung dengan tim terlebih dahulu untuk melanjutkan.
            </p>
        </div>
    @endif



    <div class="mx-auto p-4 flex flex-row justify-between items-center bg-white rounded-lg border border-gray-300">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 11c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3zM15 5l4 4M19 19H5a2 2 0 01-2-2V5a2 2 0 012-2h7M19 14v6M19 19l-3-3">
                </path>
            </svg>
            <span class="ml-3 text-lg font-semibold">Selamat Datang, {{ Auth::user()->nama_lengkap }}!</span>
        </div>
        <div class="logout">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <input type="submit" value="Logout"
                    class="px-4 py-2 border border-red-500 hover:bg-red-500 text-gray-700 rounded-md transition-all">
            </form>
        </div>
    </div>
    
    @if (Auth::user()->role_id === 1)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-5">
            <div
                class="card flex flex-col bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="font-bold text-xl text-gray-800">Total Users</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <p class="text-3xl font-semibold text-gray-900">{{ $users }}</p>
            </div>

            <div
                class="card flex flex-col bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="font-bold text-xl text-gray-800">Approved Users</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <p class="text-3xl font-semibold text-gray-900">{{ $approved_users }}</p>
            </div>

            <div
                class="card flex flex-col bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="font-bold text-xl text-gray-800">Total Tim</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-3xl font-semibold text-gray-900">{{ $total_tim }}</p>
            </div>

            <div
                class="card flex flex-col bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="font-bold text-xl text-gray-800">Total Proposal</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-3xl font-semibold text-gray-900">{{ $total_proposal }}</p>
            </div>
        </div>
    @endif

@endsection
