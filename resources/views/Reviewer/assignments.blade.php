@extends('Layout.Admin')
@section('title', 'Reviewer Assignments')
@section('content-title', 'Reviewer Assignments')
@section('content')

    @if (session('success'))
        <div class="bg-green-800 text-white p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    {{-- Form to Assign Reviewer --}}
    <form method="POST" action="{{ route('reviewer.assign') }}" class="mb-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <select name="reviewer_id"
                    class="w-full bg-black text-white border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">Select Reviewer</option>
                    @foreach ($reviewers as $reviewer)
                        <option value="{{ $reviewer->id }}">{{ $reviewer->nama_lengkap }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="tim_id"
                    class="w-full bg-black text-white border border-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
                    <option value="">Select Team</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->nama_tim }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Assign
                </button>
            </div>
        </div>
    </form>

    {{-- Assigned Reviewers Table --}}
    <h3 class="text-xl font-semibold mb-3">Assigned Reviewers</h3>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-black">
                    <th class="border border-gray-700 px-4 py-2 text-left">Reviewer Name</th>
                    <th class="border border-gray-700 px-4 py-2 text-left">Assigned Teams</th>
                    <th class="border border-gray-700 px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reviewers as $reviewer)
                    <tr class="bg-bg-black">
                        <td class="border border-gray-700 px-4 py-2">{{ $reviewer->nama_lengkap }}</td>
                        <td class="border border-gray-700 px-4 py-2">
                            <ul class="list-disc pl-5">
                                @foreach ($reviewer->teamsReviewed as $team)
                                    <li>{{ $team->nama_tim }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border border-gray-700 px-4 py-2">
                            @foreach ($reviewer->teamsReviewed as $team)
                                <form method="POST" action="{{ route('reviewer.remove') }}" class="inline-block mb-2">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="reviewer_id" value="{{ $reviewer->id }}">
                                    <input type="hidden" name="tim_id" value="{{ $team->id }}">
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white text-sm py-1 px-2 rounded focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Remove {{ $team->nama_tim }}
                                    </button>
                                </form>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



@endsection
