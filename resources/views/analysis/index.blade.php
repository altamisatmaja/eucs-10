@extends('layouts.apps')

@section('content')
    <div class="pt-6 px-4 w-full">
        @if (!$dataExists)
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="text-red-500 font-medium mb-2">Error</div>
                <p>{{ $errorMessage ?? 'Terjadi kesalahan dalam memproses data' }}</p>
            </div>
        @else
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Hasil Analisis EUCS</h1>

            <!-- Summary Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Ringkasan Hasil</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($results['statistics'] as $dimension => $stats)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h3 class="font-medium text-lg text-green-700">{{ $dimension }}</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600">Rata-rata:
                                    <span class="font-medium">{{ $results['achievement'][$dimension]['mean'] }}</span>
                                </p>
                                <p class="text-sm text-gray-600">Tingkat Pencapaian:
                                    <span
                                        class="font-medium">{{ $results['achievement'][$dimension]['achievement_percentage'] }}%</span>
                                </p>
                                <p class="text-sm text-gray-600">Interpretasi:
                                    <span
                                        class="font-medium">{{ $results['achievement'][$dimension]['interpretation'] }}</span>
                                </p>
                                <p class="text-sm text-gray-600">Tingkat Kepuasan:
                                    <span class="font-medium @getSatisfactionColorClass($results['achievement'][$dimension]['satisfaction'])">
                                        {{ $results['achievement'][$dimension]['satisfaction'] }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Detailed Statistics -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Statistik Detail</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full rounded border">
                        <thead class="bg-green-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Dimensi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Rata-rata</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Pencapaian</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Interpretasi</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Kepuasan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Min
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Max
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Std
                                    Dev</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($results['statistics'] as $dimension => $stats)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $dimension }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $results['achievement'][$dimension]['mean'] }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $results['achievement'][$dimension]['achievement_percentage'] }}%
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $results['achievement'][$dimension]['interpretation'] }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <span class="@getSatisfactionColorClass($results['achievement'][$dimension]['satisfaction'])">
                                            {{ $results['achievement'][$dimension]['satisfaction'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['min'] }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stats['max'] }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ round($stats['std_dev'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Interpretation Guide -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Panduan Interpretasi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-medium text-lg mb-2">Tingkat Pencapaian</h3>
                        <ul class="space-y-2">
                            @foreach ([['min' => 75.01, 'max' => 100, 'label' => 'Sangat Tinggi'], ['min' => 58.34, 'max' => 75.01, 'label' => 'Tinggi'], ['min' => 41.66, 'max' => 58.34, 'label' => 'Kurang'], ['min' => 24.99, 'max' => 41.66, 'label' => 'Rendah'], ['min' => 0, 'max' => 24.99, 'label' => 'Sangat Rendah']] as $level)
                                <li class="text-sm">
                                    <span class="font-medium">{{ $level['label'] }}:</span>
                                    {{ $level['min'] }}% - {{ $level['max'] }}%
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-medium text-lg mb-2">Tingkat Kepuasan</h3>
                        <ul class="space-y-2">
                            @foreach ([['min' => 4.1, 'max' => 5.0, 'label' => 'Sangat Puas'], ['min' => 3.1, 'max' => 4.0, 'label' => 'Puas'], ['min' => 2.1, 'max' => 3.0, 'label' => 'Cukup Puas'], ['min' => 1.1, 'max' => 2.0, 'label' => 'Kurang Puas'], ['min' => 0.0, 'max' => 1.0, 'label' => 'Sangat Tidak Puas']] as $level)
                                <li class="text-sm">
                                    <span class="font-medium">{{ $level['label'] }}:</span>
                                    Skor {{ $level['min'] }} - {{ $level['max'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
