@extends('Layout.Admin')
@section('title', 'Reviewer - All')
@section('content-title', 'Reviewer - All')
@section('content')

    <div class="container mx-auto p-6 bg-white rounded-md">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <a href="{{ route('reviewers.assign') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-5 rounded-lg transition-colors duration-200 shadow-sm flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Assign Reviewer
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reviewer Name
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Assigned Teams
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis PKM
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Proposals
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($reviewers as $reviewer)
                            <tr class="hover:bg-gray-100 transition-colors duration-200 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $reviewer->nama_lengkap }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        @foreach ($reviewer->teamsReviewed as $team)
                                            <div class="flex text-sm text-gray-700">
                                                <span class="text-gray-500 mr-2">{{ $team->id }}.</span>
                                                <span class="font-medium">{{ $team->nama_tim }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        @foreach ($reviewer->teamsReviewed as $team)
                                            <div class="flex items-center text-sm text-gray-700">
                                                <span class="inline-block h-2 w-2 rounded-full bg-blue-500 mr-2"></span>
                                                <span>{{ $team->jenisPkm->nama_pkm }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 max-w-md">
                                    <div class="space-y-2">
                                        @foreach ($reviewer->teamsReviewed as $team)
                                            @foreach ($team->proposals as $proposal)
                                                <div class="flex items-start text-sm text-gray-700">
                                                    <span
                                                        class="inline-block h-2 w-2 rounded-full bg-blue-500 mt-1.5 mr-2 flex-shrink-0"></span>
                                                    <span class="line-clamp-2">
                                                        @if (!$proposal->judul_proposal)
                                                            <span class="italic text-gray-400">Belum Upload Proposal</span>
                                                        @else
                                                            <span class="font-medium">{{ $proposal->tim_id }}</span> -
                                                            {{ $proposal->judul_proposal }}
                                                        @endif
                                                    </span>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if (count($reviewers) === 0)
            <div class="text-center py-10">
                <div class="text-gray-500 mb-2">No reviewers found</div>
                <a href="{{ route('reviewers.assign') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Assign a reviewer
                </a>
            </div>
        @endif
    </div>



@endsection
