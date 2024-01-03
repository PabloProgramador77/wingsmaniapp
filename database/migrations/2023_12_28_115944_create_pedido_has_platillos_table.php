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
        Schema::create('pedido_has_platillos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idPedido')->unsigned();
            $table->bigInteger('idPlatillo')->unsigned();
            $table->timestamps();

            $table->foreign('idPedido')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('idPlatillo')->references('id')->on('platillos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_has_platillos');
    }
};
