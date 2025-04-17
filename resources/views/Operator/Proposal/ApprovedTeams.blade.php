@extends('Layout.Admin')
@section('title', 'Approved Teams')
@section('content-title', 'Approved Teams')
@section('content')

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-5" role="alert">
            <p class="">{{ session('error') }}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-5" role="alert">
            <p class="">{{ session('success') }}</p>
        </div>
    @endif

    <table id="teamsTable" class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama Tim</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama Ketua | NIM</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Skema PKM</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Judul Proposal</th>
                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach ($approved_teams as $index => $team)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $approved_teams->firstItem() + $index }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $team->tim->nama_tim ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $team->tim->ketua->nama_lengkap }} | {{ $team->tim->ketua->nim }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">{{ $team->tim->jenisPkm->nama_pkm }}</td>
                    <td class="px-4 py-2 text-sm text-gray-800">
                        <a target="_blank" href="{{ route('operator.proposal.detail', ['nama_tim' => $team->tim->nama_tim, 'proposal_id' => $team->tim->proposal->id]) }}"
                            class="text-blue-600 hover:underline">{{ $team->tim->proposal->judul_proposal }}</a>
                    </td>
                    {{-- <td class="px-4 py-2 text-sm text-gray-800">{{ $team->created_at}}</td> --}}
                    <td class="px-4 py-2 text-sm text-gray-800 flex flex-col gap-2">
                        @if (empty($team->tim->username))
                            @if (Auth::user()->role_id === 1)
                                <a onclick="(openModal('insertdatalolos-{{ $team->tim->id }}'))"
                                    class="inline-flex items-center justify-center px-3 py-1.5 bg-green-600 text-black text-xs font-medium rounded-md hover:bg-green-700 hover:text-white transition-colors duration-150 ease-in-out">
                                    Izinkan
                                </a>
                            @endif
                            <a href="{{ route('reviewTim.delete', $team->tim->id) }}"
                                onclick="return confirm('Yakin ingin menghapus tim ini?')"
                                class="inline-flex items-center justify-center px-3 py-1.5 text-black text-xs font-medium rounded-md hover:bg-red-700 hover:text-white transition-colors duration-150 ease-in-out">
                                Hapus
                            </a>
                        @else
                            <a
                                class="inline-flex items-center justify-center text-center px-3 py-1.5 bg-zinc-300 text-xs font-medium rounded-md disabled transition-colors duration-150 ease-in-out">
                                Sudah Lolos
                            </a>
                        @endif
                    </td>
                </tr>

                <x-modal id="insertdatalolos-{{ $team->tim->id }}" title="Berikan Akses Login Tim">
                    <div class="p-4">
                        <!-- Header and Description -->
                        <div class="mb-6 text-center">
                            <p class="text-gray-700 mb-3">Masukkan kredensial login untuk tim:</p>
                            <div class="bg-blue-50 rounded-lg p-3 mb-4">
                                <p class="font-bold text-blue-800">{{ $team->tim->nama_tim }}</p>
                            </div>
                        </div>

                        <!-- Form Section -->
                        <form action="{{ route('reviewTim.addCredentials', parameters: $team->tim->id) }}" method="post"
                            class="space-y-4">
                            @csrf

                            <!-- Username/Email Field -->
                            <div class="space-y-1">
                                <label for="username-{{ $team->id }}"
                                    class="block text-sm font-medium text-gray-700">Username</label>
                                <input type="text" id="username-{{ $team->id }}" name="username"
                                    placeholder="Masukkan username"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <!-- Password Field -->
                            <div class="space-y-1">
                                <label for="password-{{ $team->id }}"
                                    class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="text" id="password-{{ $team->id }}" name="password"
                                    placeholder="Masukkan password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <!-- Password Show/Hide Toggle -->
                            <div>
                                <label class="inline-flex items-center cursor-pointer text-sm text-gray-600">
                                    <input type="checkbox" onclick="togglePasswordVisibility({{ $team->id }})"
                                        class="mr-2">
                                    Tampilkan password
                                </label>
                            </div>

                            <!-- Confirmation -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <label
                                    class="flex items-center text-red-600 font-medium cursor-pointer hover:bg-red-50 p-2 rounded-md transition-colors">
                                    <input type="checkbox" id="confirm-{{ $team->id }}" name="confirmation" required
                                        class="mr-3 h-5 w-5 rounded border-red-400 text-red-600 focus:ring-red-500">
                                    <span>Saya yakin memberikan data akses login kepada tim ini</span>
                                </label>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between mt-6 pt-4 border-t border-gray-200">
                                <button type="button" onclick="closeModal('insertdatalolos-{{ $team->id }}')"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-md transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-md transition-colors flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Berikan Akses
                                </button>
                            </div>
                        </form>
                    </div>

                    <script>
                        function togglePasswordVisibility(teamId) {
                            const passwordField = document.getElementById(`password-${teamId}`);
                            if (passwordField.type === "password") {
                                passwordField.type = "text";
                            } else {
                                passwordField.type = "password";
                            }
                        }

                        function closeModal(modalId) {
                            // This assumes you have a way to close the modal
                            // If you're using Alpine.js or similar, you might need to adjust this
                            const modal = document.getElementById(modalId);
                            // Handle closing logic based on your modal implementation
                        }
                    </script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const tableRows = document.querySelectorAll('#teamsTable tr');
                            const displayedNamaTim = new Set();
                            const displayedJudulProposal = new Set();

                            // Function to filter duplicate rows
                            function filterDuplicates() {
                                tableRows.forEach(function(row) {
                                    const namaTim = row.cells[1].textContent.trim();
                                    const judulProposal = row.cells[2].textContent.trim();

                                    // Check if this `nama_tim` or `judul_proposal` has been displayed already
                                    const isDuplicate = displayedNamaTim.has(namaTim) || displayedJudulProposal.has(
                                        judulProposal);

                                    if (isDuplicate) {
                                        // Hide the row if it's a duplicate
                                        row.style.display = 'none';
                                    } else {
                                        // Show the row and add `nama_tim` and `judul_proposal` to the sets
                                        row.style.display = '';
                                        displayedNamaTim.add(namaTim);
                                        displayedJudulProposal.add(judulProposal);
                                    }
                                });
                            }

                            // Call the function to filter duplicates when the page is loaded
                            filterDuplicates();
                        });
                    </script>
                </x-modal>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $approved_teams->links() }}
    </div>



@endsection
