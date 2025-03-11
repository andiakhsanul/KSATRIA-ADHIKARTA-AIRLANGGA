@extends('Layout.Admin')
@section('content')
    <h2 class="text-xl font-bold text-gray-800 mb-6">Assign Reviewer to Team</h2>

    <div class="mx-auto p-6 bg-white shadow-md rounded-md">
        <!-- Success & Error Messages -->
        @if (session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger p-4 mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('reviewer.assign.save') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Select Reviewer -->
            <div>
                <label for="reviewer" class="block text-sm font-medium text-gray-700">Select Reviewer:</label>
                <select name="reviewer_id" id="reviewer"
                    class="w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    <option value="" disabled selected>Choose a reviewer</option>
                    @foreach ($reviewers as $reviewer)
                        <option value="{{ $reviewer->id }}">{{ $reviewer->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search Team:</label>
                    <input type="text" id="search" placeholder="Type team name..."
                        class="w-full p-2 border rounded-md" oninput="filterTeams()">
                </div>
                <div>
                    <label for="pkm_filter" class="block text-sm font-medium text-gray-700">Filter by PKM Type:</label>
                    <select id="pkm_filter" class="w-full p-2 border rounded-md" onchange="filterTeams()">
                        <option value="">All Types</option>
                        @foreach ($pkmTypes as $pkmType)
                            <option value="{{ $pkmType->nama_pkm }}">{{ $pkmType->nama_pkm }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Select Multiple Teams -->
            <div>
                <label for="team" class="block text-sm font-medium text-gray-700">Select Teams (Max 2 Reviewers per
                    Team):</label>
                <select name="tim_ids[]" id="team" multiple
                    class="w-full h-52 mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" data-name="{{ strtolower($team->nama_tim) }}"
                            data-pkm="{{ strtolower($team->jenisPkm->nama_pkm) }}"
                            data-reviewer-count="{{ count($team->reviewers) }}"
                            {{ count($team->reviewers) >= 2 ? 'disabled' : '' }}>
                            {{ $team->nama_tim }} - {{ $team->jenisPkm->nama_pkm }}
                            ({{ count($team->reviewers) }}/2 Reviewers)
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">Hold Ctrl (Windows) / Cmd (Mac) to select multiple teams.</p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Assign Reviewer
                </button>
            </div>
        </form>

        <!-- Existing Assignments -->
        <h2 class="text-lg font-semibold mt-8">Reviewer Assignments</h2>
        <div class="bg-gray-50 p-4 rounded-md mt-4">
            @foreach ($reviewers as $reviewer)
                <div class="mb-4">
                    <h3 class="font-semibold text-gray-800">{{ $reviewer->nama_lengkap }}</h3>
                    <ul class="list-disc pl-5 text-sm text-gray-600">
                        @forelse ($reviewer->teamsReviewed as $team)
                            <li class="flex justify-between items-center">
                                <span>{{ $team->nama_tim }} ({{ count($team->reviewers) }}/2 Reviewers)</span>
                                <form
                                    action="{{ route('reviewer.assignment.delete', ['reviewer_id' => $reviewer->id, 'team_id' => $team->id]) }}"
                                    method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Remove</button>
                                </form>
                            </li>
                        @empty
                            <li class="text-gray-400">No teams assigned</li>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <!-- JavaScript for Filtering -->
    <script>
        function filterTeams() {
            let searchValue = document.getElementById('search').value.toLowerCase().trim();
            let pkmValue = document.getElementById('pkm_filter').value.toLowerCase().trim();
            let teams = document.querySelectorAll("#team option");

            teams.forEach(team => {
                let name = (team.getAttribute("data-name") || "").toLowerCase().trim();
                let pkm = (team.getAttribute("data-pkm") || "").toLowerCase().trim();
                let reviewers = parseInt(team.getAttribute("data-reviewer-count"), 10);

                let nameMatch = name.includes(searchValue) || searchValue === "";
                let pkmMatch = pkmValue === "" || pkm.includes(pkmValue);

                team.style.display = nameMatch && pkmMatch && reviewers < 2 ? "block" : "none";
            });
        }
    </script>

@endsection
