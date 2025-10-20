@extends('layouts.app')

@section('content')
<div class="workorder-create-wrapper">
    <div class="container py-5">
        <!-- Page Header -->
        <div class="page-header mb-5">
            <div class="header-content">
                <div class="header-icon">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <div>
                    <h1 class="page-title">Create New Work Order</h1>
                    <p class="page-subtitle">Fill in the details to create a new maintenance work order</p>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="success-alert-container">
                <div class="success-alert">
                    <div class="alert-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="alert-content">
                        {!! session('success') !!}
                        @if(session('workorder_id'))
                            <a href="{{ route('workorders.pdf', session('workorder_id')) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-print-pdf">
                                <i class="bi bi-file-earmark-pdf"></i>
                                Print PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('workorders.store') }}" method="POST" class="workorder-form">
            @csrf

            <!-- Progress Steps -->
            <div class="progress-steps">
                <div class="step active">
                    <div class="step-circle">1</div>
                    <span>Order Info</span>
                </div>
                <div class="step active">
                    <div class="step-circle">2</div>
                    <span>Description</span>
                </div>
                <div class="step active">
                    <div class="step-circle">3</div>
                    <span>Operation</span>
                </div>
                <div class="step">
                    <div class="step-circle">4</div>
                    <span>Materials</span>
                </div>
            </div>

            <!-- 1️⃣ ORDER INFORMATION -->
            <section class="form-section">
                <div class="section-header">
                    <h5 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        Order Information
                    </h5>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Order Number</label>
                            <input type="text" name="order_number" class="form-control" placeholder="Enter order number">
                            <div class="input-icon"><i class="bi bi-hash"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Date</label>
                            <input type="text" class="form-control" id="date" readonly>
                            <div class="input-icon"><i class="bi bi-calendar"></i></div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Main Work Center</label>
                            <select id="main_work_center" name="main_work_center" class="form-select" required>
                                <option value="" disabled selected>Select Main Work Center</option>
                                <option value="CPP Mechanic">CPP Mechanic</option>
                                <option value="CPP Electric">CPP Electric</option>
                                <option value="CPP Workshop">CPP Workshop</option>
                                <option value="CPP Welder">CPP Welder</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" required placeholder="e.g. Workshop Area">
                            <div class="input-icon"><i class="bi bi-geo-alt"></i></div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 2️⃣ WORK ORDER DESCRIPTION -->
            <section class="form-section">
                <div class="section-header">
                    <h5 class="section-title">
                        <i class="bi bi-file-earmark-text"></i>
                        Work Order Description
                    </h5>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label">Created By</label>
                            <input type="text" id="creator_name" name="created_by" class="form-control" placeholder="Enter your name">
                            <div class="input-icon"><i class="bi bi-person"></i></div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label">Work Order ID (Auto)</label>
                            <input type="text" id="id_workorder" name="id_workorder" class="form-control" readonly>
                            <div class="input-icon"><i class="bi bi-key"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Describe the work order..." required></textarea>
                    <div class="textarea-icon"><i class="bi bi-card-text"></i></div>
                </div>
            </section>

            <!-- 3️⃣ OPERATION -->
            <section class="form-section">
                <div class="section-header">
                    <h5 class="section-title">
                        <i class="bi bi-gear"></i>
                        Operation
                    </h5>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label class="form-label">Work Center</label>
                            <select id="work_center" name="operation_center" class="form-select" required>
                                <option value="" disabled selected>Select Work Center</option>
                                <option value="Mechanic">Mechanic</option>
                                <option value="Electric">Electric</option>
                                <option value="Welder">Welder</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4️⃣ MATERIAL ORDERED -->
            <section class="form-section">
                <div class="section-header">
                    <h5 class="section-title">
                        <i class="bi bi-box-seam"></i>
                        Material Ordered
                    </h5>
                </div>
                <div id="materials-wrapper">
                    <div class="material-item">
                        <div class="material-header">
                            <h6>Material #1</h6>
                            <button type="button" class="btn-remove-material" style="display:none;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div class="material-search-group">
                            <input type="text" class="form-control material-search" placeholder="Search material..." autocomplete="off">
                            <div class="search-icon"><i class="bi bi-search"></i></div>
                            <div class="material-list"></div>
                        </div>
                        <div class="material-details-grid">
                            <div class="form-group">
                                <label>Material No</label>
                                <input type="text" name="materials[0][material_no]" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Material Name</label>
                                <input type="text" name="materials[0][nama_material]" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" class="form-control deskripsi-material" readonly>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="number" name="materials[0][quantity]" class="form-control qty" placeholder="0">
                            </div>
                            <div class="form-group">
                                <label>Unit</label>
                                <input type="text" name="materials[0][satuan]" class="form-control" readonly>
                            </div>
                            <div class="form-group">
                                <label>Rack Location</label>
                                <input type="text" name="materials[0][lokasi_rak]" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-material" class="btn-add-material">
                    <i class="bi bi-plus-circle"></i>
                    Add Another Material
                </button>
            </section>

            <!-- Submit Button -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="bi bi-save"></i>
                    Save Work Order
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    :root {
        --navy-primary: #001f3f;
        --navy-secondary: #003366;
        --navy-accent: #004080;
        --navy-light: #e6f0ff;
        --white: #ffffff;
        --light-gray: #f8f9fa;
        --border-radius: 12px;
        --shadow: 0 8px 32px rgba(0, 31, 63, 0.08);
        --shadow-hover: 0 12px 40px rgba(0, 31, 63, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .workorder-create-wrapper {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    /* Page Header */
    .page-header {
        background: var(--white);
        padding: 2.5rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 31, 63, 0.05);
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        flex-shrink: 0;
    }

    .page-title {
        color: var(--navy-primary);
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .page-subtitle {
        color: var(--navy-accent);
        margin: 0;
        font-size: 1.1rem;
    }

    /* Progress Steps */
    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 3rem;
        padding: 1rem 0;
        position: relative;
    }

    .progress-steps::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, var(--navy-light), var(--navy-accent));
        z-index: 1;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .step-circle {
        width: 32px;
        height: 32px;
        background: var(--white);
        border: 2px solid var(--navy-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: var(--navy-accent);
        transition: var(--transition);
    }

    .step.active .step-circle {
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        color: var(--white);
        border-color: var(--navy-primary);
        box-shadow: 0 4px 15px rgba(0, 31, 63, 0.2);
    }

    .step span {
        font-size: 0.85rem;
        color: var(--navy-accent);
        font-weight: 500;
    }

    /* Form Sections */
    .form-section {
        background: var(--white);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        border: 1px solid rgba(0, 31, 63, 0.05);
        transition: var(--transition);
    }

    .form-section:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .section-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--navy-light);
    }

    .section-title {
        color: var(--navy-primary);
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-title i {
        color: var(--navy-accent);
        width: 24px;
    }

    /* Form Groups */
    .form-group {
        position: relative;
    }

    .form-label {
        color: var(--navy-primary);
        font-weight: 600;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .form-control, .form-select {
        border: 2px solid rgba(0, 31, 63, 0.1);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        background: #fafbfc;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--navy-primary);
        box-shadow: 0 0 0 0.2rem rgba(0, 31, 63, 0.1);
        background: var(--white);
        transform: translateY(-1px);
    }

    .input-icon, .textarea-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--navy-accent);
        pointer-events: none;
        z-index: 1;
    }

    .textarea-icon {
        top: 1rem;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    /* Material Section */
    .material-item {
        background: linear-gradient(135deg, #fdfdfd, #fafbfc);
        border: 2px dashed rgba(0, 31, 63, 0.1);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: var(--transition);
        position: relative;
    }

    .material-item:hover {
        border-color: var(--navy-accent);
        box-shadow: var(--shadow);
    }

    .material-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(0, 31, 63, 0.05);
    }

    .material-header h6 {
        color: var(--navy-primary);
        font-weight: 600;
        margin: 0;
    }

    .btn-remove-material {
        background: var(--danger);
        color: var(--white);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .material-search-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .material-search-group .search-icon {
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .material-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--white);
        border: 1px solid rgba(0, 31, 63, 0.1);
        border-radius: 8px;
        max-height: 200px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: var(--shadow);
        display: none;
    }

    .material-list.show {
        display: block;
    }

    .material-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .btn-add-material {
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        color: var(--white);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0, 31, 63, 0.2);
    }

    .btn-add-material:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    /* Success Alert */
    .success-alert-container {
        margin-bottom: 2rem;
    }

    .success-alert {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border: 1px solid #28a745;
        border-radius: var(--border-radius);
        padding: 1.5rem;
        color: var(--navy-primary);
        box-shadow: var(--shadow);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-icon {
        width: 48px;
        height: 48px;
        background: #28a745;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        flex-shrink: 0;
    }

    .btn-print-pdf {
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        color: var(--white);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        margin-top: 0.5rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Submit Button */
    .form-actions {
        text-align: right;
        padding-top: 2rem;
        border-top: 1px solid rgba(0, 31, 63, 0.05);
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--navy-primary), var(--navy-secondary));
        color: var(--white);
        border: none;
        padding: 1rem 2rem;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0, 31, 63, 0.2);
        cursor: pointer;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-hover);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .progress-steps {
            overflow-x: auto;
            padding: 1rem;
        }
        
        .header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .material-details-grid {
            grid-template-columns: 1fr;
        }
        
        .form-section {
            padding: 1.5rem;
        }
    }
</style>

@push('scripts')
<script>
document.getElementById('date').value = new Date().toISOString().slice(0,16).replace('T', ' ');

document.getElementById('creator_name').addEventListener('input', function () {
    const name = this.value.trim().toUpperCase().replace(/\s+/g, '');
    const date = new Date();
    const formattedDate = date.getFullYear().toString() +
        ('0' + (date.getMonth() + 1)).slice(-2) +
        ('0' + date.getDate()).slice(-2);
    const formattedTime = ('0' + date.getHours()).slice(-2) +
        ('0' + date.getMinutes()).slice(-2);
    const id = name ? `WO-${formattedDate}-${formattedTime}-${name}` : '';
    document.getElementById('id_workorder').value = id;
});

$(document).ready(function () { 
    $('#main_work_center').select2({ placeholder: "Select Main Work Center", allowClear: true }); 
    $('#work_center').select2({ placeholder: "Select Work Center", allowClear: true }); 
});

// Dynamic material fields
let materialIndex = 0;
const wrapper = document.getElementById('materials-wrapper');
document.getElementById('add-material').addEventListener('click', () => {
    materialIndex++;
    const newItem = wrapper.firstElementChild.cloneNode(true);
    newItem.querySelectorAll('input').forEach(input => {
        input.value = '';
        const nameAttr = input.getAttribute('name');
        if (nameAttr) input.setAttribute('name', nameAttr.replace(/\[\d+\]/, `[${materialIndex}]`));
    });
    newItem.querySelector('.btn-remove-material').style.display = 'flex';
    newItem.querySelector('h6').textContent = `Material #${materialIndex + 1}`;
    wrapper.appendChild(newItem);
});

wrapper.addEventListener('click', (e) => {
    if (e.target.closest('.btn-remove-material')) {
        e.target.closest('.material-item').remove();
    }
});

// Material autocomplete
wrapper.addEventListener('keyup', async (e) => {
    if (!e.target.classList.contains('material-search')) return;
    const input = e.target;
    const list = input.parentElement.querySelector('.material-list');
    const query = input.value.trim();
    list.innerHTML = '';
    list.classList.remove('show');
    if (query.length < 2) return;
    
    const response = await fetch(`/materials/search?term=${encodeURIComponent(query)}`);
    const results = await response.json();
    results.forEach(item => {
        const option = document.createElement('button');
        option.type = 'button';
        option.className = 'list-group-item list-group-item-action';
        option.innerHTML = `<strong>[${item.material_no}]</strong> ${item.nama_material}`;
        option.onclick = function () {
            const container = input.closest('.material-item');
            container.querySelector('[name*="material_no"]').value = item.material_no;
            container.querySelector('[name*="nama_material"]').value = item.nama_material;
            container.querySelector('.deskripsi-material').value = item.nama_material;
            container.querySelector('[name*="satuan"]').value = item.satuan;
            container.querySelector('[name*="lokasi_rak"]').value = item.lokasi_rak;
            input.value = `[${item.material_no}] ${item.nama_material}`;
            list.innerHTML = '';
            list.classList.remove('show');
        };
        list.appendChild(option);
    });
    if (results.length > 0) list.classList.add('show');
});

document.addEventListener('click', (e) => {
    const lists = document.querySelectorAll('.material-list');
    lists.forEach(list => {
        if (!list.closest('.material-search-group').contains(e.target)) {
            list.classList.remove('show');
        }
    });
});
</script>
@endpush