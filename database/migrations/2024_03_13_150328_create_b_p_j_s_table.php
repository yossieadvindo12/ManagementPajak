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
        Schema::create('bpjs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nik');
            $table->integer('id_company');
            $table->integer('gaji_pokok');
            $table->integer('jht_karyawan')->nullable();
            $table->integer('jht_pt')->nullable();
            $table->integer('jkm')->nullable();
            $table->integer('jkk')->nullable();
            $table->integer('jp_karyawan')->nullable();
            $table->integer('jp_pt')->nullable();
            $table->integer('bpjs_kesehatan')->nullable();
            $table->integer('ditanggung_karyawan')->nullable();
            $table->integer('ditanggung_pt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_p_j_s');
    }
};
