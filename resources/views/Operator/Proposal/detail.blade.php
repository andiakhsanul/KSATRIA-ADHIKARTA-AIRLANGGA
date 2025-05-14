@extends('Layout.Admin')
@section('title', 'Detail Proposal')
@section('content-title', 'Detail Proposal')
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-md">
                        <p class="text-red-700">{{ $error }}</p>
                    </div>
                @endforeach
            </ul>
        </div>
    @endif

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
                    $fileParts = explode('/', $proposal->file_path ?? '');
                    $folder = $fileParts[0] ?? null;
                    $filename = $fileParts[1] ?? null;
                @endphp

                @if ($folder && $filename)
                    <p>Folder: {{ $folder }}</p>
                    <p>Filename: {{ $filename }}</p>
                @else
                    <p class="text-danger">File path tidak valid.</p>
                @endif

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
                            <button onclick="openModal('uploadReview')"
                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                Add Review
                            </button>
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
                        </div>
                        <div class="divide-y">
                            @forelse($proposal->revisions as $revision)
                                <div class="p-6">
                                    <div class="flex justify-between mb-3">
                                        <div class="font-medium text-gray-800">Revision #{{ $revision->id }}</div>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium uppercase 
                                                {{ $revision->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $revision->status }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500 mb-3">Submitted on
                                        {{ \Carbon\Carbon::parse($revision->created_at)->format('d M Y, H:i') }}
                                    </div>

                                    @if ($revision->file_revisi)
                                        @php
                                            $fileParts = explode('/', $revision->file_revisi);
                                            $folder = $fileParts[0]; // Extracts folders name
                                            $filename = $fileParts[1]; // Extracts the actual filename
                                        @endphp

                                        <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                            target="_blank"
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
                                                                $folder = $fileParts[0]; // Extracts folders name
                                                                $filename = $fileParts[1]; // Extracts the actual filename
                                                            @endphp

                                                            <a href="{{ route('file.view', ['folder' => $folder, 'filename' => $filename]) }}"
                                                                target="_blank"
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

                                    <!-- Add comment form -->
                                    <div class="mt-4">
                                        <form action="{{ route('kirim.komentar', $proposal->id) }}" method="POST"
                                            enctype="multipart/form-data" class="space-y-3">
                                            @csrf
                                            <div>
                                                <textarea name="comment"
                                                    class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-blue-500 focus:border-blue-500"
                                                    rows="2" placeholder="Add a comment..."></textarea>
                                            </div>

                                            <!-- File attachment area -->
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <label for="file-upload"
                                                        class="flex items-center text-sm text-gray-600 cursor-pointer hover:text-blue-600 transition">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                        </svg>
                                                        Lampiran
                                                    </label>
                                                    <input id="file-upload" name="lampiran_revisi" type="file"
                                                        class="hidden" />
                                                    <span class="text-xs text-gray-500 italic">(optional)</span>
                                                </div>

                                                <button type="submit"
                                                    class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition">
                                                    Post
                                                </button>
                                            </div>

                                            <!-- File name display (shows when file is selected) -->
                                            <div id="file-name"
                                                class="hidden text-xs text-gray-600 mt-1 flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span id="selected-file-name">filename.pdf</span>
                                                <button type="button" id="remove-file"
                                                    class="ml-2 text-red-500 hover:text-red-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
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
