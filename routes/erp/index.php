<?php

use App\Livewire\Erp\Cliente\ClienteCrear;
use App\Livewire\Erp\Cliente\ClienteEditar;
use App\Livewire\Erp\Cliente\ClienteLista;
use Illuminate\Support\Facades\Route;

Route::prefix('cliente')->name('cliente.vista.')->group(function () {
    Route::get('/', ClienteLista::class)->name('lista');
    Route::get('/crear', ClienteCrear::class)->name('crear');
    Route::get('/editar/{id}', ClienteEditar::class)->name('editar');
});