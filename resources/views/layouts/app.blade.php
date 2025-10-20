<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Maintenance PT. Jembayan Muarabara')</title>

    <link rel="icon" href="{{ asset('jembayan-favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            padding-top: 70px; /* biar konten ga ketimpa navbar */
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #001f3f !important;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1050;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            transition: top 0.2s ease-in-out;
        }

        .navbar-brand span {
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* biar toggle animasi smooth di mobile */
        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }
    </style>

    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" width="40" height="40" class="me-2">
                <span>PT Jembayan Muarabara</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('workorders.index') }}">Work Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('workorders.create') }}">Create WO</a></li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link" style="background: none; border: none; cursor: pointer; color: rgba(255,255,255,.75);">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @yield('content')
    </main>

    <!-- JS scripts di akhir biar load cepat -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>
</html>
