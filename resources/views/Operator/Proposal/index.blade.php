@extends('Layout.Admin')
@section('title', 'Proposal - All')
@section('content-title', 'Proposal - All')
@section('content')

    <table class="w-full bg-zinc-800 text-white border border-gray-700 rounded-md">
        <thead class="bg-gray-900">
            <tr>
                <th class="p-3 text-left">#</th>
                <th class="p-3 text-left">Judul Proposal</th>
                <th class="p-3 text-left">Tim</th>
                <th class="p-3 text-left">PKM</th>
                <th class="p-3 text-left">Tanggal Upload</th>
                <th class="p-3 text-left">Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposals as $index => $proposal)
                <tr class="border-t border-gray-700">
                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3">{{ $proposal->judul_proposal }}</td>
                    <td class="p-3">{{ $proposal->tim->nama_tim ?? 'Tidak Ada Tim' }}</td>
                    <td class="p-3">
                    </td>
                    <td class="p-3">
                        {{ $proposal->created_at }}
                    </td>
                    <td class="p-3">
                        <a href="{{ route('operator.proposal.detail', ['nama_tim' => $proposal->tim->nama_tim, 'proposal_id' => $proposal->id]) }}"
                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Detail</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection
