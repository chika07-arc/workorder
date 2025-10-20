@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="container py-5">

        <!-- HEADER -->
        <div class="header-section text-center mb-5">
            <div class="header-card">
                <h2 class="header-title">Dashboard Maintenance</h2>
                <p class="header-subtitle">Selamat datang di sistem manajemen maintenance.</p>
                <p class="header-description">Kelola Work Order, Pemakaian Material, riwayat pemeliharaan, dan data mesin dengan mudah.</p>
            </div>
        </div>

        <!-- DASHBOARD CARDS -->
        <div class="row g-4">
            @php
                $features = [
                    [
                        'title' => 'Work Orders Tersimpan',
                        'desc' => 'Lihat semua Work Order yang sudah tersimpan di sistem.',
                        'icon' => 'bi-journal-text',
                        'route' => route('workorders.index'),
                        'btn' => 'Lihat WO',
                        'btnIcon' => 'bi-eye',
                    ],
                    [
                        'title' => 'Buat Work Order Baru',
                        'desc' => 'Mulai membuat Work Order baru untuk proses produksi atau maintenance.',
                        'icon' => 'bi-pencil-square',
                        'route' => route('workorders.create'),
                        'btn' => 'Create WO',
                        'btnIcon' => 'bi-plus-circle',
                    ],
                    [
                        'title' => 'Material Usage',
                        'desc' => 'Pantau dan kelola penggunaan material untuk setiap Work Order.',
                        'icon' => 'bi-box-seam',
                        'route' => route('pemakaian-material.index'),
                        'btn' => 'Lihat Material',
                        'btnIcon' => 'bi-box',
                    ],
                ];
            @endphp

            @foreach($features as $index => $feature)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="feature-card-wrapper">
                    <div class="feature-card h-100 {{ $index < 2 ? 'has-route' : '' }}">
                        <div class="card-body text-center position-relative">
                            <div class="icon-container mb-4">
                                <i class="bi {{ $feature['icon'] }}"></i>
                            </div>
                            <h5 class="card-title">{{ $feature['title'] }}</h5>
                            <p class="card-description mb-4">{{ $feature['desc'] }}</p>
                            @if($feature['route'] !== '#')
                                <a href="{{ $feature['route'] }}" class="btn btn-primary">
                                    <i class="bi {{ $feature['btnIcon'] }} me-2"></i>{{ $feature['btn'] }}
                                </a>
                            @else
                                <button class="btn btn-outline-primary disabled-feature">
                                    <i class="bi {{ $feature['btnIcon'] }} me-2"></i>{{ $feature['btn'] }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
    :root {
        --navy-primary: #001f3f;
        --navy-secondary: #003366;
        --navy-light: #e6f0ff;
        --navy-lighter: #f0f4f8;
        --white: #ffffff;
        --light-gray: #f8f9fa;
        --text-dark: #2c3e50;
        --text-light: #6c757d;
        --shadow: 0 8px 25px rgba(0, 31, 63, 0.08);
        --shadow-hover: 0 12px 35px rgba(0, 31, 63, 0.12);
        --border-radius: 16px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-container {
        background: linear-gradient(135deg, var(--light-gray) 0%, #f5f7fa 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Header Section */
    .header-section {
        position: relative;
    }

    .header-card {
        background: var(--white);
        padding: 3rem 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 31, 63, 0.05);
    }

    .header-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--navy-primary), var(--navy-secondary), var(--navy-primary));
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .header-title {
        color: var(--navy-primary);
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
        position: relative;
    }

    .header-subtitle {
        color: var(--text-dark);
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .header-description {
        color: var(--text-light);
        font-size: 1rem;
        line-height: 1.6;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Feature Cards */
    .feature-card-wrapper {
        transition: var(--transition);
        height: 100%;
    }

    .feature-card-wrapper:hover {
        transform: translateY(-4px);
    }

    .feature-card {
        background: var(--white);
        border-radius: var(--border-radius);
        border: 1px solid rgba(0, 31, 63, 0.05);
        box-shadow: var(--shadow);
        transition: var(--transition);
        height: 100%;
        overflow: hidden;
        position: relative;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--navy-light);
        opacity: 0;
        transition: var(--transition);
        transform: scaleX(0);
        transform-origin: left;
    }

    .feature-card.has-route::before {
        background: linear-gradient(90deg, var(--navy-primary), var(--navy-secondary));
    }

    .feature-card:hover {
        box-shadow: var(--shadow-hover);
        border-color: rgba(0, 31, 63, 0.1);
        transform: translateY(-2px);
    }

    .feature-card:hover::before {
        opacity: 1;
        transform: scaleX(1);
    }

    .card-body {
        padding: 2.5rem 2rem;
        background: var(--white);
        position: relative;
        z-index: 1;
    }

    .icon-container {
        width: 90px;
        height: 90px;
        margin: 0 auto;
        background: linear-gradient(135deg, var(--navy-light), rgba(0, 31, 63, 0.05));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        position: relative;
        border: 2px solid transparent;
        background-clip: padding-box;
    }

    .feature-card:hover .icon-container {
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        border-color: rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 25px rgba(0, 31, 63, 0.15);
        transform: scale(1.05);
    }

    .icon-container i {
        font-size: 2.5rem;
        color: var(--navy-primary);
        transition: var(--transition);
    }

    .feature-card:hover .icon-container i {
        color: var(--white);
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    }

    .card-title {
        color: var(--text-dark);
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        line-height: 1.4;
        transition: var(--transition);
    }

    .feature-card:hover .card-title {
        color: var(--navy-primary);
    }

    .card-description {
        color: var(--text-light);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        transition: var(--transition);
    }

    .feature-card:hover .card-description {
        color: var(--text-dark);
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: var(--white);
        width: 100%;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0, 31, 63, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--navy-secondary), var(--navy-primary));
        color: var(--white);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 31, 63, 0.3);
    }

    .disabled-feature {
        background: transparent;
        border: 2px solid var(--navy-light);
        color: var(--text-light);
        pointer-events: none;
        opacity: 0.6;
    }

    .disabled-feature i {
        color: var(--navy-light);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .feature-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .feature-card:nth-child(1) { animation-delay: 0.1s; }
    .feature-card:nth-child(2) { animation-delay: 0.2s; }
    .feature-card:nth-child(3) { animation-delay: 0.3s; }
    .feature-card:nth-child(4) { animation-delay: 0.4s; }
    .feature-card:nth-child(5) { animation-delay: 0.5s; }

    /* Responsive */
    @media (max-width: 768px) {
        .header-card {
            padding: 2rem 1.5rem;
        }

        .header-title {
            font-size: 1.8rem;
        }

        .card-body {
            padding: 2rem 1.5rem;
        }

        .icon-container {
            width: 70px;
            height: 70px;
        }

        .icon-container i {
            font-size: 2rem;
        }
    }

    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: var(--light-gray);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--navy-light);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--navy-primary);
    }
</style>

<!-- BOOTSTRAP ICONS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection