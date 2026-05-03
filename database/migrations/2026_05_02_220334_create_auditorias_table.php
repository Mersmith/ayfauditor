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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('plantilla_id')->nullable()->constrained('plantillas')->onDelete('set null');

            $table->string('titulo');
            $table->foreignId('estado_auditoria_id')->constrained('estado_auditorias');
            
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
