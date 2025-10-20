@extends('layouts.app')

@section('content')
<div class="workorder-detail-wrapper">
    <div class="container py-5">
        <!-- Header -->
        <div class="page-header mb-5">
            <div class="header-content">
                <div class="header-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div>
                    <h1 class="page-title">Work Order Details</h1>
                    <p class="page-subtitle">Comprehensive view of work order information and materials</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('workorders.pdf', $workorder->id) }}" target="_blank" class="btn btn-pdf-print">
                        <i class="bi bi-file-earmark-pdf"></i>
                        <span>Print PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="status-container mb-4">
            <div class="status-badge">
                <i class="bi bi-circle-fill"></i>
                <span>Order #{{ $workorder->order_number ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Order Information Card -->
            <div class="col-lg-8">
                <div class="info-card">
                    <div class="card-header-section">
                        <div class="section-icon">
                            <i class="bi bi-info-circle"></i>
                        </div>
                        <h3 class="section-title">Order Information</h3>
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Order Number</label>
                            <div class="info-value">
                                <strong>{{ $workorder->order_number ?? '-' }}</strong>
                            </div>
                        </div>
                        <div class="info-item">
                            <label>Main Work Center</label>
                            <div class="info-value">{{ $workorder->main_work_center ?? '-' }}</div>
                        </div>
                        <div class="info-item">
                            <label>Location</label>
                            <div class="info-value">
                                <i class="bi bi-geo-alt"></i>
                                {{ $workorder->lokasi ?? '-' }}
                            </div>
                        </div>
                        <div class="info-item">
                            <label>Date Created</label>
                            <div class="info-value">
                                <i class="bi bi-calendar"></i>
                                {{ $workorder->created_at ? $workorder->created_at->format('d M Y, H:i') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Work Order Description Card -->
                <div class="info-card mt-4">
                    <div class="card-header-section">
                        <div class="section-icon secondary">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <h3 class="section-title">Work Order Description</h3>
                    </div>
                    <div class="description-content">
                        <div class="desc-row">
                            <div class="desc-item">
                                <label>Created By</label>
                                <span>{{ $workorder->created_by ?? 'N/A' }}</span>
                            </div>
                            <div class="desc-item">
                                <label>Work Order ID</label>
                                <span>{{ $workorder->id_workorder ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="desc-main">
                            <label>Description</label>
                            <p class="description-text">{{ $workorder->deskripsi ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Beautiful Operation Card -->
                <div class="info-card operation-card mt-4">
                    <div class="card-header-section">
                        <div class="section-icon accent">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                        <h3 class="section-title">Operation Details</h3>
                    </div>
                    
                    <div class="operation-content">
                        <div class="operation-center-container">
                            <div class="operation-icon-large">
                                <i class="bi bi-building-gear"></i>
                            </div>
                            <div class="operation-center-details">
                                <div class="operation-label">Operation Center</div>
                                <div class="operation-value-large">
                                    {{ $workorder->operation_center ?? 'Not Specified' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials Card -->
            <div class="col-lg-4">
                <div class="materials-card sticky-top">
                    <div class="card-header-section">
                        <div class="section-icon materials">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <h3 class="section-title">Materials Ordered</h3>
                        @php
                            $materials = json_decode($workorder->materials, true) ?? [];
                            $totalMaterials = count($materials);
                        @endphp
                        <div class="materials-count">
                            <span class="count-badge">{{ $totalMaterials }}</span>
                            <span class="count-label">{{ $totalMaterials === 1 ? 'Material' : 'Materials' }}</span>
                        </div>
                    </div>
                    
                    @if($totalMaterials > 0)
                        <div class="materials-list">
                            @foreach($materials as $index => $mat)
                            <div class="material-item" data-toggle="tooltip" title="{{ $mat['deskripsi'] ?? '' }}">
                                <div class="material-icon">
                                    <i class="bi bi-package"></i>
                                </div>
                                <div class="material-info">
                                    <div class="material-name">{{ $mat['nama_material'] ?? '-' }}</div>
                                    <div class="material-meta">
                                        <span class="material-no">{{ $mat['material_no'] ?? '-' }}</span>
                                        <span class="quantity">{{ $mat['quantity'] ?? '-' }} {{ $mat['satuan'] ?? '' }}</span>
                                    </div>
                                </div>
                                <div class="material-location">
                                    <i class="bi bi-rack"></i>
                                    <span>{{ Str::limit($mat['lokasi_rak'] ?? '-', 15) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>No materials added</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-section mt-5">
            <div class="action-buttons">
                <a href="{{ route('workorders.pdf', $workorder->id) }}" target="_blank" class="btn btn-primary">
                    <i class="bi bi-file-earmark-pdf"></i>
                    <span>Download PDF</span>
                </a>
                <a href="{{ route('workorders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to List</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- STYLES -->
<style>
    :root {
        --navy-primary: #001f3f;
        --navy-secondary: #003366;
        --navy-accent: #004080;
        --navy-light: #e6f0ff;
        --white: #ffffff;
        --light-gray: #f8f9fa;
        --text-dark: #2c3e50;
        --text-light: #6c757d;
        --border-radius: 16px;
        --shadow: 0 8px 32px rgba(0, 31, 63, 0.08);
        --shadow-hover: 0 12px 40px rgba(0, 31, 63, 0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .workorder-detail-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Page Header */
    .page-header {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 31, 63, 0.05);
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .header-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        flex-shrink: 0;
    }

    .header-icon i {
        font-size: 1.5rem;
    }

    .page-title {
        color: var(--navy-primary);
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .page-subtitle {
        color: var(--text-light);
        margin: 0;
        font-size: 1rem;
    }

    .header-actions {
        margin-left: auto;
    }

    /* Status Badge */
    .status-container {
        position: relative;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--white);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        box-shadow: var(--shadow);
        font-weight: 600;
        color: var(--navy-primary);
        border: 2px solid var(--navy-light);
    }

    .status-badge i {
        color: var(--navy-accent);
        font-size: 0.75rem;
    }

    /* Info Cards */
    .info-card {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid rgba(0, 31, 63, 0.05);
        transition: var(--transition);
    }

    .info-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .card-header-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem 2rem;
        background: linear-gradient(90deg, rgba(0, 31, 63, 0.02), rgba(0, 50, 102, 0.02));
        border-bottom: 1px solid rgba(0, 31, 63, 0.05);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .section-icon { background: var(--navy-primary); }
    .section-icon.secondary { background: var(--navy-secondary); }
    .section-icon.accent { background: var(--navy-accent); }
    .section-icon.materials { background: linear-gradient(135deg, var(--navy-primary), var(--navy-accent)); }

    .section-title {
        color: var(--navy-primary);
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        flex-grow: 1;
    }

    .materials-count {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--navy-light);
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        color: var(--navy-primary);
    }

    .count-badge {
        background: var(--navy-primary);
        color: var(--white);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.75rem;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        padding: 2rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-item label {
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        color: var(--text-dark);
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .info-value i {
        color: var(--navy-primary);
        width: 18px;
    }

    /* Description */
    .description-content {
        padding: 2rem;
    }

    .desc-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .desc-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .desc-item label {
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .desc-item span {
        color: var(--text-dark);
        font-weight: 500;
    }

    .desc-main label {
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
        display: block;
    }

    .description-text {
        color: var(--text-dark);
        line-height: 1.6;
        background: rgba(0, 31, 63, 0.02);
        padding: 1rem;
        border-radius: 8px;
        border-left: 3px solid var(--navy-primary);
        white-space: pre-wrap;
    }

    /* Materials */
    .materials-list {
        max-height: 600px;
        overflow-y: auto;
    }

    .material-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem;
        border-bottom: 1px solid rgba(0, 31, 63, 0.05);
        transition: var(--transition);
        cursor: pointer;
    }

    .material-item:hover {
        background: rgba(0, 31, 63, 0.02);
        transform: translateX(4px);
    }

    .material-item:last-child {
        border-bottom: none;
    }

    .material-icon {
        width: 40px;
        height: 40px;
        background: var(--navy-light);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--navy-primary);
        flex-shrink: 0;
    }

    .material-info {
        flex-grow: 1;
    }

    .material-name {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .material-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: var(--text-light);
    }

    .material-location {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--navy-accent);
        white-space: nowrap;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-light);
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Action Buttons */
    .action-section {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-top: 2rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        border: 2px solid transparent;
        min-height: 48px;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        color: var(--white);
        border-color: var(--navy-primary);
    }

    .btn-primary:hover {
        background: var(--white);
        color: var(--navy-primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    .btn-secondary {
        background: transparent;
        color: var(--text-dark);
        border-color: var(--text-light);
    }

    .btn-secondary:hover {
        background: var(--navy-light);
        color: var(--navy-primary);
        border-color: var(--navy-primary);
        transform: translateY(-2px);
    }

    /* Sticky Materials Card */
    .materials-card {
        position: sticky;
        top: 20px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .desc-row {
            grid-template-columns: 1fr;
        }
        
        .header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .header-actions {
            margin-left: 0;
            margin-top: 1rem;
        }
        
        .materials-card {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            padding: 1.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
            align-items: stretch;
        }
        
        .btn {
            justify-content: center;
        }
    }

    /* Scrollbar */
    .materials-list::-webkit-scrollbar {
        width: 6px;
    }

    .materials-list::-webkit-scrollbar-track {
        background: rgba(0, 31, 63, 0.02);
    }

    .materials-list::-webkit-scrollbar-thumb {
        background: var(--navy-light);
        border-radius: 3px;
    }

    .materials-list::-webkit-scrollbar-thumb:hover {
        background: var(--navy-primary);
    }

    /* Animations */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .info-card {
        animation: slideInUp 0.6s ease forwards;
    }

    .info-card:nth-child(1) { animation-delay: 0.1s; }
    .info-card:nth-child(2) { animation-delay: 0.2s; }
    .info-card:nth-child(3) { animation-delay: 0.3s; }

/* Beautiful Operation Card Styles */
.operation-card {
    background: linear-gradient(135deg, var(--white) 0%, #fdfdfd 100%);
    border: 1px solid rgba(0, 64, 128, 0.08);
    position: relative;
    overflow: hidden;
}

.operation-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--navy-accent), var(--navy-primary));
}

.operation-content {
    padding: 2.5rem;
    position: relative;
}

.operation-center-container {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: linear-gradient(135deg, rgba(0, 64, 128, 0.03), rgba(0, 31, 63, 0.03));
    border-radius: 12px;
    padding: 2rem;
    border: 1px solid rgba(0, 64, 128, 0.1);
    position: relative;
    overflow: hidden;
}

.operation-center-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--navy-accent), transparent);
}

.operation-icon-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--navy-accent), var(--navy-primary));
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
    flex-shrink: 0;
    box-shadow: 0 8px 25px rgba(0, 64, 128, 0.15);
    position: relative;
    z-index: 2;
}

.operation-icon-large i {
    font-size: 2rem;
}

.operation-center-details {
    flex: 1;
    position: relative;
    z-index: 2;
}

.operation-label {
    color: var(--navy-accent);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 0.5rem;
    opacity: 0.8;
}

.operation-value-large {
    color: var(--navy-primary);
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 0.25rem;
    word-break: break-word;
}

.operation-value-large:empty::before {
    content: 'Not Specified';
    color: var(--text-light);
    font-weight: 500;
}

.operation-subtitle {
    color: var(--text-light);
    font-size: 0.95rem;
    line-height: 1.5;
    margin: 0;
    opacity: 0.9;
}

.section-icon.accent {
    background: linear-gradient(135deg, var(--navy-accent), var(--navy-primary));
    box-shadow: 0 4px 15px rgba(0, 64, 128, 0.2);
}

.card-header-section {
    background: linear-gradient(90deg, rgba(0, 64, 128, 0.04), rgba(0, 31, 63, 0.04));
    border-bottom: 1px solid rgba(0, 64, 128, 0.08);
}

.operation-card:hover {
    box-shadow: 0 15px 45px rgba(0, 31, 63, 0.12);
    transform: translateY(-3px);
}

.operation-card:hover .operation-center-container {
    box-shadow: 0 8px 25px rgba(0, 64, 128, 0.08);
    transform: scale(1.02);
}

/* Responsive */
@media (max-width: 768px) {
    .operation-content {
        padding: 1.5rem;
    }
    
    .operation-center-container {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
        gap: 1rem;
    }
    
    .operation-icon-large {
        width: 60px;
        height: 60px;
    }
    
    .operation-icon-large i {
        font-size: 1.5rem;
    }
    
    .operation-value-large {
        font-size: 1.25rem;
    }
}

@media (max-width: 576px) {
    .operation-center-container {
        padding: 1.25rem;
    }
}


</style>

<script>
    // Add tooltips and interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add tooltips to material items
        const materialItems = document.querySelectorAll('.material-item');
        materialItems.forEach(item => {
            item.addEventListener('click', function() {
                const tooltip = this.getAttribute('data-toggle');
                if (tooltip) {
                    alert(tooltip); // Replace with proper tooltip library
                }
            });
        });

        // Add copy to clipboard for order number
        const orderNumber = document.querySelector('.info-value strong');
        if (orderNumber) {
            orderNumber.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent);
                this.style.background = 'rgba(0, 31, 63, 0.1)';
                setTimeout(() => {
                    this.style.background = '';
                }, 1000);
            });
        }
    });
</script>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection