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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('accion')->comment('ej: Crear, Actualizar, Eliminar, Cambio Estado');
            $table->morphs('modelo_afectado'); // Crea modelo_afectado_id y modelo_afectado_type
            
            $table->text('valor_anterior')->nullable();
            $table->text('valor_nuevo')->nullable();
            
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
