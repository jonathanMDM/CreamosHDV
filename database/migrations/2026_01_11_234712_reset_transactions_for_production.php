<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (config('database.default') === 'pgsql') {
            // Reiniciar para PostgreSQL (Heroku)
            DB::statement('TRUNCATE TABLE pagos, ventas RESTART IDENTITY CASCADE');
        } else {
            // Reiniciar para otros (MySQL/SQLite)
            Schema::disableForeignKeyConstraints();
            DB::table('pagos')->truncate();
            DB::table('ventas')->truncate();
            Schema::enableForeignKeyConstraints();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No se puede revertir un truncado de datos
    }
};
