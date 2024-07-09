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
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->string('NIS');
            $table->string('nama_santri');
            $table->string('slug');
            $table->string('sakit');
            $table->string('izin');
            $table->string('tanpa_keterangan');
            $table->string('kelas_id');
            $table->text('catatan_walkel');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
