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
        Schema::create('estado_auditorias', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('color')->nullable()->comment('Ej: #ff0000, primary, success');
            $table->text('descripcion')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_auditorias');
    }
};
