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
        Schema::create('datos_envios', function (Blueprint $table) {
            $table->id();
            $table->string('calle');
            $table->string('poblacion');
            $table->integer('cpostal');
            $table->string('info_adicional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_envios');
    }
};
