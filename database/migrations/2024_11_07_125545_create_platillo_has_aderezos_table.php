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
        Schema::create('platillo_has_aderezos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idPlatillo')->unsigned();
            $table->bigInteger('idAderezo')->unsigned();
            $table->timestamps();

            $table->foreign('idPlatillo')->references('id')->on('platillos')->onDelete('cascade');
            $table->foreign('idAderezo')->references('id')->on('aderezos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platillo_has_aderezos');
    }
};
