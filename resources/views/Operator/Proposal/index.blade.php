@extends('Layout.Admin')
@section('title', 'Manajemen Proposal')
@section('content-title', 'Manajemen Proposal')
@section('content')


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
            <div class="w-full md:w-64">
                <label for="jenis_pkm_id" class="block text-sm font-medium text-gray-700 mb-1">Jenis PKM</label>
                <select id="jenis_pkm_id" name="jenis_pkm_id"
                    class="w-full py-2.5 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                    <option value="">-- Semua Jenis PKM --</option>
                    @foreach ($listJenisPkm as $jenis)
                        <option value="{{ $jenis->id }}" {{ request('jenis_pkm_id') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->nama_pkm }}
                        </option>
                    @endforeach
                </select>
            </div>

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
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul
                        Proposal
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Tim</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis PKM
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                        Upload
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($proposals as $index => $proposal)
                    <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="font-medium text-gray-900">{{ $proposal->judul_proposal }}</div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <span class="font-medium text-gray-700">{{ $proposal->tim->nama_tim }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if ($proposal->tim->reviewers->isNotEmpty())
                                <div class="space-y-1">
                                    @foreach ($proposal->tim->reviewers as $reviewer)
                                        <div class="flex items-center">
                                            <span class="h-1.5 w-1.5 rounded-full bg-blue-600 mr-2"></span>
                                            <span class="text-gray-700">{{ $reviewer->nama_lengkap }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-gray-400 italic">No reviewer assigned</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $proposal->tim->jenisPkm->nama_pkm }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y, H:i') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
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
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $proposals->links() }}

@endsection
