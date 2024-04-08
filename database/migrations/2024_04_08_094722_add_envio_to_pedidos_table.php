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
        Schema::table('pedidos', function (Blueprint $table) {
            $table->bigInteger('idEnvio')->unsigned()->nullable()->after('idCliente');

            $table->foreign('idEnvio')->references('id')->on('envios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
           $table->dropForeign(['idEnvio']);
           $table->dropColumn('idEnvio'); 
        });
    }
};
