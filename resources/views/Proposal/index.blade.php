@extends('Layout.Admin')
@section('title', 'Proposal')
@section('content-title', 'Proposal')
@section('content')

    @if ($proposals->isEmpty())
        <a href="{{ route('proposal.create') }}">Upload Proposal</a>
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if ($proposals->isEmpty())
        <div class="bg-zinc-800 rounded-xl border border-zinc-700 p-10 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-zinc-600 mb-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-zinc-400 text-lg font-medium">Belum ada proposal yang diunggah.</p>
            <a href="{{ route('proposal.create') }}"
                class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Upload Proposal
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($proposals as $item)
                <div class="bg-zinc-800 rounded-xl border border-zinc-700 overflow-hidden">
                    <!-- Accordion Header -->
                    <div class="accordion-header cursor-pointer px-6 py-4 flex items-center justify-between"
                        onclick="toggleAccordion('proposal-{{ $item->id }}')">
                        <div class="flex items-center space-x-3">
                            <!-- File type icon - change based on file extension -->
                            @php
                                $extension = pathinfo($item->file_path, PATHINFO_EXTENSION);
                                $iconClass = $extension == 'pdf' ? 'text-red-500' : 'text-blue-500';
                            @endphp

                            <div class="{{ $iconClass }} bg-zinc-700 p-2 rounded-lg">
                                @if ($extension == 'pdf')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                @endif
                            </div>

                            <div>
                                <h3 class="font-medium text-white">{{ $item->judul_proposal }}</h3>
                                <p class="text-sm text-zinc-400">Diunggah: {{ $item->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <!-- Status Badge -->
                            @php
                                $statusClass = '';
                                $statusText = '';

                                switch ($item->status ?? 'pending') {
                                    case 'approved':
                                        $statusClass = 'bg-green-100 text-green-800';
                                        $statusText = 'Disetujui';
                                        break;
                                    case 'rejected':
                                        $statusClass = 'bg-red-100 text-red-800';
                                        $statusText = 'Ditolak';
                                        break;
                                    case 'reviewed':
                                        $statusClass = 'bg-blue-100 text-blue-800';
                                        $statusText = 'Direview';
                                        break;
                                    default:
                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                        $statusText = 'Menunggu';
                                }
                            @endphp

                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                {{ $statusText }}
                            </span>

                            <!-- Chevron icon -->
                            <svg id="chevron-{{ $item->id }}" xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-zinc-400 transform transition-transform duration-200" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <!-- Accordion Content -->
                    <div id="proposal-{{ $item->id }}"
                        class="accordion-content hidden px-6 pb-5 border-t border-zinc-700">
                        <div class="pt-4">
                            <!-- Abstract Preview -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-zinc-400 mb-2">Abstract:</h4>
                                <p class="text-zinc-300 bg-zinc-700/50 p-3 rounded-md">
                                    {{ Str::limit($item->abstract, 200) }}
                                    @if (strlen($item->abstract) > 200)
                                        <a href="#" class="text-blue-400 hover:text-blue-300 ml-1">Baca
                                            selengkapnya</a>
                                    @endif
                                </p>
                            </div>

                            <!-- Timeline -->
                            <h4 class="text-sm font-medium text-zinc-400 mb-3">Timeline:</h4>
                            <div class="relative border-l-2 border-zinc-600 pl-5 pb-2 ml-2">
                                <!-- Timeline items - replace with actual data from your model -->
                                <div class="mb-6 relative">
                                    <div
                                        class="absolute -left-[27px] mt-1.5 w-4 h-4 rounded-full bg-blue-500 border-4 border-zinc-800">
                                    </div>
                                    <div class="bg-zinc-700/50 p-3 rounded-md">
                                        <h5 class="text-white font-medium">Proposal Diunggah</h5>
                                        <p class="text-zinc-400 text-sm">{{ $item->created_at->format('d M Y, H:i') }}</p>
                                        <p class="text-zinc-300 mt-1">Proposal telah berhasil diunggah ke sistem.</p>
                                    </div>
                                </div>

                                @if (isset($item->reviewed_at))
                                    <div class="mb-6 relative">
                                        <div
                                            class="absolute -left-[27px] mt-1.5 w-4 h-4 rounded-full bg-yellow-500 border-4 border-zinc-800">
                                        </div>
                                        <div class="bg-zinc-700/50 p-3 rounded-md">
                                            <h5 class="text-white font-medium">Sedang Direview</h5>
                                            <p class="text-zinc-400 text-sm">
                                                {{ \Carbon\Carbon::parse($item->reviewed_at)->format('d M Y, H:i') }}</p>
                                            <p class="text-zinc-300 mt-1">Proposal sedang dalam proses review oleh tim
                                                penilai.</p>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($item->feedback_at))
                                    <div class="mb-6 relative">
                                        <div
                                            class="absolute -left-[27px] mt-1.5 w-4 h-4 rounded-full bg-purple-500 border-4 border-zinc-800">
                                        </div>
                                        <div class="bg-zinc-700/50 p-3 rounded-md">
                                            <h5 class="text-white font-medium">Feedback Diberikan</h5>
                                            <p class="text-zinc-400 text-sm">
                                                {{ \Carbon\Carbon::parse($item->feedback_at)->format('d M Y, H:i') }}</p>
                                            <p class="text-zinc-300 mt-1">
                                                {{ $item->feedback ?? 'Tidak ada feedback yang diberikan.' }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($item->approved_at))
                                    <div class="relative">
                                        <div
                                            class="absolute -left-[27px] mt-1.5 w-4 h-4 rounded-full bg-green-500 border-4 border-zinc-800">
                                        </div>
                                        <div class="bg-zinc-700/50 p-3 rounded-md">
                                            <h5 class="text-white font-medium">Proposal Disetujui</h5>
                                            <p class="text-zinc-400 text-sm">
                                                {{ \Carbon\Carbon::parse($item->approved_at)->format('d M Y, H:i') }}</p>
                                            <p class="text-zinc-300 mt-1">Selamat! Proposal Anda telah disetujui.</p>
                                        </div>
                                    </div>
                                @elseif(isset($item->rejected_at))
                                    <div class="relative">
                                        <div
                                            class="absolute -left-[27px] mt-1.5 w-4 h-4 rounded-full bg-red-500 border-4 border-zinc-800">
                                        </div>
                                        <div class="bg-zinc-700/50 p-3 rounded-md">
                                            <h5 class="text-white font-medium">Proposal Ditolak</h5>
                                            <p class="text-zinc-400 text-sm">
                                                {{ \Carbon\Carbon::parse($item->rejected_at)->format('d M Y, H:i') }}</p>
                                            <p class="text-zinc-300 mt-1">
                                                {{ $item->rejection_reason ?? 'Tidak ada alasan penolakan yang diberikan.' }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end space-x-3 mt-6">
                                <a href="{{ route('proposal.show', $item->id )}}"
                                    class="px-3 py-1.5 bg-zinc-700 hover:bg-zinc-600 text-white rounded-md transition text-sm inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </a>

                                <button onclick="confirmDelete('{{ $item->id }}')"
                                    class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded-md transition text-sm inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Delete Confirmation Modal (Hidden by default) -->
        <div id="deleteModal"
            class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden flex items-center justify-center p-4">
            <div class="bg-zinc-800 rounded-xl shadow-xl border border-zinc-700 w-full max-w-md mx-auto z-50">
                <div class="px-6 py-4 border-b border-zinc-700">
                    <h3 class="text-lg font-semibold text-white">Konfirmasi Hapus</h3>
                </div>
                <div class="px-6 py-4">
                    <p class="text-zinc-300">Apakah Anda yakin ingin menghapus proposal ini?</p>
                </div>
                <div class="px-6 py-4 border-t border-zinc-700 flex justify-end space-x-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-white rounded-md transition">
                        Batal
                    </button>
                    <form id="deleteForm" action="{{ route('proposal.delete', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        // Toggle accordion
        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const chevron = document.getElementById('chevron-' + id.split('-')[1]);

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                chevron.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                chevron.classList.remove('rotate-180');
            }
        }

        // Delete confirmation
        function confirmDelete(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');

            form.action = "/" + id;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('hidden');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeDeleteModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>


@endsection
