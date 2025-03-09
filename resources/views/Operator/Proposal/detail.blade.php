@extends('Layout.Admin')
@section('title', 'Upload Proposal')
@section('content-title', 'Upload Proposal')
@section('content')

    <!-- Proposal Header -->
    <div class="bg-black text-zinc-100">
        <div class="border-b border-zinc-800 pb-6 mb-8">
            <div class="mb-6">
                <p class="text-zinc-500 text-sm mb-1">Judul Proposal</p>
                <h2 class="text-2xl font-bold">{{ $proposal->judul_proposal }}</h2>
            </div>

            <div class="mb-6">
                <p class="text-zinc-500 text-sm mb-1">Abstrak</p>
                <p class="text-sm text-zinc-300">{{ $proposal->abstract }}</p>
            </div>

            @php
                $fileParts = explode('/', $proposal->file_path);
                $folder = $fileParts[0]; // Extracts folders name
                $filename = $fileParts[1]; // Extracts the actual filename
            @endphp

            <div class="mb-6">
                <p class="text-zinc-500 text-sm mb-1">File</p>
                <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}" target="_blank"
                    class="inline-flex items-center px-4 py-2 rounded-md border border-zinc-800 hover:bg-zinc-900 text-zinc-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Lihat Proposal
                </a>
            </div>

            <div class="flex items-center">
                <span class="text-sm text-zinc-500 mr-2">Status:</span>
                @if ($proposal->status == 'approved')
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-900 text-green-300">
                        {{ $proposal->status }}
                    </span>
                @elseif($proposal->status == 'rejected')
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-900 text-red-300">
                        {{ $proposal->status }}
                    </span>
                @elseif($proposal->status == 'pending')
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-900 text-yellow-300">
                        {{ $proposal->status }}
                    </span>
                @else
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-zinc-800 text-zinc-300">
                        {{ $proposal->status }}
                    </span>
                @endif
            </div>
        </div>
        <!-- Reviews Section -->
        <div class="mb-10">
            <div class="flex flex-row mb-4 justify-between items-center">
                <h3 class="text-lg font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Review dari Dosen
                </h3>
                @if (Auth::user()->role_id !== 3)
                    <button onclick="openModal('uploadReview')"
                        class="px-4 py-2 border border-gray-700 rounded-md hover:bg-blue-500">Upload Review</button>
                @endif
            </div>

            @if (count($proposal->reviews) > 0)
                <div class="space-y-4">
                    @foreach ($proposal->reviews as $review)
                        <div class="p-4 rounded border border-zinc-800 bg-zinc-900/30">
                            <div class="mb-3">
                                <h4 class="text-zinc-300 font-medium mb-2">Komentar:</h4>
                                <p class="text-zinc-400">{{ $review->comments }}</p>

                                <div class="mt-3 text-xs text-zinc-500 flex gap-4">
                                    <p>Tanggal: {{ \Carbon\Carbon::parse($review->created_at)->format('d-m-Y') }}</p>
                                    <p>Waktu: {{ \Carbon\Carbon::parse($review->created_at)->diffForHumans() }}</p>
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
                                    class="inline-flex items-center px-4 py-2 rounded-md border border-zinc-800 hover:bg-zinc-800 text-blue-400">
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
                                <span class="text-zinc-500 italic">Tidak ada file terlampir</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-zinc-500 italic">Belum ada review</p>
            @endif
        </div>

        <!-- Revisions Section -->
        <div>
            <h3 class="text-xl font-semibold mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Revisi dari Tim
            </h3>

            @if ($proposal->revisions->count() > 0)
                <div class="space-y-4">
                    @foreach ($proposal->revisions as $revisi)
                        <div class="p-4 rounded border border-zinc-800 bg-zinc-900/30">
                            <div class="mb-3">
                                <h4 class="text-zinc-300 font-medium mb-2">Komentar:</h4>
                                <p class="text-zinc-400">{{ $revisi->comments }}</p>
                            </div>

                            <div class="flex flex-row justify-between">
                                @if (!empty($revisi->file_revisi))
                                    @php
                                        $fileParts = explode('/', $revisi->file_revisi);
                                        $folder = $fileParts[0]; // Extracts folders name
                                        $filename = $fileParts[1]; // Extracts the actual filename
                                    @endphp

                                    <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                        target="_blank"
                                        class="inline-flex items-center px-4 py-2 rounded-md border border-zinc-800 hover:bg-zinc-800 text-green-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download Revisi
                                    </a>
                                @endif
                                @if (Auth::user()->role_id === 1)
                                    <a href="">Delete</a>
                                @endif
                            </div>
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
