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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('slug')->nullable()->unique()->comment('ej: dueno, colaborador, auditor-principal. Solo para cargos especiales de auditoría.');
            $table->string('tipo')->default('administrativo')->comment('administrativo, auditoria');
            $table->text('descripcion')->nullable();
            $table->string('color')->nullable();
            $table->string('icono')->nullable(); // fa-solid fa-gear
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};
