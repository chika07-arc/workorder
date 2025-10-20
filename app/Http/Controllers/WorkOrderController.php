<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkOrder;
use App\Models\Material;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class WorkOrderController extends Controller
{
    /**
     * Show the Work Order form.
     */

public function index(Request $request)
{
    $query = WorkOrder::query();

    // Cek apakah ada input pencarian
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('order_number', 'like', "%{$search}%")
              ->orWhere('main_work_center', 'like', "%{$search}%")
              ->orWhere('lokasi', 'like', "%{$search}%")
              ->orWhere('deskripsi', 'like', "%{$search}%")
              ->orWhere('created_by', 'like', "%{$search}%");
        });
    }

    $workorders = $query->latest()->get();

    return view('workorders.index', compact('workorders'));
}


public function show($id)
{
    $workorder = \App\Models\WorkOrder::findOrFail($id);
    return view('workorders.show', compact('workorder'));
}




    public function create()
    {
        return view('workorders.create');
    }

    /**
     * Store new Work Order data.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'created_by'         => 'required|string|max:255',
            'order_number'        => 'nullable|string|max:255',
            'main_work_center'    => 'required|string|max:255',
            'location'            => 'required|string|max:255',
            'description'         => 'required|string',
            'operation_center'    => 'nullable|string|max:255',
            'duration'            => 'nullable|string|max:100',
            'materials'           => 'nullable|array',
            'materials.*.material_no'   => 'nullable|string|max:255',
            'materials.*.nama_material' => 'nullable|string|max:255',
            'materials.*.quantity'      => 'nullable|numeric',
            'materials.*.satuan'        => 'nullable|string|max:50',
            'materials.*.lokasi'        => 'nullable|string|max:255',
            'materials.*.lokasi_rak'    => 'nullable|string|max:255',
        ]);

       // Ambil nama dari form
             $creator = $validated['created_by'];

            // Generate ID Work Order berdasarkan input nama
            $validated['id_workorder'] = 'WO-' . now()->format('Ymd_His') . '-' . Str::upper(Str::slug($creator, ''));

        // Save to DB
        $workOrder = WorkOrder::create([
            'name'              => $creator,
            'order_number'      => $validated['order_number'] ?? null,
            'main_work_center'  => $validated['main_work_center'],
            'lokasi'            => $validated['location'],
            'id_workorder'      => $validated['id_workorder'],
            'created_by'        => $creator,
            'deskripsi'         => $validated['description'],
            'operation_center'  => $validated['operation_center'] ?? null,
            'durasi'            => $validated['duration'] ?? null,
            'materials'         => json_encode($validated['materials'] ?? []),
        ]);

       return redirect()
    ->route('workorders.index')
    ->with('success', 'Work Order berhasil disimpan!');
}

    /**
     * Search materials (AJAX for autocomplete)
     */
    public function searchMaterial(Request $request)
    {
        $term = $request->get('term', '');

        $materials = Material::query()
            ->where('nama_material', 'LIKE', "%{$term}%")
            ->orWhere('material_no', 'LIKE', "%{$term}%")
            ->limit(10)
            ->get(['id', 'material_no', 'nama_material', 'satuan', 'lokasi', 'lokasi_rak']);

        return response()->json($materials);
    }

    public function exportPDF($id)
{
    $workOrder = WorkOrder::findOrFail($id);
    $materials = json_decode($workOrder->materials, true) ?? [];

    $pdf = Pdf::loadView('workorders.pdf', compact('workOrder', 'materials'))
        ->setPaper('A4', 'portrait');

    return $pdf->stream('WorkOrder_' . $workOrder->id_workorder . '.pdf');
}

public function edit($id)
{
    $workorder = WorkOrder::findOrFail($id);
    return view('workorders.edit', compact('workorder'));
}

public function update(Request $request, $id)
{
    $workorder = WorkOrder::findOrFail($id);
    $validated = $request->validate([
        'order_number' => 'nullable|string|max:255',
        'main_work_center' => 'required|string|max:255',
        'lokasi' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'operation_center' => 'nullable|string|max:255',
        'durasi' => 'nullable|string|max:100',
        'created_by' => 'nullable|string|max:255',
        'materials' => 'nullable|array',
    ]);

    $workorder->update([
        'order_number' => $validated['order_number'] ?? $workorder->order_number,
        'main_work_center' => $validated['main_work_center'],
        'lokasi' => $validated['lokasi'],
        'deskripsi' => $validated['deskripsi'],
        'operation_center' => $validated['operation_center'] ?? $workorder->operation_center,
        'durasi' => $validated['durasi'] ?? $workorder->durasi,
        'created_by' => $validated['created_by'] ?? $workorder->created_by,
        'materials' => json_encode($validated['materials'] ?? json_decode($workorder->materials, true)),
    ]);

    return redirect()->route('workorders.index')->with('success', 'Work Order berhasil diperbarui!');
}

public function destroy($id)
{
    $workorder = WorkOrder::findOrFail($id);
    $workorder->delete();
    return redirect()->route('workorders.index')->with('success', 'Work Order berhasil dihapus!');
}


}
