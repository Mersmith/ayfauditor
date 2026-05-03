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
        Schema::create('participante_auditorias', function (Blueprint $table) {
            $table->id();

            $table->foreignId('auditoria_id')->constrained('auditorias')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->foreignId('rol_auditoria_id')->constrained('rol_auditorias');
            $table->foreignId('invitado_por')->nullable()->constrained('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participante_auditorias');
    }
};
