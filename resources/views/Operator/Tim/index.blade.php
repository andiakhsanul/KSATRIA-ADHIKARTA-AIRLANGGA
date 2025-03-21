@extends('Layout.Admin')
@section('title', 'Manage Tim')
@section('content-title', 'Manage Tim')
@section('content')

    <div class="mb-8 flex flex-col sm:flex-row gap-5 sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('manage.tim.index') }}" class="w-full sm:w-auto">
            <div class="relative flex items-center">
                <input type="text" placeholder="Search users..." name="search" value="{{ request('search') }}"
                    class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-72 text-gray-700 bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-gray-500 absolute left-3 top-1/2 transform -translate-y-1/2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <button type="submit"
                    class="ml-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 shadow-sm">
                    Search
                </button>

                <!-- Reset Button (Only visible when search is active) -->
                @if (request('search') || request('role_id'))
                    <a href="{{ route('manage.tim.index') }}"
                        class="ml-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-lg transition-colors duration-200 shadow-sm">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>  

    <table class="w-full border-collapse rounded-lg overflow-hidden shadow-md my-4">
        <thead>
            <tr class="bg-blue-600 text-white">
                <th class="px-4 py-3 text-left font-semibold">#</th>
                <th class="px-4 py-3 text-left font-semibold">Nama Tim</th>
                <th class="px-4 py-3 text-left font-semibold">Ketua</th>
                <th class="px-4 py-3 text-left font-semibold">NIM Ketua</th>
                <th class="px-4 py-3 text-left font-semibold">Anggota</th>
                <th class="px-4 py-3 text-left font-semibold">Jenis PKM</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($tim as $index => $t)
                <tr class="border-b border-gray-200 hover:bg-blue-50 transition duration-150">
                    <td class="px-4 py-3 border-r border-gray-100">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 border-r border-gray-100 font-medium">{{ $t->nama_tim }}</td>
                    <td class="px-4 py-3 border-r border-gray-100">{{ $t->ketua->nama_lengkap }}</td>
                    <td class="px-4 py-3 border-r border-gray-100">{{ $t->ketua->nim }}</td>
                    <td class="px-4 py-3 border-r border-gray-100">
                        @foreach ($t->anggota->reject(fn($item) => $item->id == $t->ketua_id) as $item)
                            <div class="py-1">
                                <span class="inline-flex items-center">
                                    <span class="w-2 h-2 inline-block bg-blue-600 rounded-full mr-2"></span>
                                    {{ $item->nama_lengkap }} <br> <span
                                        class="text-sm text-gray-400">{{ $item->nim }}</span>
                                </span>
                            </div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-2">
                            <form action="{{ route('manage.tim.delete', $t->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition duration-150 text-sm inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Tim
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tim->links() }}


@endsection
