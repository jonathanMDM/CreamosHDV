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
        Schema::table('asesors', function (Blueprint $table) {
            $table->string('banco_nombre_otro')->nullable()->after('banco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asesors', function (Blueprint $table) {
            $table->dropColumn('banco_nombre_otro');
        });
    }
};
