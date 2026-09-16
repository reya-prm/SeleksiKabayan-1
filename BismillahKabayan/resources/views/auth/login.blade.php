<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Inventory</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-sm">
        <h1 class="text-xl font-bold mb-6 text-center">PT Sinar Nusantara</h1>

        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600 bg-red-50 border border-red-200 rounded p-2">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required autofocus>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Password</label>
                <input type="password" name="password"
                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required>
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-sm">Ingat saya</label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white rounded-lg py-2 font-medium hover:bg-blue-700">
                Masuk
            </button>

            <!-- Tombol Kembali ke Menu Utama -->
            <div class="mt-4 text-center">
                <a href="{{ route('main') }}" class="text-sm text-gray-500 hover:text-blue-600 hover:underline inline-flex items-center gap-1">
                    &larr; Kembali ke menu utama
                </a>
            </div>
        </form>
    </div>
</body>

</html>