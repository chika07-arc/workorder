<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            
            // Info dasar
            $table->string('order_number')->nullable(); 
            $table->string('id_workorder')->unique();
            $table->dateTime('tanggal')->default(DB::raw('CURRENT_TIMESTAMP'));

            // Info lokasi & work center
            $table->string('main_work_center')->nullable();
            $table->string('operation_center')->nullable();
            $table->string('lokasi')->nullable();

            // Deskripsi pekerjaan
            $table->text('deskripsi')->nullable();
            $table->string('durasi')->nullable();

            // Info pembuat WO
            $table->string('name')->nullable();
            $table->string('created_by')->nullable();

            // Data material (JSON)
            $table->json('materials')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
