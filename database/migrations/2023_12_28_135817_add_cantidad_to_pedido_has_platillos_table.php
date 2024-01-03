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
        Schema::table('pedido_has_platillos', function (Blueprint $table) {
            $table->bigInteger('cantidad')->unsigned()->after('idPlatillo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedido_has_platillos', function (Blueprint $table) {
            $table->dropColumn('cantidad');
        });
    }
};
