@extends('Layout.Admin')
@section('title', 'Manajemen Proposal')
@section('content-title', 'Manajemen Proposal')
@section('content')


    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-5" role="alert">
            <p class="">{{ session('error') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-5" role="alert">
            <p class="">{{ session('success') }}</p>
        </div>
    @endif

    <div class="mb-8 flex flex-col sm:flex-row gap-5 sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('operator.proposal.index') }}"
            class="w-full space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
            <!-- Search Input Group -->
            <div class="relative flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Proposals</label>
                <div class="relative">
                    <input type="text" id="search" placeholder="Search proposals..." name="search"
                        value="{{ request('search') }}"
                        class="pl-10 pr-4 py-2.5 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700 bg-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- PKM Type Dropdown -->
            @if (Auth::user()->role_id !== 2)
                <div class="w-full md:w-64">
                    <label for="jenis_pkm_id" class="block text-sm font-medium text-gray-700 mb-1">Jenis PKM</label>
                    <select id="jenis_pkm_id" name="jenis_pkm_id"
                        class="w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                        <option value="">-- Semua Jenis PKM --</option>
                        @foreach ($listJenisPkm as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ request('jenis_pkm_id') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_pkm }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Buttons Group -->
            <div class="flex space-x-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 shadow-sm flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Search
                </button>

                @if (request('search') || request('jenis_pkm_id'))
                    <a href="{{ route('operator.proposal.index') }}"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 shadow-sm flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-x-auto overflow-y-auto rounded-lg shadow-lg">
        <table class="w-full bg-white text-gray-800 border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-12">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Judul
                        Proposal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Nama
                        Tim</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">
                        Reviewer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Jenis
                        PKM</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/6">Tanggal
                        Upload</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">Action
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                {{-- @if (empty($proposal->tim->nama_tim))
                    <p>kosong</p>
                @endif --}}
                @foreach ($proposals as $index => $proposal)
                    @if (empty($proposal->tim->username))
                        <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="font-medium text-gray-900 truncate max-w-xs"
                                    title="{{ $proposal->judul_proposal }}">{{ $proposal->judul_proposal }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span class="font-medium text-gray-700 truncate block max-w-[150px]"
                                    title="{{ $proposal->tim->nama_tim }}">{{ $proposal->tim->nama_tim }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @if ($proposal->tim->reviewers->isNotEmpty())
                                    <div class="space-y-1 max-h-16 overflow-y-auto">
                                        @foreach ($proposal->tim->reviewers as $reviewer)
                                            <div class="flex items-center">
                                                <span
                                                    class="h-1.5 w-1.5 rounded-full bg-blue-600 flex-shrink-0 mr-2"></span>
                                                <span class="text-gray-700 truncate max-w-[120px]"
                                                    title="{{ $reviewer->nama_lengkap }}">{{ $reviewer->nama_lengkap }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400 italic">No reviewer assigned</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                <span class="truncate block max-w-[120px]"
                                    title="{{ $proposal->tim->jenisPkm->nama_pkm }}">{{ $proposal->tim->jenisPkm->nama_pkm }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm flex flex-col gap-3">
                                <a href="{{ route('operator.proposal.detail', ['nama_tim' => $proposal->tim->nama_tim, 'proposal_id' => $proposal->id]) }}"
                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-blue-500 text-white text-xs font-medium rounded-md hover:bg-blue-600 transition-colors duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>
                                <a onclick="openModal('lolosModal-{{ $proposal->id }}')"
                                    class="inline-flex items-center justify-center px-3 py-1.5 border border-green-600 text-black text-xs font-medium rounded-md hover:bg-green-700 hover:text-white transition-colors duration-150 ease-in-out">
                                    Loloskan
                                </a>
                            </td>
                        </tr>

                        <x-modal id="lolosModal-{{ $proposal->id }}" title="Apakah Anda Sudah Yakin ?">
                            <div class="p-2">
                                <!-- Content Section -->
                                <div class="mb-6 text-start">
                                    <p class="text-gray-700 mb-3">Anda akan meloloskan tim:</p>
                                    <div class="bg-blue-50 rounded-lg p-3 mb-4">
                                        <p class="font-bold text-blue-800">{{ $proposal->tim->nama_tim }}</p>
                                    </div>
                                    <p class="text-gray-700 mb-2">dengan judul PKM:</p>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="italic text-gray-800 font-medium">{{ $proposal->judul_proposal }}</p>
                                    </div>
                                </div>

                                <!-- Form Section -->
                                <form action="{{ route('reviewTim.approve', $proposal->tim->id) }}" method="POST"
                                    id="approve-form-{{ $proposal->id }}">
                                    @csrf

                                    <div class="border-t border-gray-200 pt-4">
                                        <!-- Confirmation Checkbox -->
                                        <label
                                            class="flex items-center text-red-600 font-medium mb-3 cursor-pointer hover:bg-red-50 p-2 rounded-md transition-colors">
                                            <input type="checkbox" id="confirm-{{ $proposal->id }}"
                                                onchange="toggleButton({{ $proposal->id }})"
                                                class="mr-3 h-5 w-5 rounded border-red-400 text-red-600 focus:ring-red-500">
                                            <span>Saya yakin ingin meloloskan tim ini</span>
                                        </label>

                                        <!-- Information Notes -->
                                        <div class="bg-yellow-50 p-3 rounded-md mb-4">
                                            <div class="flex items-start">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div class="flex flex-col gap-1">
                                                    <span class="text-sm text-gray-700">Tim yang sudah diloloskan akan
                                                        masuk ke
                                                        halaman <span class="font-medium">Approved Teams</span></span>
                                                    <span class="text-sm text-gray-700">Jika terdapat kesalahan, dapat
                                                        mengedit
                                                        melalui halaman tersebut</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="flex justify-between mt-4">
                                            <button type="button" onclick="closeModal('lolosModal-{{ $proposal->id }}')"
                                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md transition-colors">
                                                Batal
                                            </button>
                                            <button type="submit" id="submit-btn-{{ $proposal->id }}"
                                                class="px-6 py-2 rounded-md text-white bg-gray-400 cursor-not-allowed transition-all duration-200"
                                                disabled>
                                                <span class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Loloskan Tim
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <script>
                                function toggleButton(id) {
                                    const checkbox = document.getElementById(`confirm-${id}`);
                                    const button = document.getElementById(`submit-btn-${id}`);

                                    if (checkbox.checked) {
                                        button.disabled = false;
                                        button.classList.remove("bg-gray-400", "cursor-not-allowed");
                                        button.classList.add("bg-green-600", "cursor-pointer");
                                    } else {
                                        button.disabled = true;
                                        button.classList.remove("bg-green-600", "cursor-pointer");
                                        button.classList.add("bg-gray-400", "cursor-not-allowed");
                                    }
                                }
                            </script>
                        </x-modal>
                    @endif

                @endforeach
            </tbody>
        </table>
    </div>

    {{ $proposals->links() }}

@endsection
