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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->integer('tugas_1');
            $table->integer('tugas_2');
            $table->integer('tugas_3');
            $table->integer('UTS');
            $table->integer('UAS');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('mapel_id')->nullable();
            $table->timestamps();

            $table->foreign('mapel_id')->references('id')->on('mapels');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
