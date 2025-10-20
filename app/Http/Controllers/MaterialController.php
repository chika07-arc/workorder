<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        // Cari material berdasarkan nama yang mirip (LIKE)
        $materials = Material::where('name', 'LIKE', "%{$query}%")
            ->take(10)
            ->get(['id', 'name', 'material_number', 'description', 'unit', 'location']);

        return response()->json($materials);
    }
}
