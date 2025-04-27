<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gaji_talent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talent')->onDelete('cascade');
            $table->date('periode_gaji_awal');
            $table->date('periode_gaji_akhir');
            $table->integer('fee_live_perjam');
            $table->integer('fee_take_video_perjam');
            $table->float('total_lama_sesi_live', 8, 2)->nullable();
            $table->float('total_lama_sesi_take_video', 8, 2)->nullable();
            $table->decimal('fee_live_didapat', 10, 2)->nullable();
            $table->decimal('fee_take_video_didapat', 10, 2)->nullable();
            $table->decimal('fee_pervideo', 10, 2)->nullable();
            $table->integer('total_video')->nullable();
            $table->decimal('fee_pervideo_didapat', 10, 2)->nullable();
            $table->decimal('jumlah_total_omset', 10, 2)->nullable();
            $table->decimal('rate_omset_perjam', 10, 2)->nullable();
            $table->decimal('bonus', 10, 2)->nullable();
            $table->decimal('total_gaji', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_talent');
    }
};
