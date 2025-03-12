@extends('Layout.Admin')
@section('title', 'Proposal Detail')
@section('content-title', 'Proposal Detail')
@section('content')

    <a href="{{ url()->previous() }}"
        class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 transition-colors inline-flex items-center mb-5 text-gray-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back
    </a>

    <div class="bg-white text-gray-800 rounded-lg shadow-sm border border-gray-200 p-6">
        <!-- Proposal Header -->
        <div class="border-b border-gray-200 pb-6 mb-8">
            <div class="mb-6">
                <p class="text-gray-500 text-sm mb-1 font-medium">Judul Proposal</p>
                <h2 class="text-2xl font-bold text-gray-900">{{ $proposal->judul_proposal }}</h2>
            </div>

            <div class="mb-6">
                <p class="text-gray-500 text-sm mb-1 font-medium">Abstrak</p>
                <p class="text-gray-700">{{ $proposal->abstract }}</p>
            </div>

            <div class="mb-6">
                <p class="text-gray-500 text-sm mb-1 font-medium">File</p>
                <a href="{{ route('file.view', ['folder' => explode('/', $proposal->file_path)[0], 'filename' => explode('/', $proposal->file_path)[1]]) }}"
                    target="_blank"
                    class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition-colors text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Lihat file
                </a>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mb-10 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold mb-5 flex items-center text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span>Nama Dosen Reviewer</span>
            </h3>

            <div class="mb-5 pl-7">
                <ul class="list-disc text-gray-700">
                    @forelse ($proposal->reviewers as $reviewer)
                        <li class="mb-1">{{ $reviewer->nama_lengkap }} <span
                                class="text-gray-500 text-sm">{{ $reviewer->email }}</span></li>
                    @empty
                        <li class="text-gray-500 italic">No reviewers assigned.</li>
                    @endforelse
                </ul>
            </div>

            @if (count($proposal->reviews) > 0)
                <div class="space-y-5">
                    @foreach ($proposal->reviews as $review)
                        <div class="p-6 rounded-lg border border-gray-200 bg-gray-50 hover:border-gray-300 transition-all">
                            <div class="mb-4">
                                <h4 class="text-gray-800 font-medium mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Komentar: {{ $review->user->nama_lengkap }}
                                </h4>
                                <p class="text-gray-700 bg-white p-4 rounded border border-gray-100">{{ $review->comments }}
                                </p>

                                <div class="mt-4 text-xs text-gray-500 flex gap-6">
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($review->created_at)->format('d-m-Y') }}
                                    </p>
                                    <p class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none"
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
                                    class="inline-flex items-center px-4 py-2 rounded-md bg-blue-50 border border-blue-200 hover:bg-blue-100 transition-colors text-blue-600 font-medium">
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
                                <span class="text-gray-500 italic flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tidak ada file terlampir
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-gray-500 italic">Belum ada review</p>
                </div>
            @endif
        </div>

        <!-- Revisions Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold flex items-center text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Revisi dari Tim
                </h3>

                @if (Auth::user()->role_id == 3)
                    <button onclick="openModal('uploadRevisi')"
                        class="inline-flex items-center px-4 py-2 rounded-md border border-green-500 bg-green-50 hover:bg-green-100 transition-colors text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Upload Revisi
                    </button>
                @endif
            </div>

            @if (Auth::user()->role_id == 3)
                @if (count($proposal->revisions) > 0)
                    <div class="space-y-4">
                        @foreach ($proposal->revisions as $revisi)
                            <div class="p-5 rounded-lg border border-gray-200 bg-gray-50">
                                <div class="mb-3">
                                    <h4 class="text-gray-800 font-medium mb-2">Komentar:</h4>
                                    <p class="text-gray-700">{{ $revisi->comments }}</p>
                                </div>

                                <div class="flex flex-row justify-between">
                                    @if (!empty($revisi->file_revisi))
                                        @php
                                            $fileParts = explode('/', $revisi->file_revisi);
                                            $folder = $fileParts[0]; // Extracts 'reviews', 'proposals', or 'revisi'
                                            $filename = $fileParts[1]; // Extracts the actual filename
                                        @endphp
                                        <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                            target="_blank"
                                            class="inline-flex items-center px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 transition-colors text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                            Download Revisi
                                        </a>
                                    @endif
                                    @if (Auth::user()->role_id === 1)
                                        <a href=""
                                            class="text-red-600 hover:text-red-800 font-medium flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v10M9 7h6m-6 0H5.5a2.5 2.5 0 010-5h13a2.5 2.5 0 010 5H14" />
                                            </svg>
                                            Delete
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada revisi</p>
                @endif

                <!-- Upload Revisi Modal -->
                <x-modal id="uploadRevisi" title="Upload Revisi">
                    <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-md">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Upload Revisi</h3>
                        <form action="{{ route('revisi.store', $proposal->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="comments"
                                    class="block text-sm font-medium mb-1 text-gray-700">Komentar:</label>
                                <textarea name="comments" id="comments" rows="3"
                                    class="w-full p-2 rounded-md bg-white border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800"
                                    required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="file_revisi" class="block text-sm font-medium mb-1 text-gray-700">Upload File
                                    Revisi:</label>
                                <input type="file" name="file_revisi" id="file_revisi"
                                    class="w-full p-2 rounded-md bg-white border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-gray-800">
                            </div>
                            <button type="submit"
                                class="w-full py-2 px-4 rounded-md bg-green-600 hover:bg-green-700 text-white transition-colors">
                                Kirim Revisi
                            </button>
                        </form>
                    </div>
                </x-modal>
            @endif
        </div>
    </div>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        }
    </script>


@endsection
