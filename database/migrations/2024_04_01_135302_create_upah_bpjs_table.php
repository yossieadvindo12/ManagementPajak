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
        Schema::create('upah_bpjs', function (Blueprint $table) {
            $table->integer('id_employee');
            $table->unsignedBigInteger('nik')->nullable();
            $table->unsignedBigInteger('npwp')->nullable();
            $table->integer('upah_bpjs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upah_bpjs');
    }
};
