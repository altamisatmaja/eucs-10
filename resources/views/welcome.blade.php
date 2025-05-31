<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kalkulator EUCS | Selamat datang</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="https://img.freepik.com/premium-vector/letter-g-leaf-logo-vector_23987-220.jpg?semt=ais_hybrid&w=740" type="image/x-icon">
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="antialiased">

    <main>
        <section class="bg-white  h-screen">
            <nav x-data="{ isOpen: false }" class="mx-auto p-6 lg:flex lg:items-center lg:justify-between sticky  top-0 bg-white w-full">
                <div class="flex items-center justify-between">
                    <div>
                        <a class="text-2xl font-bold text-gray-800 hover:text-gray-700   lg:text-3xl"
                            href="#">Kalkulator EUCS</a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex lg:hidden">
                        <button x-cloak @click="isOpen= !isOpen" type="button"
                            class="text-gray-500 hover:text-gray-600 focus:text-gray-600 focus:outline-none   dark:focus:text-gray-400"
                            aria-label="toggle menu">
                            <svg x-show="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16" />
                            </svg>

                            <svg x-show="isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                <div x-cloak :class="[isOpen ? 'translate-x-0 opacity-100 ' : 'opacity-0 -translate-x-full']"
                    class="absolute inset-x-0 z-20 w-full bg-white px-6 py-4 shadow-md transition-all duration-300 ease-in-out  lg:relative lg:top-0 lg:mt-0 lg:flex lg:w-auto lg:translate-x-0 lg:items-center lg:bg-transparent lg:p-0 lg:opacity-100 lg:shadow-none">


                    <a class="mt-4 block rounded-lg bg-green-700 px-6 py-2.5 text-center font-medium capitalize leading-5 text-white hover:bg-green-600 lg:mt-0 lg:w-auto"
                        href="{{ route('login')}}"> Masuk </a>
                </div>
            </nav>

            <div class="container mx-auto px-6 py-16 text-center">
                <div class="mx-auto max-w-lg">
                    <h1 class="text-3xl font-bold text-gray-800  lg:text-4xl">Mulai coba Kalkulator ECUS secara online
                    </h1>
                    <p class="mt-6 text-black">Dapatkan hasil perhitungan secara
                        instan melalui data berformat csv yang Anda upload!</p>
                    <a href="{{ route('login') }}">
                        <button
                            class="mt-6 rounded-lg bg-green-700 px-6 py-2.5 text-center text-sm font-medium capitalize leading-5 text-white hover:bg-green-600 focus:outline-none lg:mx-0 lg:w-auto">
                            Mulai</button>
                    </a>
                </div>

                <div class="mt-10 flex justify-center">
                    <div class="w-full lg:w-4/5 h-[700px] rounded-xl overflow-hidden">
                        <img src="https://sdmntprnorthcentralus.oaiusercontent.com/files/00000000-6634-622f-ae46-7013e432825e/raw?se=2025-05-31T09%3A14%3A40Z&sp=r&sv=2024-08-04&sr=b&scid=862335c3-f302-5d98-96b2-49ff9034e2fb&skoid=add8ee7d-5fc7-451e-b06e-a82b2276cf62&sktid=a48cca56-e6da-484e-a814-9c849652bcb3&skt=2025-05-31T08%3A08%3A19Z&ske=2025-06-01T08%3A08%3A19Z&sks=b&skv=2024-08-04&sig=5yusRV2Dau%2BLD%2BzBJevr1nivRPSIBsAnji3ASasFGRg%3D"
                            class="w-full h-[800px] object-cover" alt="Cover Image" />
                    </div>
                </div>


            </div>
        </section>

    </main>
</body>

</html>
