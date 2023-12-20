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
        Schema::create('cliente_has_domicilios', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idCliente')->unsigned();
            $table->bigInteger('idDomicilio')->unsigned();
            $table->timestamps();

            $table->foreign('idCliente')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('idDomicilio')->references('id')->on('domicilios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_has_domicilios');
    }
};
