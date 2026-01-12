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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asesor_id')->constrained('asesors')->onDelete('cascade');
            $table->integer('semana'); // Número de semana del año (1-52)
            $table->integer('año');
            $table->date('fecha_inicio_semana');
            $table->date('fecha_fin_semana');
            $table->decimal('total_comisiones', 10, 2);
            $table->decimal('bonificacion', 10, 2)->default(0); // 5% si tiene 10+ ventas
            $table->decimal('total_pagar', 10, 2);
            $table->integer('cantidad_ventas');
            $table->boolean('pagado')->default(false);
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
