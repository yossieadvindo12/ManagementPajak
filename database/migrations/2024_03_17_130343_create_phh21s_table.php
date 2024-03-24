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
        Schema::create('phh21s', function (Blueprint $table) {
            $table->id();
            $table->integer('id_employee');
            $table->unsignedBigInteger('nik')->nullable();
            $table->unsignedBigInteger('npwp')->nullable();
            $table->integer('id_company');
            $table->integer('gaji_pokok');
            $table->integer('A5')->nullable();
            $table->integer('sc')->nullable();
            $table->integer('natura')->nullable();
            $table->integer('thr')->nullable();
            $table->integer('lain_lain')->nullable();
            $table->integer('gaji_bruto');
            $table->string("Ter alias");
            $table->integer('pph21');
            $table->integer('thp');
            $table->integer('gross_up');
            $table->string('keterangan_pph');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phh21s');
    }
};
