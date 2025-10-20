<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MaterialsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $product = $row['product'] ?? '';
        $material_no = null;
        $nama_material = null;

        if (preg_match('/\[(.*?)\]\s*(.*)/', $product, $matches)) {
            $material_no = $matches[1];
            $nama_material = $matches[2];
        }

        return new Material([
            'material_no'   => $material_no,
            'nama_material' => $nama_material,
            'deskripsi'     => $nama_material,
            'satuan'        => $row['unit_of_measure'] 
                               ?? $row['unit_of_measure_'] 
                               ?? null,
            'lokasi_rak'    => $row['bin_loc'] 
                               ?? $row['bin_loc_'] 
                               ?? null,
            'lokasi'        => $row['location'] ?? null,
        ]);
    }
}
