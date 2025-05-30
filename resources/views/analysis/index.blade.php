@extends('layouts.app')

@section('title', 'Hasil Analisis EUCS')

@section('content')
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8 max-w-7xl mx-auto mt-8 p-6">
        @if (!request()->has('references'))
            <div class="text-center p-8 bg-gray-50 rounded-lg border border-gray-200">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Selamat datang, {{ $user->name ?? 'Tamu' }}</h1>
                <p class="text-gray-600">Silakan upload file terlebih dahulu untuk melihat hasil analisis EUCS.</p>
            </div>
        @elseif(isset($errorMessage))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            {{ $errorMessage }}

                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Hasil Analisis EUCS</h2>
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">Reference:
                        {{ $reference }}</span>
                </div>

                <div class="overflow-x-auto shadow-md rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Dimensi EUCS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Min
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Max
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Mean
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Varian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Std
                                    Dev</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Capaian</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Kategori</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($results['statistics'] as $dimension => $stats)
                                @php
                                    $achievement = $results['achievement'][$dimension] ?? null;
                                    $interpretation = $achievement['interpretation'] ?? '';

                                    $colorClasses = [
                                        'Sangat Tinggi' => 'bg-green-100 text-green-800',
                                        'Tinggi' => 'bg-blue-100 text-blue-800',
                                        'Kurang' => 'bg-yellow-100 text-yellow-800',
                                        'Rendah' => 'bg-orange-100 text-orange-800',
                                        'Sangat Rendah' => 'bg-red-100 text-red-800',
                                    ];
                                    $interpretationClass = $colorClasses[$interpretation] ?? '';
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $dimension }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['min'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['max'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($stats['mean'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($stats['variance'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($stats['std_dev'], 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                        {{ $achievement ? number_format($achievement['achievement_percentage'], 1) . '%' : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($achievement)
                                            <span
                                                class="px-2.5 py-0.5 text-xs font-semibold rounded-full {{ $interpretationClass }}">
                                                {{ $interpretation }}
                                            </span>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <h3 class="font-medium text-gray-800 mb-2">Kategori Capaian:</h3>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-2">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-sm">> 75% (Sangat Tinggi)</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                        <span class="text-sm">58.34% - 75% (Tinggi)</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                        <span class="text-sm">41.66% - 58.33% (Kurang)</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                        <span class="text-sm">25% - 41.65% (Rendah)</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                        <span class="text-sm">
                            < 25% (Sangat Rendah)</span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
