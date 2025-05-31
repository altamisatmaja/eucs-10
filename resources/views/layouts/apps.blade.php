<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kalkulator EUCS | @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="https://img.freepik.com/premium-vector/letter-g-leaf-logo-vector_23987-220.jpg?semt=ais_hybrid&w=740"
        type="image/x-icon">
    
</head>

<body>
    @include('layouts.notification')
    <!-- component -->
    <!-- This is an example component -->
    <div>
        @include('layouts.nav')
        <div class="flex overflow-hidden bg-white pt-16">
            @include('layouts.aside')
            <div class="bg-gray-900 opacity-50 hidden fixed inset-0 z-10" id="sidebarBackdrop"></div>
            <div id="main-content" class="w-full bg-gray-50  lg:ml-64">
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
        @include('layouts.script')
        @yield('scripts')
    </div>
</body>

</html>
