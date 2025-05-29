<footer class="bg-gray-50" aria-labelledby="footer-heading">
    <h2 id="footer-heading" class="sr-only">Footer</h2>
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="xl:grid xl:grid-cols-3 xl:gap-8">
            <div class="space-y-6">
                <img class="h-16" src="https://i.pinimg.com/736x/ca/33/f0/ca33f0957681c01374cc5e70f76bc97d.jpg" alt="Company logo">
                <p class="text-sm text-gray-600 leading-relaxed">
                    Dapatkan hasil perhitungan secara instan melalui data berformat csv yang Anda upload
                </p>
            </div>
            <div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <ul class="mt-4 space-y-2">
                            <li>
                                <a href="{{ route('dashboard', ['references' => session('existingRecordId')]) }}" 
                                   class="text-sm leading-6 text-gray-600 hover:text-green-600 transition-colors">
                                    Beranda
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-10 md:mt-0">
                        <ul class="mt-4 space-y-2">
                            <li>
                                @if (!request()->has('references'))
                                    <a href="{{ route('data.index', ['type' => 'x', 'references' => session('existingRecordId')]) }}"
                                       class="text-sm leading-6 text-gray-600 hover:text-green-600 transition-colors">
                                        Data X
                                    </a>
                                @else
                                    <a href="{{ route('data.index', ['type' => 'x', 'references' => request()->query('references')]) }}"
                                       class="text-sm leading-6 text-gray-600 hover:text-green-600 transition-colors">
                                        Data X
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="md:grid md:grid-cols-2 md:gap-8">
                    <div>
                        <ul class="mt-4 space-y-2">
                            <li>
                                @if (!request()->has('references'))
                                    <a href="{{ route('data.index', ['type' => 'y', 'references' => session('existingRecordId')]) }}"
                                       class="text-sm leading-6 text-gray-600 hover:text-green-600 transition-colors">
                                        Data Y
                                    </a>
                                @else
                                    <a href="{{ route('data.index', ['type' => 'y', 'references' => request()->query('references')]) }}"
                                       class="text-sm leading-6 text-gray-600 hover:text-green-600 transition-colors">
                                        Data Y
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="mt-10 md:mt-0">
                        <ul class="mt-4 space-y-2">
                            <li>
                                @if (!request()->has('references'))
                                    <a href="{{ route('analysis', ['references' => session('existingRecordId')]) }}"
                                       class="text-sm leading-6 text-gray-600 hover:text-green-600 transition-colors">
                                        Hasil
                                    </a>
                                @else
                                    <a href="{{ route('analysis', ['references' => request()->query('references')]) }}"
                                       class="text-sm leading-6 text-gray-600 hover:text-green-600 transition-colors">
                                        Hasil
                                    </a>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-16 border-t border-gray-200 pt-8">
            <p class="text-xs leading-5 text-gray-500">&copy; 2025 Kalkulator EUCS. All rights reserved.</p>
        </div>
    </div>
</footer>