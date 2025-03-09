@extends('Layout.Admin')
@section('title', 'Upload Proposal')
@section('content-title', 'Upload Proposal')
@section('content')

    <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="judul_proposal" class="block text-zinc-300 font-medium">Judul Proposal:</label>
            <input type="text" id="judul_proposal" name="judul_proposal" required
                class="w-full bg-zinc-900 border border-zinc-600 rounded-md px-4 py-2.5 text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Masukkan judul proposal">
            @error('judul_proposal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="abstract" class="block text-zinc-300 font-medium">Abstract:</label>
            <textarea id="abstract" name="abstract" required rows="5"
                class="w-full bg-zinc-900 border border-zinc-600 rounded-md px-4 py-2.5 text-white placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                placeholder="Tuliskan abstract proposal"></textarea>
            @error('abstract')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="file" class="block text-zinc-300 font-medium">File (PDF atau DOCX):</label>
            <div class="flex items-center justify-center w-full">
                <label for="file"
                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-zinc-600 border-dashed rounded-lg cursor-pointer bg-zinc-900 hover:bg-zinc-600 transition">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg class="w-8 h-8 mb-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                            </path>
                        </svg>
                        <p class="mb-2 text-sm text-zinc-400"><span class="font-semibold">Klik untuk upload</span> atau
                            drag and drop</p>
                        <p class="text-xs text-zinc-500">PDF atau DOCX (Maks. 10MB)</p>
                    </div>
                    <input id="file" type="file" name="file" accept=".pdf,.docx" required class="hidden" />
                </label>
            </div>
            <div id="file-name" class="text-sm text-zinc-400 mt-2"></div>
            @error('file')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-zinc-800">
                Upload Proposal
            </button>
        </div>
    </form>

    <script>
        // Display file name when selected
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'No file selected';
            document.getElementById('file-name').textContent = 'File selected: ' + fileName;
        });
    </script>



@endsection
