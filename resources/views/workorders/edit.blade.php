@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h3 class="mb-4 fw-bold text-primary">Edit Work Order</h3>

  @if(session('success'))
    <div class="alert alert-success">{!! session('success') !!}</div>
  @endif

  <form action="{{ route('workorders.update', $workorder->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- 1️⃣ ORDER INFORMATION -->
    <h5 class="mt-4 mb-3">1. Order Information</h5>
    <div class="row">
      <div class="col-md-3 mb-3">
        <label class="form-label">Order Number</label>
        <input type="text" name="order_number" class="form-control" value="{{ $workorder->order_number }}" placeholder="Enter order number manually">
      </div>
      <div class="col-md-3 mb-3">
        <label class="form-label">Date</label>
        <input type="text" class="form-control" value="{{ $workorder->created_at }}" readonly>
      </div>
      <div class="col-md-3 mb-3">
        <label class="form-label">Main Work Center</label>
        <input type="text" name="main_work_center" class="form-control" required value="{{ $workorder->main_work_center }}">
      </div>
      <div class="col-md-3 mb-3">
        <label class="form-label">Location</label>
       <input type="text" name="lokasi" class="form-control" value="{{ $workorder->lokasi }}">
      </div>
    </div>

    <!-- 2️⃣ WORK ORDER DESCRIPTION -->
    <h5 class="mt-4 mb-3">2. Work Order Description</h5>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Created By</label>
        <input type="text" id="creator_name" name="created_by" class="form-control" value="{{ $workorder->created_by }}" placeholder="Enter your name">
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Work Order ID (Auto)</label>
        <input type="text" id="id_workorder" name="id_workorder" class="form-control" value="{{ $workorder->id_workorder }}" readonly>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
     <textarea name="deskripsi" class="form-control">{{ $workorder->deskripsi }}</textarea>
    </div>

    <!-- 3️⃣ OPERATION -->
    <h5 class="mt-4 mb-3">3. Operation</h5>
    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Work Center</label>
        <input type="text" name="operation_center" class="form-control" value="{{ $workorder->operation_center }}">
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Duration</label>
       <input type="text" name="durasi" class="form-control" value="{{ $workorder->durasi }}">
      </div>
    </div>

    <!-- 4️⃣ MATERIAL ORDERED -->
    <h5 class="mt-4 mb-3">4. Material Ordered</h5>
    <div id="materials-wrapper">
      @php
        $materials = json_decode($workorder->materials, true) ?? [];
      @endphp

      @foreach($materials as $index => $material)
      <div class="material-item border rounded p-3 mb-3 bg-white position-relative">
        <div class="mb-2 position-relative">
          <label class="form-label">Material</label>
          <input type="text" class="form-control material-search" placeholder="Type material name..." autocomplete="off" value="[{{ $material['material_no'] }}] {{ $material['nama_material'] }}">
          <div class="list-group position-absolute w-50 material-list" style="z-index: 1000;"></div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <label class="form-label">Material No</label>
            <input type="text" name="materials[{{ $index }}][material_no]" class="form-control material-no" value="{{ $material['material_no'] ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label">Material Name</label>
            <input type="text" name="materials[{{ $index }}][nama_material]" class="form-control nama-material" value="{{ $material['nama_material'] ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label">Description</label>
            <input type="text" class="form-control deskripsi-material" value="{{ $material['nama_material'] ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="materials[{{ $index }}][quantity]" class="form-control qty" value="{{ $material['quantity'] ?? '' }}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-3 mb-3">
            <label class="form-label">Unit</label>
            <input type="text" name="materials[{{ $index }}][satuan]" class="form-control satuan" value="{{ $material['satuan'] ?? '' }}" readonly>
          </div>
          <div class="col-md-3 mb-3">
            <label class="form-label">Rack Location</label>
            <input type="text" name="materials[{{ $index }}][lokasi_rak]" class="form-control lokasi-rak" value="{{ $material['lokasi_rak'] ?? '' }}" readonly>
          </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-material" style="{{ $index == 0 ? 'display:none;' : '' }}">✖</button>
      </div>
      @endforeach
    </div>

    <button type="button" id="add-material" class="btn btn-secondary btn-sm mt-2">➕ Add Another Material</button>
    <button type="submit" class="btn btn-primary mt-3 float-end">💾 Update Work Order</button>
  </form>
</div>

<script>
// === AUTO ID UPDATE ===
document.getElementById('creator_name').addEventListener('input', function () {
  const name = this.value.trim().toUpperCase().replace(/\s+/g, '');
  const idInput = document.getElementById('id_workorder');
  if (name) {
    // Tetap gunakan tanggal asli, tapi bisa tambahkan nama baru
    const date = new Date();
    const formattedDate = date.getFullYear().toString() +
        ('0' + (date.getMonth() + 1)).slice(-2) +
        ('0' + date.getDate()).slice(-2);
    const formattedTime = ('0' + date.getHours()).slice(-2) +
        ('0' + date.getMinutes()).slice(-2);
    idInput.value = `WO-${formattedDate}-${formattedTime}-${name}`;
  }
});

// === DYNAMIC MATERIAL FIELDS ===
let materialIndex = {{ count($materials) - 1 }};
const wrapper = document.getElementById('materials-wrapper');
document.getElementById('add-material').addEventListener('click', () => {
  materialIndex++;
  const newItem = wrapper.firstElementChild.cloneNode(true);
  newItem.querySelectorAll('input').forEach(input => input.value = '');
  newItem.querySelectorAll('input').forEach(input => {
    const nameAttr = input.getAttribute('name');
    if (nameAttr) input.setAttribute('name', nameAttr.replace(/\[\d+\]/, `[${materialIndex}]`));
  });
  newItem.querySelector('.remove-material').style.display = 'block';
  wrapper.appendChild(newItem);
});

// === REMOVE MATERIAL ROW ===
wrapper.addEventListener('click', (e) => {
  if (e.target.classList.contains('remove-material')) {
    e.target.closest('.material-item').remove();
  }
});

// === AUTOCOMPLETE MATERIAL (LIVE SEARCH) ===
wrapper.addEventListener('keyup', async (e) => {
  if (!e.target.classList.contains('material-search')) return;
  const input = e.target;
  const list = input.nextElementSibling;
  const query = input.value.trim();
  list.innerHTML = '';
  if (query.length < 2) return;
  const response = await fetch(`/materials/search?term=${encodeURIComponent(query)}`);
  const results = await response.json();

  results.forEach(item => {
    const option = document.createElement('button');
    option.type = 'button';
    option.classList.add('list-group-item', 'list-group-item-action');
    option.textContent = `[${item.material_no}] ${item.nama_material}`;
    option.onclick = function () {
      const container = input.closest('.material-item');
      container.querySelector('.material-no').value = item.material_no;
      container.querySelector('.nama-material').value = item.nama_material;
      container.querySelector('.deskripsi-material').value = item.nama_material;
      container.querySelector('.satuan').value = item.satuan;
      container.querySelector('.lokasi-rak').value = item.lokasi_rak;
      input.value = `[${item.material_no}] ${item.nama_material}`;
      list.innerHTML = '';
    };
    list.appendChild(option);
  });
});
</script>
@endsection
