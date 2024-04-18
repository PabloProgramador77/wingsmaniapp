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
        Schema::create('paquete_has_bebidas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idPaquete')->unsigned();
            $table->bigInteger('idBebida')->unsigned();
            $table->timestamps();

            $table->foreign('idPaquete')->references('id')->on('paquetes')->onDelete('cascade');
            $table->foreign('idBebida')->references('id')->on('platillos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquete_has_bebidas');
    }
};
