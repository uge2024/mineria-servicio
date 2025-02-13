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
        Schema::create('muestras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('boleta_id'); // Relación con la tabla boletas
            $table->text('caracteristicas_muestra')->nullable(); // Características de la muestra (opcional)
            $table->decimal('peso', 10, 2); // Peso de la muestra (hasta 99999999.99 kg)
            $table->string('municipio', 255); // Municipio
            $table->string('lugar_especifico', 255); // Lugar específico
            $table->enum('tipo_material', ['Brosa', 'Fina']); // Tipo de material (Brosa o Fina)
            $table->timestamps(); // Columnas created_at y updated_at

            // Clave foránea para relacionar con la tabla boletas
            $table->foreign('boleta_id')->references('id')->on('boletas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muestras');
    }
};
