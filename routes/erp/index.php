<?php

use App\Livewire\Erp\Auditoria\AuditoriaCrear;
use App\Livewire\Erp\Auditoria\AuditoriaEditar;
use App\Livewire\Erp\Auditoria\AuditoriaLista;
use App\Livewire\Erp\Cargo\CargoCrear;
use App\Livewire\Erp\Cargo\CargoEditar;
use App\Livewire\Erp\Cargo\CargoLista;
use App\Livewire\Erp\CategoriaPregunta\CategoriaPreguntaCrear;
use App\Livewire\Erp\CategoriaPregunta\CategoriaPreguntaEditar;
use App\Livewire\Erp\CategoriaPregunta\CategoriaPreguntaLista;
use App\Livewire\Erp\Cliente\ClienteCrear;
use App\Livewire\Erp\Cliente\ClienteEditar;
use App\Livewire\Erp\Cliente\ClienteLista;
use App\Livewire\Erp\Empresa\EmpresaCrear;
use App\Livewire\Erp\Empresa\EmpresaEditar;
use App\Livewire\Erp\Empresa\EmpresaLista;
use App\Livewire\Erp\Especialidad\EspecialidadCrear;
use App\Livewire\Erp\Especialidad\EspecialidadEditar;
use App\Livewire\Erp\Especialidad\EspecialidadLista;
use App\Livewire\Erp\EstadoAuditoria\EstadoAuditoriaCrear;
use App\Livewire\Erp\EstadoAuditoria\EstadoAuditoriaEditar;
use App\Livewire\Erp\EstadoAuditoria\EstadoAuditoriaLista;
use App\Livewire\Erp\EstadoRespuesta\EstadoRespuestaCrear;
use App\Livewire\Erp\EstadoRespuesta\EstadoRespuestaEditar;
use App\Livewire\Erp\EstadoRespuesta\EstadoRespuestaLista;
use App\Livewire\Erp\ParticipanteAuditoria\ParticipanteAuditoriaCrear;
use App\Livewire\Erp\ParticipanteAuditoria\ParticipanteAuditoriaEditar;
use App\Livewire\Erp\ParticipanteAuditoria\ParticipanteAuditoriaLista;
use App\Livewire\Erp\Personal\PersonalCrear;
use App\Livewire\Erp\Personal\PersonalEditar;
use App\Livewire\Erp\Personal\PersonalLista;
use App\Livewire\Erp\Plantilla\PlantillaCrear;
use App\Livewire\Erp\Plantilla\PlantillaEditar;
use App\Livewire\Erp\Plantilla\PlantillaLista;
use App\Livewire\Erp\Pregunta\PreguntaCrear;
use App\Livewire\Erp\Pregunta\PreguntaEditar;
use App\Livewire\Erp\Pregunta\PreguntaLista;
use App\Livewire\Erp\TipoDocumentoEmpresa\TipoDocumentoEmpresaCrear;
use App\Livewire\Erp\TipoDocumentoEmpresa\TipoDocumentoEmpresaEditar;
use App\Livewire\Erp\TipoDocumentoEmpresa\TipoDocumentoEmpresaLista;
use App\Livewire\Erp\Trabajador\TrabajadorCrear;
use App\Livewire\Erp\Trabajador\TrabajadorEditar;
use App\Livewire\Erp\Trabajador\TrabajadorLista;
use Illuminate\Support\Facades\Route;

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

Route::prefix('personal')->name('personal.vista.')->group(function () {
    Route::get('/', PersonalLista::class)->name('lista');
    Route::get('/crear', PersonalCrear::class)->name('crear');
    Route::get('/editar/{id}', PersonalEditar::class)->name('editar');
});

Route::prefix('cargo')->name('cargo.vista.')->group(function () {
    Route::get('/', CargoLista::class)->name('lista');
    Route::get('/crear', CargoCrear::class)->name('crear');
    Route::get('/editar/{id}', CargoEditar::class)->name('editar');
});

Route::prefix('especialidad')->name('especialidad.vista.')->group(function () {
    Route::get('/', EspecialidadLista::class)->name('lista');
    Route::get('/crear', EspecialidadCrear::class)->name('crear');
    Route::get('/editar/{id}', EspecialidadEditar::class)->name('editar');
});

Route::prefix('trabajador')->name('trabajador.vista.')->group(function () {
    Route::get('/', TrabajadorLista::class)->name('lista');
    Route::get('/crear', TrabajadorCrear::class)->name('crear');
    Route::get('/editar/{id}', TrabajadorEditar::class)->name('editar');
});

Route::prefix('categoria-pregunta')->name('categoria-pregunta.vista.')->group(function () {
    Route::get('/', CategoriaPreguntaLista::class)->name('lista');
    Route::get('/crear', CategoriaPreguntaCrear::class)->name('crear');
    Route::get('/editar/{id}', CategoriaPreguntaEditar::class)->name('editar');
});

Route::prefix('pregunta')->name('pregunta.vista.')->group(function () {
    Route::get('/', PreguntaLista::class)->name('lista');
    Route::get('/crear', PreguntaCrear::class)->name('crear');
    Route::get('/editar/{id}', PreguntaEditar::class)->name('editar');
});

Route::prefix('plantilla')->name('plantilla.vista.')->group(function () {
    Route::get('/', PlantillaLista::class)->name('lista');
    Route::get('/crear', PlantillaCrear::class)->name('crear');
    Route::get('/editar/{id}', PlantillaEditar::class)->name('editar');
});

Route::prefix('estado-auditoria')->name('estado-auditoria.vista.')->group(function () {
    Route::get('/', EstadoAuditoriaLista::class)->name('lista');
    Route::get('/crear', EstadoAuditoriaCrear::class)->name('crear');
    Route::get('/editar/{id}', EstadoAuditoriaEditar::class)->name('editar');
});

Route::prefix('auditoria')->name('auditoria.vista.')->group(function () {
    Route::get('/', AuditoriaLista::class)->name('lista');
    Route::get('/crear', AuditoriaCrear::class)->name('crear');
    Route::get('/editar/{id}', AuditoriaEditar::class)->name('editar');
});

Route::prefix('participante-auditoria')->name('participante-auditoria.vista.')->group(function () {
    Route::get('/', ParticipanteAuditoriaLista::class)->name('lista');
    Route::get('/crear', ParticipanteAuditoriaCrear::class)->name('crear');
    Route::get('/editar/{id}', ParticipanteAuditoriaEditar::class)->name('editar');
});

Route::prefix('estado-respuesta')->name('estado-respuesta.vista.')->group(function () {
    Route::get('/', EstadoRespuestaLista::class)->name('lista');
    Route::get('/crear', EstadoRespuestaCrear::class)->name('crear');
    Route::get('/editar/{id}', EstadoRespuestaEditar::class)->name('editar');
});
