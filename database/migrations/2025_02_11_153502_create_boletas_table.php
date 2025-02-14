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
        Schema::create('boletas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained()->onDelete('cascade');
            $table->string('nombre_solicitante');
            $table->string('ci');
            $table->string('sector');
            $table->date('fecha_solicitud');
            $table->string('numero_contrato');
            $table->string('numero_solicitud')->unique(); // Campo para el número de solicitud
            //$table->text('caracteristicas_muestra');
            //$table->string('peso');
            //$table->string('municipio');
            //$table->string('lugar_especifico');
            //$table->enum('tipo_material', ['Brosa', 'Fina']);
            $table->string('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       

        // Desactivar restricciones de clave foránea
    Schema::disableForeignKeyConstraints();

    // Eliminar la tabla
    Schema::dropIfExists('boletas');

    // Reactivar restricciones de clave foránea
    Schema::enableForeignKeyConstraints();
    }
};
