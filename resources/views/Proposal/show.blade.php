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

    <!-- Upload Revisi Modal -->
    <x-modal id="uploadRevisi" title="Upload Revisi">
        <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-md">
            <h3 class="text-xl font-semibold mb-4 text-gray-900">Upload Revisi</h3>
            <form action="{{ route('revisi.store', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="comments" class="block text-sm font-medium mb-1 text-gray-700">Komentar:</label>
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



    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Proposal Header -->
        <div class="bg-white border-b border-gray-300 p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold mb-2 text-gray-800">{{ $proposal->judul_proposal }}</h1>
                    <div class="flex items-center space-x-3">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium">
                            Tim: {{ $proposal->tim->nama_tim }}
                        </span>
                    </div>
                </div>

                @php
                    $fileParts = explode('/', $proposal->file_path);
                    $folder = $fileParts[0]; // Extracts 'reviews', 'proposals', or 'revisi'
                    $filename = $fileParts[1]; // Extracts the actual filename
                @endphp

                <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition flex items-center"
                    target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    View Proposal
                </a>
            </div>
        </div>

        <!-- Proposal Content -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Proposal Details -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-300">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Abstract</h2>
                        <p class="text-gray-700">{{ $proposal->abstract }}</p>
                    </div>

                    <!-- Reviews Section -->
                    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-50 border-b border-gray-300 px-6 py-3 font-medium flex justify-between items-center">
                            <h2 class="text-lg text-gray-800">Reviews ({{ count($proposal->reviews) }})</h2>
                        </div>

                        <div class="divide-y">
                            @forelse($proposal->reviews as $review)
                                <div class="p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div
                                                class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold mr-3">
                                                {{ substr($review->user->nama_lengkap, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-800">
                                                    {{ $review->user->nama_lengkap }}</div>
                                                <div class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y, H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        @if ($review->file)
                                            @php
                                                $fileParts = explode('/', $review->file);
                                                $folder = $fileParts[0]; // Extracts 'reviews', 'proposals', or 'revisi'
                                                $filename = $fileParts[1]; // Extracts the actual filename
                                            @endphp

                                            <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm flex items-center"
                                                target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                View Attachment
                                            </a>
                                        @endif
                                    </div>
                                    <div class="bg-gray-50 p-4 rounded border border-gray-300">
                                        {{ $review->comments }}
                                    </div>
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-500">
                                    No reviews yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Right Column - Revisions & Team Info -->
                <div class="space-y-6">
                    <!-- Team Info -->
                    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 border-b border-gray-300 px-6 py-3 font-medium">
                            <h2 class="text-lg text-gray-800">Team Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Team Name</label>
                                <div class="text-gray-800 font-medium">{{ $proposal->tim->nama_tim }}</div>
                            </div>

                            @if (count($proposal->tim->reviewers) > 0)
                                <div class="mt-4">
                                    <label class="block text-sm font-medium text-gray-500 mb-2">Assigned
                                        Reviewers</label>
                                    <div class="space-y-2">
                                        @foreach ($proposal->tim->reviewers as $reviewer)
                                            <div class="flex items-center space-x-2">
                                                <div
                                                    class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-sm font-bold">
                                                    {{ substr($reviewer->nama_lengkap, 0, 1) }}
                                                </div>
                                                <span class="text-gray-800">{{ $reviewer->nama_lengkap }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="mt-4 text-sm text-gray-500">No reviewers assigned yet.</div>
                            @endif
                        </div>
                    </div>

                    <!-- Revisions Section -->
                    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <div
                            class="bg-gray-50 border-b border-gray-300 px-6 py-3 font-medium flex justify-between items-center">
                            <h2 class="text-lg text-gray-800">Revisions ({{ count($proposal->revisions) }})</h2>
                            <button onclick="openModal('uploadReview')"
                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                Upload Revisi
                            </button>
                        </div>
                        <div class="divide-y">
                            @forelse($proposal->revisions as $revision)
                                <div class="p-6">
                                    <div class="flex justify-between mb-3">
                                        <div class="font-medium text-gray-800">Revision #{{ $revision->id }}</div>
                                    </div>
                                    <div class="text-sm text-gray-500 mb-3">Submitted on
                                        {{ \Carbon\Carbon::parse($revision->created_at)->format('d M Y, H:i') }}
                                    </div>

                                    @if ($revision->file_revisi)
                                        @php
                                            $fileParts = explode('/', $revision->file_revisi);
                                            $folder = $fileParts[0]; // Extracts 'reviews', 'proposals', or 'revisi'
                                            $filename = $fileParts[1]; // Extracts the actual filename
                                        @endphp

                                        <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                            class="block mb-4 text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                            View Revision Document
                                        </a>
                                    @endif

                                    <!-- Comments on this revision -->
                                    @if (count($revision->comments) > 0)
                                        <div class="mt-4">
                                            <h4 class="text-sm font-medium text-gray-700 mb-2">Comments</h4>
                                            <div class="space-y-3">
                                                @foreach ($revision->comments as $comment)
                                                    <div class="bg-gray-50 border border-gray-300 p-3 rounded text-sm">
                                                        <div class="flex justify-between mb-1">
                                                            <span
                                                                class="font-medium text-gray-800">{{ $comment->user->nama_lengkap }}</span>
                                                            <span
                                                                class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y, H:i') }}</span>
                                                        </div>
                                                        <p class="mb-2 text-gray-700">{{ $comment->comment }}</p>
                                                        @if ($comment->lampiran_revisi)
                                                            @php
                                                                $fileParts = explode('/', $comment->lampiran_revisi);
                                                                $folder = $fileParts[0]; // Extracts 'reviews', 'proposals', or 'revisi'
                                                                $filename = $fileParts[1]; // Extracts the actual filename
                                                            @endphp

                                                            <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                                                class="text-blue-600 hover:text-blue-800 text-xs flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3 w-3 mr-1" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                                </svg>
                                                                View Attachment
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="p-6 text-center text-gray-500">
                                    No revisions yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Review Modal -->
    <x-modal id="uploadReview" title="Upload Revisi">

        <form action="{{ route('revisi.store', $proposal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
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
    </x-modal>

    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        }
    </script>

@endsection
