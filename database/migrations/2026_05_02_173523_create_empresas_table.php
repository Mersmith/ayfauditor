<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('tipo_documento_empresa_id')->constrained('tipo_documento_empresas')->onDelete('restrict');

            $table->string('razon_social');
            $table->string('nombre_comercial')->nullable();
            $table->string('numero_documento');
            $table->string('direccion_fiscal')->nullable();
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->string('escudo')->nullable();
            $table->boolean('activo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['numero_documento', 'deleted_at']);
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
