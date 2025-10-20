<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;

class MaterialUsageController extends Controller
{
    public function index(Request $request)
    {
        $usages = [];

        // 🔹 Ambil bulan dari request (contoh ?month=10)
        $month = $request->get('month');
        $search = $request->get('search');

        // Ambil semua WO yang punya materials
        $workOrders = WorkOrder::whereNotNull('materials');

        // 🔹 Filter berdasarkan bulan kalau dipilih
        if ($month) {
            $workOrders->whereMonth('created_at', $month);
        }

        $workOrders = $workOrders->get();

        foreach ($workOrders as $wo) {
            $materials = json_decode($wo->materials, true);

            if (is_array($materials)) {
                foreach ($materials as $m) {
                    $materialNo = $m['material_no'] ?? '-';
                    if (!isset($usages[$materialNo])) {
                        $usages[$materialNo] = [
                            'material_no' => $materialNo,
                            'nama_material' => $m['nama_material'] ?? '-',
                            'deskripsi' => $m['deskripsi'] ?? '-',
                            'quantity' => 0,
                            'work_orders' => [],
                        ];
                    }

                    $usages[$materialNo]['quantity'] += (float)($m['quantity'] ?? 0);
                    $usages[$materialNo]['work_orders'][] = $wo->id;
                }
            }
        }

        // Ubah associative array ke indexed array
        $usages = array_values($usages);

        // 🔍 Filter search
        if ($search) {
            $usages = array_filter($usages, function ($item) use ($search) {
                $s = strtolower($search);
                return str_contains(strtolower($item['material_no']), $s)
                    || str_contains(strtolower($item['nama_material']), $s)
                    || str_contains(strtolower($item['deskripsi']), $s);
            });
        }

        // Kirim data usages dan month ke view
        return view('pemakaian-material.index', compact('usages', 'month'));
    }

    public function detail($material_no)
    {
        $detailUsages = [];

        // Ambil semua WO yang punya materials
        $workOrders = WorkOrder::whereNotNull('materials')->get();

        foreach ($workOrders as $wo) {
            $materials = json_decode($wo->materials, true);

            if (is_array($materials)) {
                foreach ($materials as $m) {
                    if (($m['material_no'] ?? '-') == $material_no) {
                        $detailUsages[] = [
                            'work_order_id' => $wo->id,
                            'order_number' => $wo->order_number,
                            'tanggal' => $wo->created_at ?? $wo->tanggal ?? now(),
                            'nama_material' => $m['nama_material'] ?? '-',
                            'deskripsi' => $m['deskripsi'] ?? '-',
                            'quantity' => $m['quantity'] ?? 0,
                        ];
                    }
                }
            }
        }

        // Ambil informasi umum dari salah satu WO (buat judul)
        $materialInfo = !empty($detailUsages) ? $detailUsages[0] : [
            'nama_material' => '-',
            'deskripsi' => '-',
        ];

        return view('pemakaian-material.detail', compact('detailUsages', 'material_no', 'materialInfo'));
    }
}
