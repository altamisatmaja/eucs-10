@extends('layouts.app')

@section('title', 'Hasil')

@section('content')
    <div class="bg-white  rounded overflow-hidden mb-8  max-w-7xl mx-auto mt-14">
        @if (!request()->has('references'))
            <div class="flex flex-col">
                <div class="rounded justify-center items-center">
                    <div class="flex-grow container mx-auto px-4 py-6 border border-gray-300 rounded justify-center items-center">
                        <h1 class="text-2xl font-bold text-gray-800 mb-6">Selamat datang, {{ $user->name ?? 'Tamu' }}</h1>
                        <p>Harap upload file terlebih dahulu ya!</p>
                    </div>
                </div>
            </div>
        @elseif (request()->has('references') && empty($results))
            <div class="alert alert-warning">
                Tidak ditemukan data dengan reference ID tersebut.
            </div>
        @else
            
            <div class="card mb-4">
                <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 rounded border">
                            <thead class="bg-green-600">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">No</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Variabel</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Min</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Max</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Mean</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Var</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Standar Deviasi</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Nilai Capaian</th>
                                    <th class="px-4 py-3 text-left text-xs text-white font-bold text-gray-600 uppercase tracking-wider">Kategori</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @php
                                    $combinedData = [];
                                    foreach ($results['X'] as $var => $stats) {
                                        $combinedData[$var] = [
                                            'stats' => $stats,
                                            'achievement' => $results['achievement']['X'][$var] ?? null
                                        ];
                                    }
                                    foreach ($results['Y'] as $var => $stats) {
                                        $combinedData[$var] = [
                                            'stats' => $stats,
                                            'achievement' => $results['achievement']['Y'][$var] ?? null
                                        ];
                                    }
                                    $index = 1; 
                                @endphp

                                @foreach ($combinedData as $variable => $data)
                                    @php
                                        $stats = $data['stats'];
                                        $achievement = $data['achievement'];
                                        $interpretationClass = '';
                                        $interpretationText = '';
                                        
                                        if ($achievement) {
                                            if ($achievement['achievement_percentage'] >= 90) {
                                                $interpretationClass = 'bg-green-100 text-green-800';
                                                $interpretationText = 'Sangat Baik';
                                            } elseif ($achievement['achievement_percentage'] >= 80) {
                                                $interpretationClass = 'bg-blue-100 text-blue-800';
                                                $interpretationText = 'Baik';
                                            } elseif ($achievement['achievement_percentage'] >= 70) {
                                                $interpretationClass = 'bg-yellow-100 text-yellow-800';
                                                $interpretationText = 'Cukup';
                                            } elseif ($achievement['achievement_percentage'] >= 60) {
                                                $interpretationClass = 'bg-yellow-100 text-yellow-800';
                                                $interpretationText = 'Kurang';
                                            } else {
                                                $interpretationClass = 'bg-red-100 text-red-800';
                                                $interpretationText = 'Sangat Kurang';
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $index }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ strtoupper($variable) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $stats['min'] }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ $stats['max'] }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ number_format($stats['mean'], 2) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ number_format($stats['variance'], 2) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap">{{ number_format($stats['std_dev'], 2) }}</td>
                                        <td class="px-4 py-3 whitespace-nowrap font-semibold">
                                            @if($achievement)
                                                {{ number_format($achievement['achievement_percentage'], 1) }}%
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @if($achievement)
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $interpretationClass }}">
                                                    {{ $interpretationText }}
                                                </span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @php $index++; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection