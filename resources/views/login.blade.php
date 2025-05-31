<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Masuk</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon"
        href="https://img.freepik.com/premium-vector/letter-g-leaf-logo-vector_23987-220.jpg?semt=ais_hybrid&w=740"
        type="image/x-icon">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg border shadow-md w-full max-w-md">
            <h1 class="text-2xl font-semibold text-center text-gray-800 mb-6">Silakan Masuk ke Sistem</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="username" class="block text-gray-700 mb-2 font-medium">Nama Pengguna</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                        required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 mb-2 font-medium">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                            required>
                        <button type="button" onclick="togglePassword()" class="absolute right-3 top-2 text-gray-500">
                            <i id="eyeIcon" class="far fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition font-medium">
                    Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>

</html>
