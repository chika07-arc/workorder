<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT Jembayan Muarabara - Register</title>
    <link rel="icon" href="{{ asset('jembayan-favicon.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background: #f0f4f8; }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 360px;
            padding: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.15); }
        .btn-primary { 
            background: #001f3f; 
            color: #fff; 
            font-weight: 600; 
            transition: background 0.3s, transform 0.2s; 
        }
        .btn-primary:hover { background: #003366; transform: scale(1.03); }
        input:focus { border-color: #001f3f; box-shadow: 0 0 0 3px rgba(0,31,63,0.2); }
        @media (max-width: 640px) { .card { padding: 1.5rem; } }
    </style>
</head>
<body class="font-sans antialiased flex items-center justify-center min-h-screen px-4">

    <div class="card">
        <!-- Header -->
        <div class="text-center mb-6">
            <img src="{{ asset('logo.png') }}" alt="Logo PT Jembayan Muarabara" class="mx-auto w-20 h-auto mb-3">
            <h2 class="text-2xl font-bold text-[#001f3f]">Register Account</h2>
            <p class="text-gray-600 text-sm mt-1">Silakan buat akun untuk mengakses sistem Work Order</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-[#001f3f] font-medium mb-1">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-[#001f3f] focus:ring focus:ring-[#001f3f]/20">
                @error('name') <p class="text-red-600 mt-1 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-[#001f3f] font-medium mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-[#001f3f] focus:ring focus:ring-[#001f3f]/20">
                @error('email') <p class="text-red-600 mt-1 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-[#001f3f] font-medium mb-1">Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-[#001f3f] focus:ring focus:ring-[#001f3f]/20">
                @error('password') <p class="text-red-600 mt-1 text-xs">{{ $message }}</p> @enderror
            </div>

            <div class="mb-5">
                <label for="password_confirmation" class="block text-[#001f3f] font-medium mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:border-[#001f3f] focus:ring focus:ring-[#001f3f]/20">
                @error('password_confirmation') <p class="text-red-600 mt-1 text-xs">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full btn-primary py-2 rounded-md text-lg">Register</button>

            <a href="{{ route('login') }}" class="mt-4 block text-center text-sm text-[#001f3f] hover:text-[#003366] underline">
                Already registered? Login
            </a>
        </form>
    </div>

</body>
</html>
