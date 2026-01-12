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
        // Añadir rol a usuarios
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('asesor')->after('password');
        });

        // Vincular asesores con usuarios
        Schema::table('asesors', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
        });

        // Estado de las ventas para aprobación
        Schema::table('ventas', function (Blueprint $table) {
            $table->string('estado')->default('aprobada')->after('comision'); // 'pendiente', 'aprobada', 'rechazada'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });

        Schema::table('asesors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('ventas', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
