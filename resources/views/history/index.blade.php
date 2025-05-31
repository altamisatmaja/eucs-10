@extends('layouts.apps')

@section('content')
    <div class="pt-6 px-4 w-full">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Riwayat Upload</h1>

        @if ($records->isEmpty())
            <div class="bg-white rounded-lg  p-6">
                <p class="text-gray-600">Anda belum memiliki riwayat upload.</p>
            </div>
        @else
            <div class="bg-white overflow-hidden mb-8 rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full rounded border">
                        <thead class="bg-green-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Nama File</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Tanggal Upload</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Jumlah Data</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($records as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $record->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $record->created_at->format('d M Y H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $record->values->count() }} data</div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
