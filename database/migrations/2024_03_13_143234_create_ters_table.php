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
        Schema::create('ter', function (Blueprint $table) {
            $table->id();
            $table->integer("min");
            $table->integer("max")->nullable();
            $table->float("presentase");
            $table->string("Ter");
            $table->string("Ter alias");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ters');
    }
};
