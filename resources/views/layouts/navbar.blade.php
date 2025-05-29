<nav class="bg-green-600 border-t-2 border-gray-200 rounded-lg sticky top-0 mx-auto max-w-7xl shadow-md z-50">
    <div class="container mx-auto px-4">
        <!-- Mobile & Desktop Header -->
        <div class="flex items-center justify-between py-4">
            <!-- Logo/Brand -->
            <div class="flex-shrink-0">
                <span class="font-semibold text-xl tracking-tight text-white">Kalkulator EUCS</span>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex lg:items-center lg:space-x-4">
                <div class="flex space-x-2">
                    <a href="{{ route('dashboard', ['references' => session('existingRecordId')]) }}"
                        class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('dashboard') ? 'bg-green-700' : '' }}">
                        Beranda
                    </a>
                    
                    @php
                        $references = request()->has('references') ? request()->query('references') : session('existingRecordId');
                    @endphp
                    
                    <a href="{{ route('data.index', ['type' => 'x', 'references' => $references]) }}"
                        class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('data/analysis/x') || request()->is('data/x/*') ? 'bg-green-700' : '' }}">
                        Data X
                    </a>
                    
                    <a href="{{ route('data.index', ['type' => 'y', 'references' => $references]) }}"
                        class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('data/analysis/y') || request()->is('data/y/*') ? 'bg-green-700' : '' }}">
                        Data Y
                    </a>
                    
                    <a href="{{ route('analysis', ['references' => $references]) }}"
                        class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('analysis') || request()->is('analysis/*') ? 'bg-green-700' : '' }}">
                        Hasil
                    </a>
                </div>
                
                <!-- Auth Links - Desktop -->
                <div class="ml-4">
                    @if (!auth()->check())
                        <a href="{{ route('login') }}" 
                            class="bg-white text-green-700 hover:bg-gray-100 px-4 py-2 rounded-lg font-bold transition duration-200">
                            Masuk
                        </a>
                    @else
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-white text-green-700 hover:bg-gray-100 px-4 py-2 rounded-lg font-bold transition duration-200">
                                Logout
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            
            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu - Hidden by default -->
        <div id="mobile-menu" class="hidden lg:hidden pb-4">
            <div class="flex flex-col space-y-2">
                <a href="{{ route('dashboard', ['references' => session('existingRecordId')]) }}"
                    class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('dashboard') ? 'bg-green-700' : '' }}">
                    Beranda
                </a>
                
                <a href="{{ route('data.index', ['type' => 'x', 'references' => $references]) }}"
                    class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('data/analysis/x') || request()->is('data/x/*') ? 'bg-green-700' : '' }}">
                    Data X
                </a>
                
                <a href="{{ route('data.index', ['type' => 'y', 'references' => $references]) }}"
                    class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('data/analysis/y') || request()->is('data/y/*') ? 'bg-green-700' : '' }}">
                    Data Y
                </a>
                
                <a href="{{ route('analysis', ['references' => $references]) }}"
                    class="text-white hover:bg-green-700 px-4 py-2 rounded-lg font-medium transition duration-200 {{ request()->is('analysis') || request()->is('analysis/*') ? 'bg-green-700' : '' }}">
                    Hasil
                </a>
                
                <!-- Auth Links - Mobile -->
                @if (!auth()->check())
                    <a href="{{ route('login') }}" 
                        class="bg-white text-green-700 hover:bg-gray-100 px-4 py-2 rounded-lg font-bold text-center transition duration-200">
                        Masuk
                    </a>
                @else
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-white text-green-700 hover:bg-gray-100 px-4 py-2 rounded-lg font-bold transition duration-200">
                            Logout
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</nav>

<script>
    // Mobile menu toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>