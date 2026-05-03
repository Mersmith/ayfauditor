<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, eliminarAuditoriaOn" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar Auditoría <code>#{{ $auditoria->id }}</code></h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.auditoria.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarAuditoria()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="update" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel">
                    <div class="g_margin_bottom_15">
                        <label for="titulo">
                            Título de la Auditoría <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                        </label>
                        <input type="text" id="titulo" wire:model.blur="titulo"
                            class="@error('titulo') input-error @enderror">
                        @error('titulo')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_15 g_columna_6">
                            <label for="empresa_id">
                                Empresa Cliente <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="empresa_id" wire:model.blur="empresa_id"
                                class="@error('empresa_id') input-error @enderror">
                                @foreach($empresas as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->razon_social }}</option>
                                @endforeach
                            </select>
                            @error('empresa_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_15 g_columna_6">
                            <label for="plantilla_id">
                                Plantilla de Cuestionario <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="plantilla_id" wire:model.blur="plantilla_id"
                                class="@error('plantilla_id') input-error @enderror">
                                @foreach($plantillas as $pla)
                                    <option value="{{ $pla->id }}">{{ $pla->nombre }}</option>
                                @endforeach
                            </select>
                            @error('plantilla_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_15 g_columna_4">
                            <label for="estado_auditoria_id">Estado Actual</label>
                            <select id="estado_auditoria_id" wire:model.blur="estado_auditoria_id">
                                @foreach($estados as $est)
                                    <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="g_margin_bottom_15 g_columna_4">
                            <label for="fecha_inicio">Fecha Inicio</label>
                            <input type="date" id="fecha_inicio" wire:model.blur="fecha_inicio">
                            @error('fecha_inicio')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_15 g_columna_4">
                            <label for="fecha_fin">Fecha Fin (Estimada)</label>
                            <input type="date" id="fecha_fin" wire:model.blur="fecha_fin">
                            @error('fecha_fin')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="formulario_botones">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="update">
                            <span wire:loading.remove wire:target="update">
                                <i class="fa-solid fa-save"></i> Guardar Cambios
                            </span>
                            <span wire:loading wire:target="update">
                                <i class="fa-solid fa-spinner fa-spin"></i> Actualizando...
                            </span>
                        </button>

                        <button type="button" class="g_boton cancelar" onclick="history.back()">
                            <i class="fa-solid fa-times"></i> Cancelar
                        </button>
                    </div>
                </div>
            </div>

            <div class="g_columna_4">
                <div class="g_panel">
                    <h3>Estado de la Auditoría</h3>
                    @if($auditoria->estado)
                        <div style="background-color: {{ $auditoria->estado->color }}; color: white; padding: 15px; border-radius: 8px; display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                            <i class="{{ $auditoria->estado->icono }} fa-2x"></i>
                            <div>
                                <div style="font-weight: 700; font-size: 1.1rem;">{{ $auditoria->estado->nombre }}</div>
                                <div style="font-size: 0.85rem; opacity: 0.9;">{{ $auditoria->estado->descripcion ?: 'Sin descripción.' }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="g_alert info">
                        <i class="fa-solid fa-info-circle"></i> Los cambios realizados afectarán el cronograma visible para los participantes asignados.
                    </div>
                </div>
            </div>
        </div>
    </form>

    @script
    <script>
        window.confirmarEliminarAuditoria = function () {
            Swal.fire({
                title: '¿Quieres eliminar esta auditoría?',
                text: "Se perderán todos los datos de respuestas y participantes vinculados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarAuditoriaOn();
                }
            });
        }
    </script>
    @endscript
</div>
