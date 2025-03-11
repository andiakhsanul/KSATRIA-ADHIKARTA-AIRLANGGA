@extends('Layout.Admin')
@section('title', 'Upload Proposal')
@section('content-title', 'Upload Proposal')
@section('content')

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-md mb-6 shadow-sm">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-8 border border-gray-200">

        <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="space-y-2">
                <label for="judul_proposal" class="block text-gray-700 font-medium">Judul Proposal:</label>
                <input type="text" id="judul_proposal" name="judul_proposal" required
                    class="w-full bg-white border border-gray-300 rounded-md px-4 py-2.5 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                    placeholder="Masukkan judul proposal">
                @error('judul_proposal')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="abstract" class="block text-gray-700 font-medium">Abstract:</label>
                <textarea id="abstract" name="abstract" required rows="8"
                    class="w-full bg-white border border-gray-300 rounded-md px-4 py-2.5 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
                    placeholder="Tuliskan abstract proposal"></textarea>
                @error('abstract')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="file" class="block text-gray-700 font-medium">File (PDF atau DOCX):</label>
                <div class="flex items-center justify-center w-full">
                    <label for="file"
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-blue-200 border-dashed rounded-lg cursor-pointer bg-blue-50 hover:bg-blue-100 transition">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-600"><span class="font-semibold">Klik untuk upload</span></p>
                            <p class="text-xs text-gray-500">PDF atau DOCX (Maks. 10MB)</p>
                        </div>
                        <input id="file" type="file" name="file" accept=".pdf,.docx" required class="hidden" />
                    </label>
                </div>
                <div id="file-name" class="text-sm text-blue-600 mt-2 font-medium"></div>
                @error('file')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 shadow-md">
                    <div class="flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Upload Proposal
                    </div>
                </button>
            </div>
        </form>
    </div>

    <script>
        // Display file name when selected
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'No file selected';
            const fileNameElement = document.getElementById('file-name');
            fileNameElement.textContent = 'File selected: ' + fileName;
            fileNameElement.classList.add('flex', 'items-center');

            // Add file icon
            if (fileName !== 'No file selected') {
                const icon = document.createElement('span');
                icon.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
            </svg>
        `;
                fileNameElement.prepend(icon);
            }
        });
    </script>



@endsection
