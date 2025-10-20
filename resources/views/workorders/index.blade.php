@extends('layouts.app')

@section('content')
<div class="workorders-page-wrapper">
    <div class="container py-5">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Saved Work Order</h1>
        </div>

        <!-- Search Bar -->
        <div class="search-wrapper mb-4">
            <form method="GET" action="{{ route('workorders.index') }}" class="search-form">
                <div class="input-group">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        class="search-input" 
                        placeholder="Search by WO Number, Location, or Work Center...">
                    <button type="submit" class="search-btn">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
        </div>


        <!-- Success Alert -->
        @if (session('success'))
            <div class="success-alert-wrapper">
                <div class="success-alert">
                    <div class="alert-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="alert-content">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Empty State -->
        @if($workorders->isEmpty())
            <div class="empty-state-wrapper">
                <div class="empty-state-card">
                    <div class="empty-icon">
                        <i class="bi bi-clipboard-x"></i>
                    </div>
                    <p>There is Nothing WO.</p>
                </div>
            </div>
        @else
            <!-- Work Orders Table -->
            <div class="table-container">
                <div class="table-wrapper">
                    <div class="table-responsive">
                        <table class="workorders-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Work Order</th>
                                    <th>Main Work Center</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($workorders as $index => $wo)
                                    <tr>
                                        <td class="row-number">{{ $index + 1 }}</td>
                                        <td class="order-number">
                                            <span class="order-badge">{{ $wo->order_number }}</span>
                                        </td>
                                        <td class="work-center">{{ $wo->main_work_center ?? '-' }}</td>
                                        <td class="location">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $wo->lokasi ?? '-' }}
                                        </td>
                                        <td class="description">{{ Str::limit($wo->deskripsi ?? '-', 80) }}</td>
                                        <td class="actions">
                                            <div class="action-buttons">
                                                <!-- Detail -->
                                                <a href="{{ route('workorders.show', $wo->id) }}" class="btn-action detail">
                                                    <i class="bi bi-eye"></i>
                                                    <span>Details</span>
                                                </a>

                                                <!-- Edit -->
                                                <a href="{{ route('workorders.edit', $wo->id) }}" class="btn-action edit">
                                                    <i class="bi bi-pencil"></i>
                                                    <span>Edit</span>
                                                </a>

                                                <!-- Hapus -->
                                                <form action="{{ route('workorders.destroy', $wo->id) }}" method="POST" 
                                                      class="delete-form"
                                                      onsubmit="return confirm('Are you sure to delete this WO?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action delete">
                                                        <i class="bi bi-trash"></i>
                                                        <span>Delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>

    /* Search Bar */
    .search-wrapper {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .search-form {
        width: 100%;
        max-width: 500px;
    }

    .input-group {
        display: flex;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        background: var(--white);
        border: 1px solid rgba(0, 31, 63, 0.1);
    }

    .search-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        outline: none;
        font-size: 1rem;
        color: var(--navy-dark);
        background: transparent;
    }

    .search-btn {
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-medium));
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        cursor: pointer;
        font-weight: 600;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-btn:hover {
        opacity: 0.9;
    }


    :root {
        --navy-dark: #001f3f;
        --navy-medium: #003366;
        --navy-light: #e6f0ff;
        --white: #ffffff;
        --success: #14c472;
        --danger: #dc3545;
        --border-radius: 12px;
        --shadow: 0 4px 20px rgba(0, 31, 63, 0.1);
        --shadow-hover: 0 8px 30px rgba(0, 31, 63, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .workorders-page-wrapper {
        background: linear-gradient(135deg, var(--navy-light) 0%, #f0f4ff 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Page Header */
    .page-header {
        background: var(--white);
        padding: 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 2rem;
        border: 1px solid rgba(0, 31, 63, 0.08);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--navy-dark), var(--navy-medium));
    }

    .page-title {
        color: var(--navy-dark);
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        text-align: center;
        position: relative;
        z-index: 2;
    }

    /* Success Alert */
    .success-alert-wrapper {
        margin-bottom: 2rem;
    }

    .success-alert {
        background: linear-gradient(135deg, var(--success), #28a745);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius);
        padding: 1.5rem 2rem;
        color: var(--white);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
        backdrop-filter: blur(10px);
    }

    .alert-icon {
        width: 48px;
        height: 48px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
    }

    .alert-icon i {
        font-size: 1.5rem;
    }

    .alert-content {
        flex: 1;
        font-weight: 500;
    }

    /* Empty State */
    .empty-state-wrapper {
        display: flex;
        justify-content: center;
        padding: 4rem 2rem;
    }

    .empty-state-card {
        background: var(--white);
        padding: 3rem 2rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        text-align: center;
        border: 1px solid rgba(0, 31, 63, 0.08);
        color: var(--navy-dark);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--navy-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--navy-dark);
        font-size: 2.5rem;
        box-shadow: 0 4px 15px rgba(0, 31, 63, 0.1);
    }

    .empty-state-card p {
        margin: 0;
        font-size: 1.1rem;
        color: var(--navy-medium);
        opacity: 0.8;
    }

    /* Table Container */
    .table-container {
        background: var(--white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid rgba(0, 31, 63, 0.08);
        margin-bottom: 2rem;
    }

    .table-wrapper {
        overflow: hidden;
    }

    .workorders-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .workorders-table thead tr {
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-medium));
    }

    .workorders-table thead th {
        color: var(--white);
        font-weight: 600;
        padding: 1.5rem 1.5rem;
        text-align: left;
        border: none;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .workorders-table thead th:first-child {
        border-top-left-radius: var(--border-radius);
    }

    .workorders-table thead th:last-child {
        border-top-right-radius: var(--border-radius);
    }

    .workorders-table tbody tr {
        background: var(--white);
        transition: var(--transition);
        border-bottom: 1px solid rgba(0, 31, 63, 0.05);
    }

    .workorders-table tbody tr:hover {
        background: linear-gradient(135deg, var(--navy-light), #f8fbff);
        transform: translateX(8px);
        box-shadow: var(--shadow-hover);
    }

    .workorders-table tbody td {
        padding: 1.5rem;
        vertical-align: middle;
        color: var(--navy-dark);
        border: none;
        position: relative;
    }

    .row-number {
        font-weight: 700;
        color: var(--navy-medium);
        width: 60px;
        text-align: center;
        font-size: 1.1rem;
    }

    .order-badge {
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-medium));
        color: var(--white);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        display: inline-block;
        box-shadow: 0 2px 10px rgba(0, 31, 63, 0.2);
    }

    .work-center {
        font-weight: 600;
        color: var(--navy-dark);
    }

    .location i {
        color: var(--navy-medium);
        margin-right: 0.75rem;
        width: 20px;
        opacity: 0.7;
    }

    .description {
        color: var(--navy-medium);
        font-size: 0.95rem;
        line-height: 1.5;
        max-width: 300px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: var(--transition);
        border: 1px solid transparent;
        color: var(--white);
        min-width: 80px;
        justify-content: center;
    }

    .btn-action.detail {
        background: linear-gradient(135deg, var(--navy-dark), var(--navy-medium));
        border-color: rgba(0, 31, 63, 0.2);
    }

    .btn-action.edit {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border-color: rgba(0, 123, 255, 0.2);
    }

    .btn-action.delete {
        background: linear-gradient(135deg, var(--danger), #c82333);
        border-color: rgba(220, 53, 69, 0.2);
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow);
        color: var(--white) !important;
        opacity: 0.9;
    }

    .delete-form {
        display: inline;
        margin: 0;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .table-responsive {
            border-radius: var(--border-radius);
            overflow: hidden;
        }
        
        .workorders-table thead {
            display: none;
        }
        
        .workorders-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            background: var(--white);
            border: 1px solid rgba(0, 31, 63, 0.08);
        }
        
        .workorders-table tbody td {
            display: block;
            padding: 1rem 1.5rem;
            border: none;
            position: relative;
            padding-left: 50%;
            text-align: right;
        }
        
        .workorders-table tbody td:before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: 45%;
            font-weight: 600;
            color: var(--navy-medium);
            text-align: left;
        }
        
        .action-buttons {
            justify-content: flex-start !important;
            padding-left: 50% !important;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }
        
        .success-alert {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .action-buttons {
            justify-content: center !important;
            padding-left: 0 !important;
        }
        
        .workorders-table tbody td {
            padding-left: 1rem;
        }
    }
</style>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
@endsection