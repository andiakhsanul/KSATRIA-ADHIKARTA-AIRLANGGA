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

    @if (Auth::user()->role_id === 3)

        @if ($approved->isNotEmpty())
            <div class="p-6 mt-8 rounded-lg shadow-md border border-gray-200" style="background: white;">
                <div class="flex flex-col md:flex-row items-center">
                    <!-- Simple Icon -->
                    <div class="flex-shrink-0 p-3 mb-4 md:mb-0 md:mr-5 rounded-full bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-700" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">
                            Selamat! 🎉
                        </h2>
                        <p class="text-lg font-medium text-gray-700 mb-4">
                            Tim anda telah berhasil lolos seleksi
                        </p>

                        <!-- Credential Card -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-4">
                            <h3 class="font-semibold text-gray-800 mb-2">Informasi Akun</h3>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <span class="w-28 font-medium text-gray-700">Nama Tim:</span>
                                    <span class="font-semibold text-gray-800">{{ $approved[0]->nama_tim }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-28 font-medium text-gray-700">Username:</span>
                                    <span class="font-semibold text-gray-800">{{ $approved[0]->username }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-28 font-medium text-gray-700">Password:</span>
                                    <div class="relative flex items-center">
                                        <span id="password" class="font-semibold text-gray-800">••••••••</span>
                                        <button onclick="togglePassword()"
                                            class="ml-3 px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-md transition">
                                            <span id="passwordBtnText">Show</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path id="eyeIcon" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path id="eyePath" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                        <button onclick="copyToClipboard('{{ $approved[0]->password }}')"
                                            class="ml-2 px-2 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-md transition">
                                            Copy
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="flex flex-wrap justify-center md:justify-start">
                            <button onclick="showModal('credentialsModal')"
                                class="px-4 py-2 bg-gray-700 text-white font-medium rounded-lg transition hover:bg-gray-800">
                                Petunjuk Penting
                            </button>
                        </div>
                    </div>

                    <!-- Timestamp -->
                    <div class="mt-4 md:mt-0 md:ml-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div id="credentialsModal"
                class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-xl p-6 max-w-md mx-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-purple-800">Informasi Penting</h3>
                        <button onclick="hideModal('credentialsModal')" class="text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <p class="text-gray-700">Dibawah ini terdapat username dan password untuk mengakses website
                            kompetisi.</p>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <p class="text-yellow-700">Dimohon untuk menyimpan informasi ini dengan aman agar bisa lolos ke
                                seleksi berikutnya.</p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded">
                            <p class="font-medium text-blue-800">Username: {{ $approved[0]->username }}</p>
                            <p class="font-medium text-blue-800">Password: {{ $approved[0]->password }}</p>
                        </div>
                        <p class="text-sm text-gray-600">Gunakan kredensial di atas untuk login ke portal kompetisi sebelum
                            tanggal deadline.</p>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button onclick="hideModal('credentialsModal')"
                            class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition">
                            Mengerti
                        </button>
                    </div>
                </div>
            </div>

            <script>
                function togglePassword() {
                    const passEl = document.getElementById('password');
                    const btnText = document.getElementById('passwordBtnText');

                    if (passEl.innerText === '••••••••') {
                        passEl.innerText = '{{ $approved[0]->password }}';
                        btnText.innerText = 'Hide';
                    } else {
                        passEl.innerText = '••••••••';
                        btnText.innerText = 'Show';
                    }
                }

                function copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        // Show a temporary tooltip or notification
                        const tooltip = document.createElement('div');
                        tooltip.innerText = 'Copied!';
                        tooltip.style.position = 'fixed';
                        tooltip.style.left = '50%';
                        tooltip.style.top = '20%';
                        tooltip.style.transform = 'translate(-50%, -50%)';
                        tooltip.style.padding = '8px 16px';
                        tooltip.style.background = 'rgba(0,0,0,0.7)';
                        tooltip.style.color = 'white';
                        tooltip.style.borderRadius = '4px';
                        tooltip.style.zIndex = '9999';
                        document.body.appendChild(tooltip);

                        setTimeout(() => {
                            document.body.removeChild(tooltip);
                        }, 2000);
                    });
                }

                function showModal(id) {
                    document.getElementById(id).classList.remove('hidden');
                }

                function hideModal(id) {
                    document.getElementById(id).classList.add('hidden');
                }
            </script>
        @else
            <div class="p-6 mt-8 rounded-lg shadow-md border-l-4 border-l-gray-400" style="background: white;">
                <div class="flex flex-col md:flex-row items-center">
                    <!-- Icon -->
                    <div class="flex-shrink-0 p-3 mb-4 md:mb-0 md:mr-5 rounded-full bg-gray-200 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 text-center md:text-left">
                        <p class="text-lg font-medium text-gray-700 mb-4">
                            Tim anda sedang dalam proses seleksi
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap justify-center md:justify-start gap-3">
                            <button onclick="showModal('statusInfoModal')"
                                class="px-4 py-2 bg-gray-600 text-white font-medium rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-0.5">
                                Informasi Seleksi
                            </button>
                        </div>
                    </div>

                    <!-- Timestamp -->
                    <div class="mt-4 md:mt-0 md:ml-4 text-sm text-gray-600">
                        {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        @endif
    @endif



    @if (Auth::user()->role_id === 1)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mt-5">
            <div
                class="card flex flex-col bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h1 class="font-bold text-xl text-gray-800">Total Users</h1>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-3xl font-semibold text-gray-900">{{ $total_proposal }}</p>
            </div>
        </div>
    @endif

@endsection
