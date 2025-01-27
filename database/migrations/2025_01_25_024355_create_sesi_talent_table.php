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
        Schema::create('sesi_talent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talent')->onDelete('cascade');
            $table->enum('jenis_sesi', ['take_video', 'live']);
            $table->timestamp('tanggal_waktu_mulai');
            $table->timestamp('tanggal_waktu_selesai')->nullable();
            $table->float('lama_sesi', 8, 2)->nullable();
            $table->decimal('total_omset', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_talent');
    }
};
