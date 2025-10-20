<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Work Order {{ $workOrder->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; margin: 0; padding: 0; }
        h3, h4 { margin: 0; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 5px; }
        td, th { border: 1px solid #000; padding: 6px; font-size: 12px; vertical-align: top; }
        .no-border td { border: none; padding: 3px 0; }
        .section-title { background: #f2f2f2; font-weight: bold; padding: 4px; margin-top: 15px; }
        .page-break { page-break-after: always; }
        .logo { width: 100px; height: auto; }
        .signature-table th, .signature-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .materials-table th { background: #f2f2f2; font-weight: bold; }
    </style>
</head>
<body>

    <!-- HEADER LOGO + COMPANY NAME -->
    <table class="no-border">
        <tr>
            <td style="width: 110px;">
                <img src="{{ public_path('logo.png') }}" alt="Logo" class="logo">
            </td>
            <td>
                <br><br>
                <h3>PT. JEMBAYAN MUARABARA</h3>
            </td>
        </tr>
    </table>

    <!-- WORK ORDER INFO -->
    <table class="no-border">
        <tr><td><strong>Order Number:</strong> {{ $workOrder->order_number ?? '-' }}</td></tr>
        <tr><td><strong>Main Work Center:</strong> {{ $workOrder->main_work_center ?? '-' }}</td></tr>
        <tr><td><strong>Location:</strong> {{ $workOrder->lokasi ?? '-' }}</td></tr>
        <tr><td><strong>Date:</strong> {{ $workOrder->created_at ? $workOrder->created_at->format('d/m/Y') : '-' }}</td></tr>
        <tr><td><strong>Created By:</strong> {{ $workOrder->created_by ?? '-' }}</td></tr>
        <tr><td><strong>Work Order ID:</strong> {{ $workOrder->id_workorder ?? '-' }}</td></tr>
    </table>

    <!-- WORK ORDER DESCRIPTION -->
    <div class="section-title">Work Order Description</div>
    <p>{{ $workOrder->deskripsi ?? '-' }}</p>

    <!-- OPERATION -->
    <div class="section-title">Operation</div>
    <table>
        <tr>
            <th>Work Center</th>
        </tr>
        <tr>
            <td>{{ $workOrder->operation_center ?? '-' }}</td>
        </tr>
    </table>

    <!-- MATERIAL SUMMARY DI HALAMAN PERTAMA -->
    <div class="section-title">Material Summary</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Material No</th>
                <th>Material Name</th>
                <th>Quantity</th>
                <th>Unit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $index => $m)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $m['material_no'] ?? '-' }}</td>
                <td>{{ $m['nama_material'] ?? '-' }}</td>
                <td>{{ $m['quantity'] ?? '-' }}</td>
                <td>{{ $m['satuan'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- DURATION TABLE (DIBAWAH MATERIAL SUMMARY) -->
    <div class="section-title">Duration</div>
    <table class="duration-table" style="width:100%; border:1px solid #000; border-collapse: collapse; margin-top:5px;">
        <thead>
            <tr>
                <th style="border:1px solid #000; padding:5px;">Start</th>
                <th style="border:1px solid #000; padding:5px;">Finish</th>
                <th style="border:1px solid #000; padding:5px;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border:1px solid #000; height:25px;"></td>
                <td style="border:1px solid #000; height:25px;"></td>
                <td style="border:1px solid #000; height:25px;"></td>
            </tr>
        </tbody>
    </table>

    <!-- TABEL TANDA TANGAN -->
    <br>
    <table class="signature-table">
        <tr>
            <th colspan="2">Completion Checks</th>
        </tr>
        <tr>
            <td style="width:50%;">
                Completed By: ___________________<br><br>
                Date: ______________
            </td>
            <td style="width:50%;">
                Supervisor Sign Off: ___________________<br><br>
                Date: ______________
            </td>
        </tr>
    </table>

    <!-- PAGE BREAK UNTUK MATERIAL DETAIL -->
    <div class="page-break"></div>

    <!-- MATERIALS ORDERED DETAIL -->
    <table class="no-border">
        <tr>
            <td style="width: 110px;">
                <img src="{{ public_path('logo.png') }}" alt="Logo" class="logo">
            </td>
        </tr>
    </table>

    <div class="section-title">Work Order Description</div>
    <p>{{ $workOrder->deskripsi ?? '-' }}</p>

    <h4>Materials Ordered - Details</h4>
    <table class="materials-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Material Number</th>
                <th>Material</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Bin Location</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materials as $index => $m)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $m['material_no'] ?? '-' }}</td>
                <td>{{ $m['nama_material'] ?? '-' }}</td>
                <td>{{ $m['deskripsi_material'] ?? '-' }}</td>
                <td>{{ $m['quantity'] ?? '-' }}</td>
                <td>{{ $m['satuan'] ?? '-' }}</td>
                <td>{{ $m['lokasi_rak'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
