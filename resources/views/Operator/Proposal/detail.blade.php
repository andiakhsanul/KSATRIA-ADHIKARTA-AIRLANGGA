@extends('Layout.Admin')
@section('title', 'Detail Proposal')
@section('content-title', 'Detail Proposal')
@section('content')

    <!-- Proposal Header -->
    <div class="bg-white text-gray-800 rounded-lg shadow-sm">
        <div class="border-b border-gray-200 pb-6 mb-8 p-6">
            <div class="mb-6">
                <p class="text-gray-500 text-sm font-medium mb-1">Judul Proposal</p>
                <h2 class="text-2xl font-bold text-gray-900">{{ $proposal->judul_proposal }}</h2>
            </div>

            <div class="mb-6">
                <p class="text-gray-500 text-sm font-medium mb-1">Abstrak</p>
                <p class="text-gray-700 leading-relaxed">{{ $proposal->abstract }}</p>
            </div>

            @php
                $fileParts = explode('/', $proposal->file_path);
                $folder = $fileParts[0]; // Extracts folders name
                $filename = $fileParts[1]; // Extracts the actual filename
            @endphp

            <div class="mb-6">
                <p class="text-gray-500 text-sm font-medium mb-2">File</p>
                <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white hover:bg-gray-100 text-gray-700 shadow-sm transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Lihat Proposal
                </a>
            </div>

            <div class="flex items-center">
                <span class="text-sm text-gray-500 mr-2 font-medium">Status:</span>
                @if ($proposal->status == 'approved')
                    <span
                        class="px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800 border border-green-200">
                        Approved
                    </span>
                @elseif($proposal->status == 'rejected')
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 border border-red-200">
                        Rejected
                    </span>
                @elseif($proposal->status == 'pending')
                    <span
                        class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                        Pending
                    </span>
                @else
                    <span
                        class="px-3 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                        {{ $proposal->status }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="px-6 pb-6 mb-6">
            <div class="flex flex-row mb-4 justify-between items-center">
                <h3 class="text-lg font-medium flex items-center text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Review dari Dosen
                </h3>
                @if (Auth::user()->role_id !== 3)
                    <button onclick="openModal('uploadReview')"
                        class="px-4 py-2 border border-blue-500 text-blue-600 rounded-md hover:bg-blue-50 font-medium transition-colors duration-150 ease-in-out">
                        Upload Review
                    </button>
                @endif
            </div>

            @if (count($proposal->reviews) > 0)
                <div class="space-y-4">
                    @foreach ($proposal->reviews as $review)
                        <div class="p-5 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
                            <div class="mb-4">
                                <h4 class="text-gray-700 font-medium mb-2">Komentar:</h4>
                                <p class="text-gray-600">{{ $review->comments }}</p>

                                <div class="mt-3 text-xs text-gray-500 flex gap-4">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($review->created_at)->format('d-m-Y') }}
                                    </p>
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            @if ($review->file)
                                @php
                                    $fileParts = explode('/', $review->file);
                                    $folder = $fileParts[0]; // Extracts 'reviews', 'proposals', or 'revisi'
                                    $filename = $fileParts[1]; // Extracts the actual filename
                                @endphp

                                <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 text-blue-600 transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat File Review
                                </a>
                            @else
                                <span class="text-gray-500 italic text-sm">Tidak ada file terlampir</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="py-8 flex flex-col items-center justify-center text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500">Belum ada review</p>
                </div>
            @endif
        </div>

        <!-- Revisions Section -->
        <div class="px-6 pb-6">
            <h3 class="text-lg font-medium mb-4 flex items-center text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Revisi dari Tim
            </h3>

            @if ($proposal->revisions->count() > 0)
                <div class="space-y-4">
                    @foreach ($proposal->revisions as $revisi)
                        <div class="p-5 rounded-lg border border-gray-200 bg-gray-50 shadow-sm">
                            <div class="mb-4">
                                <h4 class="text-gray-700 font-medium mb-2">Komentar:</h4>
                                <p class="text-gray-600">{{ $revisi->comments }}</p>

                                <div class="mt-3 text-xs text-gray-500 flex gap-4">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($revisi->created_at)->format('d-m-Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex flex-row justify-between items-center">
                                @if (!empty($revisi->file_revisi))
                                    @php
                                        $fileParts = explode('/', $revisi->file_revisi);
                                        $folder = $fileParts[0]; // Extracts folders name
                                        $filename = $fileParts[1]; // Extracts the actual filename
                                    @endphp

                                    <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                        target="_blank"
                                        class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 text-green-600 transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download Revisi
                                    </a>
                                @else
                                    <span class="text-gray-500 italic text-sm">Tidak ada file terlampir</span>
                                @endif

                                @if (Auth::user()->role_id === 1)
                                    <a href=""
                                        class="inline-flex items-center px-3 py-1.5 rounded-md border border-red-300 text-red-600 hover:bg-red-50 transition duration-150 ease-in-out">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="py-8 flex flex-col items-center justify-center text-gray-500 bg-gray-50 rounded-lg border border-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500">Belum ada revisi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upload Review Modal -->
    <x-modal id="uploadReview" title="Upload Review">
        <div class="rounded-lg shadow">
            <form action="{{ route('review.store', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="comments" class="block text-gray-700 font-medium mb-2">Komentar:</label>
                    <textarea name="comments"
                        class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-200 focus:border-blue-500 transition duration-150 ease-in-out"
                        rows="4" required></textarea>
                </div>
                <div class="mb-6">
                    <label for="file" class="block text-gray-700 font-medium mb-2">Upload File Review:</label>
                    <div class="relative border border-gray-300 rounded-md">
                        <input type="file" name="file" class="w-full p-2 rounded-md">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Unggah file untuk review (opsional)</p>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeModal('uploadReview')"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition mr-2">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                        Kirim Review
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

@endsection
