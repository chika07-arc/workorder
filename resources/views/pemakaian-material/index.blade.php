@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold text-dark">Material Usages</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('pemakaian-material.index') }}" class="btn btn-sm btn-outline-dark" style="border-color: #001f3f; color: #001f3f;">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <form method="GET" action="{{ route('pemakaian-material.index') }}" id="filterForm" class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="bi bi-search" style="color: #001f3f;"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Search Material / ID Material..."
                    value="{{ request('search') }}"
                    id="searchInput"
                >
            </div>
        </div>

        <div class="col-md-3">
            <select name="month" id="monthSelect" class="form-select" style="border-color: #001f3f;">
                <option value="">-- Filter Bulan --</option>
                @foreach (range(1, 12) as $m)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100" style="background-color: #001f3f; border-color: #001f3f;">
                <i class="bi bi-funnel"></i> Filter
            </button>
        </div>
    </form>

    <!-- Table Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead style="background-color: #001f3f; color: #fff;">
                        <tr>
                            <th class="ps-4 py-3">ID Material</th>
                            <th class="py-3">Material</th>
                            <th class="py-3">Description</th>
                            <th class="py-3">Usages</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody id="materialTable">
                        @forelse ($usages as $item)
                            <tr>
                                <td class="ps-4">{{ $item['material_no'] }}</td>
                                <td>{{ $item['nama_material'] }}</td>
                                <td>{{ $item['deskripsi'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>
                                    <a
                                        href="{{ route('pemakaian-material.detail', ['material_no' => $item['material_no']]) }}"
                                        class="btn btn-sm btn-outline-dark"
                                        style="border-color: #001f3f; color: #001f3f;"
                                    >
                                        <i class="bi bi-eye"></i> Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Belum ada data pemakaian material
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-light bg-opacity-75 d-flex justify-content-center align-items-center" style="z-index: 1000;">
        <div class="spinner-border" style="color: #001f3f;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.btn-outline-dark:hover {
    background-color: #001f3f !important;
    color: #fff !important;
}
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9rem;
}
.table td {
    vertical-align: middle;
    font-size: 0.95rem;
}
.table-hover tbody tr:hover {
    background-color: #f1f5f9;
}
.form-control:focus, .form-select:focus {
    border-color: #001f3f;
    box-shadow: 0 0 0 0.2rem rgba(0, 31, 63, 0.15);
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthSelect = document.getElementById('monthSelect');
    const filterForm = document.getElementById('filterForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // Ganti bulan → auto-submit
    monthSelect.addEventListener('change', function() {
        loadingOverlay.classList.remove('d-none');
        filterForm.submit();
    });

    // Overlay hilang pas halaman selesai load
    window.addEventListener('load', function() {
        loadingOverlay.classList.add('d-none');
    });
});
</script>
@endsection
