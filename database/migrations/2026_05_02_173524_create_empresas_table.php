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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            $table->string('razon_social');
            $table->string('nombre_comercial')->nullable();
            $table->string('tax_id')->comment('RUC/NIT/RFC - Único');
            $table->text('direccion_fiscal')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['tax_id', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
