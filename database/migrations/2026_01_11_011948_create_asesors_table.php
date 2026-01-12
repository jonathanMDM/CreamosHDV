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
        Schema::create('asesors', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('cedula')->unique();
            $table->enum('banco', ['Nequi', 'Bancolombia', 'Daviplata', 'Nu', 'Otros']);
            $table->string('numero_cuenta');
            $table->string('whatsapp');
            $table->string('ciudad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesors');
    }
};
