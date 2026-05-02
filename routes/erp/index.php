<?php

use App\Livewire\Erp\Cliente\ClienteCrear;
use App\Livewire\Erp\Cliente\ClienteEditar;
use App\Livewire\Erp\Cliente\ClienteLista;
use App\Livewire\Erp\TipoDocumentoEmpresa\TipoDocumentoEmpresaCrear;
use App\Livewire\Erp\TipoDocumentoEmpresa\TipoDocumentoEmpresaEditar;
use App\Livewire\Erp\TipoDocumentoEmpresa\TipoDocumentoEmpresaLista;
use Illuminate\Support\Facades\Route;
use App\Livewire\Erp\Empresa\EmpresaCrear;
use App\Livewire\Erp\Empresa\EmpresaEditar;
use App\Livewire\Erp\Empresa\EmpresaLista;

Route::prefix('cliente')->name('cliente.vista.')->group(function () {
    Route::get('/', ClienteLista::class)->name('lista');
    Route::get('/crear', ClienteCrear::class)->name('crear');
    Route::get('/editar/{id}', ClienteEditar::class)->name('editar');
});

Route::prefix('tipo-documento-empresa')->name('tipo-documento-empresa.vista.')->group(function () {
    Route::get('/', TipoDocumentoEmpresaLista::class)->name('lista');
    Route::get('/crear', TipoDocumentoEmpresaCrear::class)->name('crear');
    Route::get('/editar/{id}', TipoDocumentoEmpresaEditar::class)->name('editar');
});

Route::prefix('empresa')->name('empresa.vista.')->group(function () {
    Route::get('/', EmpresaLista::class)->name('lista');
    Route::get('/crear', EmpresaCrear::class)->name('crear');
    Route::get('/editar/{id}', EmpresaEditar::class)->name('editar');
});