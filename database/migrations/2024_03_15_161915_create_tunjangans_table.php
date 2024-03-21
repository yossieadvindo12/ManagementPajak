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
        Schema::create('tunjangans', function (Blueprint $table) {
            $table->integer('id_employee');
            $table->unsignedBigInteger('nik')->nullable();
            $table->unsignedBigInteger('npwp')->nullable();
            $table->integer('sc')->nullable();
            $table->integer('natura')->nullable();
            $table->integer('bpjs_kesehatan')->nullable();
            $table->integer('thr')->nullable();
            $table->integer('lain-lain')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tunjangans');
    }
};
