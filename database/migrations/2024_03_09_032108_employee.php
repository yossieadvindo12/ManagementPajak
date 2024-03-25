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
        Schema::create('Employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nik')->nullable();
            $table->unsignedBigInteger('npwp')->nullable();
            $table->string('nama')->nullable();
            $table->string('tempat')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->string('alamat')->nullable();
            $table->boolean('is_active');
            $table->string('status_PTKP');
            $table->enum('kode_karyawan', ['karyawan', 'tukang']);
            $table->integer('id_company')->references('id_company')->on('company')->restrictOnDelete();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Employee');
    }
};
