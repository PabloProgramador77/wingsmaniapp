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
        Schema::create('pedido_has_paquetes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idPedido')->unsigned();
            $table->bigInteger('idPaquete')->unsigned();
            $table->bigInteger('cantidad')->unsigned();
            $table->string('preparacion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_has_paquetes');
    }
};
