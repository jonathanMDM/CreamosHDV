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
            $table->integer('semana')->nullable()->change();
            $table->date('fecha_inicio_semana')->nullable()->change();
            $table->date('fecha_fin_semana')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {
            $table->integer('semana')->nullable(false)->change();
            $table->date('fecha_inicio_semana')->nullable(false)->change();
            $table->date('fecha_fin_semana')->nullable(false)->change();
        });
    }
};
