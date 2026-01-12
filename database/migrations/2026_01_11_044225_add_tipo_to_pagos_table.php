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
        Schema::table('pagos', function (Blueprint $table) {
            // 'semanal' para el pago base de cada domingo
            // 'mensual' para el bono de comisiones del final del mes
            $table->string('tipo')->default('semanal')->after('asesor_id');
            $table->integer('mes')->nullable()->after('año');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->dropColumn(['tipo', 'mes']);
        });
    }
};
