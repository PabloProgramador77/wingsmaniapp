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
        Schema::create('platillo_has_salsas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idPlatillo')->unsigned();
            $table->bigInteger('idSalsa')->unsigned();
            $table->timestamps();

            $table->foreign('idPlatillo')->references('id')->on('platillos')->onDelete('cascade');
            $table->foreign('idSalsa')->references('id')->on('salsas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platillo_has_salsas');
    }
};
