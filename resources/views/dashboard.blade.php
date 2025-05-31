@extends('layouts.apps')

@section('title', 'Beranda')

@section('content')
    <main class="p-4 sm:p-6 xl:p-8">
        <div class="">
            <div class="w-full">
                <div class="bg-white  rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <div class="">
                            <p class="text-lg font-medium leading-8 text-green-600/95">Selamat datang di Kalkulator EUCS,
                                {{ auth()->user()->name ?? 'Tamu' }}</p>
                            <h1 class="mt-3 text-[3.5rem] font-bold leading-[4rem] tracking-tight text-black">
                                Mulai coba Kalkulator ECUS secara online</h1>
                            <p class="mt-3 text-lg leading-relaxed text-slate-400">Dapatkan hasil perhitungan secara
                                instan melalui data berformat csv yang Anda upload!</p>
                        </div>
                    </div>
                </div>
                <div classname="bg-white flex flex-col items-stretch ">
                    <section class="flex  bg-white rounded-lg ">
                        <div class="">
                            <div class="flex gap-4">
                                @auth
                                    @if (!request()->has('references'))
                                        <div class="text-center mb-2">
                                            <button id="openUploadModal"
                                                class="bg-green-700 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                    </path>
                                                </svg>
                                                Upload Data
                                            </button>
                                        </div>
                                    @else
                                        <div class="text-center mb-2">
                                            <a href="{{ route('dashboard.clear') }}">
                                                <button
                                                    class="bg-green-700 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    Bersihkan
                                                </button>
                                            </a>
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center mb-2">
                                        <a href="{{ route('login') }}"
                                            class="bg-green-700 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-md inline-flex items-center">
                                            Masuk
                                        </a>
                                    </div>
                                @endauth

                            </div>
                        </div>
                    </section>
                </div>

                @auth
                    @if (request()->has('references'))
                        <!-- Show records and tables only if they exist (when reference parameter exists) -->
                        @foreach ($recordIds as $recordId)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8   mx-auto">
                                <h1 class="mt-3 text-[1.5rem] font-bold leading-[4rem] tracking-tight text-black">
                                    Data yang Anda upload 👇</h1>
                                <div class="overflow-x-auto rounded border">
                                    <table class="min-w-full divide-y divide-gray-200 ">
                                        <thead class="bg-green-700">
                                            <tr>
                                                <th scope="col"
                                                    class="font-bold px-2 py-3 text-left text-xs text-white uppercase tracking-wider">
                                                    No
                                                </th>
                                                @if (isset($formattedData[$recordId]))
                                                    @php
                                                        // Get all variables without type filtering
                                                        $variables = array_keys($formattedData[$recordId]);
                                                        sort($variables);

                                                        // Format variable names for headers
                                                        $displayVariables = array_map(function ($var) {
                                                            if (preg_match('/^([xy])(\d)(\d)$/', $var, $matches)) {
                                                                $prefix = strtoupper($matches[1]);
                                                                $mainNum = $matches[2];
                                                                $subNum = $matches[3];
                                                                return "{$prefix}{$mainNum}.{$subNum}";
                                                            }
                                                            return $var;
                                                        }, $variables);
                                                    @endphp

                                                    @foreach ($displayVariables as $header)
                                                        <th scope="col"
                                                            class="font-bold px-2 py-3 text-left text-xs text-white uppercase tracking-wider">
                                                            {{ $header }}
                                                        </th>
                                                    @endforeach
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @if (isset($formattedData[$recordId]))
                                                @php
                                                    $firstVar = $variables[0] ?? null;
                                                    $respondentCount = $firstVar
                                                        ? count($formattedData[$recordId][$firstVar])
                                                        : 0;
                                                @endphp

                                                @for ($i = 0; $i < $respondentCount; $i++)
                                                    <tr
                                                        class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100">
                                                        <td
                                                            class="px-2 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            {{ $i + 1 }}
                                                        </td>
                                                        @foreach ($variables as $var)
                                                            <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                {{ $formattedData[$recordId][$var][$i] ?? '' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endfor
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endauth
            </div>
        </div>
    </main>
    
    <!-- Upload Modal - Using conditional rendering instead of hidden -->
    @if(false) <!-- This will prevent the modal from rendering initially -->
    <div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-black bg-opacity-50"></div>
        <div class="bg-white rounded-lg shadow-xl sm:max-w-lg sm:w-full m-4 relative z-10">
            <form action="{{ route('data.upload') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <div class="mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Upload Data</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Pilih File
                            Excel (.xls, .xlsx, csv)</label>
                        <input type="file" id="file" name="file" required
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Tutup
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endsection

@section('scripts')
    <script>
        // Modal functions - now we'll create the modal dynamically
        function openModal() {
            const modalHtml = `
                <div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal()"></div>
                    <div class="bg-white rounded-lg shadow-xl sm:max-w-lg sm:w-full m-4 relative z-10">
                        <form action="{{ route('data.upload') }}" method="POST" enctype="multipart/form-data" class="p-6">
                            @csrf
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Upload Data</h3>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Pilih File Excel (.xls, .xlsx, csv)</label>
                                    <input type="file" id="file" name="file" required
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="closeModal()"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Tutup
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            const modal = document.getElementById('uploadModal');
            if (modal) {
                modal.remove();
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Open modal
            const uploadBtn = document.getElementById('openUploadModal');
            if (uploadBtn) {
                uploadBtn.addEventListener('click', openModal);
            }

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>
@endsection