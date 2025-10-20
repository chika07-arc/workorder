<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MaterialsImport;

class MaterialImportController extends Controller
{
    public function showForm()
    {
        return view('import-material');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new MaterialsImport, $request->file('file'));

        return back()->with('success', 'Data material berhasil diimport!');
    }
}
