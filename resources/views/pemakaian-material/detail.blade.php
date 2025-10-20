@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Material Usages Detail</h2>
        <a href="{{ route('pemakaian-material.index') }}" class="btn btn-sm btn-outline-dark" style="border-color: #001f3f; color: #001f3f;">
            <i class="bi bi-arrow-left"></i> back To List
        </a>
    </div>

    <!-- Material Info Card -->
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body">
            <h5 class="fw-bold text-navy mb-1">{{ $material_no }} - {{ $materialInfo['nama_material'] }}</h5>
            <p class="text-muted mb-0">{{ $materialInfo['deskripsi'] }}</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead style="background-color: #001f3f; color: #fff;">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Order Number</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Quantity</th>
                            <th class="py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detailUsages as $i => $item)
                            <tr>
                                <td class="ps-4">{{ $i + 1 }}</td>
                                <td>{{ $item['order_number'] ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y H:i') }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>
                                    <a
                                        href="{{ route('workorders.show', $item['work_order_id']) }}"
                                        class="btn btn-sm btn-outline-dark"
                                        style="border-color: #001f3f; color: #001f3f;"
                                    >
                                        <i class="bi bi-eye"></i> Lihat WO
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bi bi-info-circle me-2"></i>
                                    Tidak ada data Work Order untuk material ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
/* Navy Color Palette */
.text-navy {
    color: #001f3f !important;
}

.btn-outline-dark:hover {
    background-color: #001f3f !important;
    color: #fff !important;
}

/* Table Styling */
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
    background-color: #f1f5f9; /* Slate-100 for subtle hover */
}

/* Card Styling */
.card {
    background-color: #fff;
}

/* Responsive Adjustments */
@media (max-width: 576px) {
    .d-flex {
        flex-direction: column;
        align-items: flex-start;
    }
    .d-flex .btn {
        margin-top: 0.5rem;
    }
}
</style>
@endsection