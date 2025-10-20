<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PT Jembayan Muarabara' }}</title>
    <link rel="icon" href="{{ asset('jembayan-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#001f3f] font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8">
            <!-- Logo & Title -->
            <div class="text-center mb-6">
                <img src="{{ asset('logo.png') }}" alt="PT Jembayan Muarabara Logo" class="mx-auto w-28 h-auto mb-3">
                <h1 class="text-2xl font-bold text-[#001f3f]">{{ $title ?? 'Selamat Datang' }}</h1>
            </div>

            <!-- Slot for Form Content -->
            <div>
                {{ $slot }}
            </div>
        </div>

    </div>
</body>
</html>
