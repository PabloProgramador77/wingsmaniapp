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
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 10, 2)->unsigned();
            $table->string('descripcion')->nullable();
            $table->bigInteger('cantidadBebidas')->unsigned()->nullable();
            $table->bigInteger('cantidadSalsas')->unsigned()->nullable();
            $table->bigInteger('idCategoria')->unsigned();
            $table->timestamps();

            $table->foreign('idCategoria')->references('id')->on('categorias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
