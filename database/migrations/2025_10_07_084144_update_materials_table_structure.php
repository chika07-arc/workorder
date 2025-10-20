<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->string('material_no')->nullable()->after('id');
            $table->string('nama_material')->nullable()->after('material_no');
            $table->string('deskripsi')->nullable()->after('nama_material');
            $table->string('satuan')->nullable()->after('deskripsi');
            $table->string('lokasi_rak')->nullable()->after('satuan');
            $table->string('lokasi')->nullable()->after('lokasi_rak');
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['material_no', 'nama_material', 'deskripsi', 'satuan', 'lokasi_rak', 'lokasi']);
            
            // Tambahkan balik kolom lama kalau rollback
            $table->string('location')->nullable();
            $table->string('bin_loc')->nullable();
            $table->string('product')->nullable();
            $table->string('unit_of_measure')->nullable();
        });
    }
};

