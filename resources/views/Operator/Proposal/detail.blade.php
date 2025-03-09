@extends('Layout.Admin')
@section('title', 'Upload Proposal')
@section('content-title', 'Upload Proposal')
@section('content')

    <!-- Proposal Header -->
    <div class="pb-4 mb-6">
        <div class="mb-4">
            <p class="text-zinc-400 font-sm">Judul Proposal</p>
            <h2 class="text-2xl font-bold">{{ $proposal->judul_proposal }}</h2>
        </div>
        <div class="mb-4">
            <p class="text-zinc-400 font-sm">Abstrak</p>
            <p class="text-sm">{{ $proposal->abstract }}</p>
        </div>
        <div class="mb-4">
            <p class="text-zinc-400 font-sm">File</p>
            <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download
            </a>
        </div>

        <div class="mt-2">
            <span class="text-sm font-medium mr-2">Status:</span>
            @php
                $statusClasses = [
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                    'pending' => 'bg-yellow-100 text-yellow-800',
                ];
                $statusClass = $statusClasses[$proposal->status] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                {{ ucfirst($proposal->status) }}
            </span>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mb-8">
        <div class="flex flex-row items-center justify-between mb-4">
            <h3 class="text-xl font-semibold flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Review dari Dosen
            </h3>
            @if (Auth::user()->role_id !== 3)
                <button onclick="openModal('uploadReview')"
                    class="px-4 py-2 border border-gray-700 rounded-md hover:bg-blue-500">Upload Review</button>
            @endif
        </div>

        @if ($proposal->reviews->count() > 0)
            <div class="space-y-4">
                @foreach ($proposal->reviews as $review)
                    <div class="p-4 rounded-lg border border-gray-300">
                        <div class="mb-3">
                            <h4 class="font-medium">Komentar:</h4>
                            <p class="mt-1 text-gray-600">{{ $review->comments }}</p>
                            <p class="mt-1 text-gray-600">
                                Tanggal: {{ \Carbon\Carbon::parse($review->created_at)->format('d-m-Y') }}
                            </p>
                            <p class="mt-1 text-gray-600">
                                Waktu: {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}
                            </p>
                        </div>

                        @if ($review->file)
                            @php
                                $fileParts = explode('/', $review->file);
                                $folder = $fileParts[0]; // Extract folder ('reviews', 'proposals', or 'revisi')
                                $filename = $fileParts[1]; // Extract filename
                            @endphp

                            <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                            <span class="text-sm text-gray-500 italic">Tidak ada file terlampir</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">Belum ada review</p>
        @endif
    </div>

    <!-- Revisions Section -->
    <div>
        <h3 class="text-xl font-semibold mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Revisi dari Tim
        </h3>

        @if ($proposal->revisions->count() > 0)
            <div class="space-y-4">
                @foreach ($proposal->revisions as $revisi)
                    <div class="p-4 rounded-lg border border-gray-300">
                        <div class="mb-3">
                            <h4 class="font-medium">Komentar:</h4>
                            <p class="mt-1 text-gray-600">{{ $revisi->comments }}</p>
                        </div>

                        <a href="{{ asset('storage/' . $revisi->file_revisi) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download Revisi
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic">Belum ada revisi</p>
        @endif
    </div>

    <!-- Upload Review -->
    <x-modal id="uploadReview" title="Upload Review">
        <div class="rounded-lg shadow">
            <form action="{{ route('review.store', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="comments" class="block font-semibold">Komentar:</label>
                    <textarea name="comments" class="w-full p-2 border rounded" rows="3" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="file" class="block font-semibold">Upload File Review:</label>
                    <input type="file" name="file" class="border p-2 w-full rounded">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Kirim Review
                </button>
            </form>
        </div>
    </x-modal>

@endsection
