<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'created_by',
    'order_number',
    'tanggal',
    'main_work_center',
    'lokasi',
    'id_workorder',
    'deskripsi',
    'operation_center',
    'durasi',
    'materials',
];


    protected $casts = [
        'materials' => 'array', // otomatis ubah JSON ke array
        'tanggal' => 'datetime',
    ];
}
