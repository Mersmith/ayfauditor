<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, eliminarPlantillaOn, agregarPregunta, quitarPregunta"
        message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Configurar Plantilla: {{ $plantilla->nombre }}</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.plantilla.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarPlantilla()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <div class="g_fila">
        <div class="g_columna_12">
            <form wire:submit="update" class="g_panel formulario">
                <div class="g_fila">
                    <div class="g_columna_2">
                        <label for="estado_activo">Estado</label>
                        <div class="g_switch-wrapper">
                            <label class="g_switch">
                                <input id="estado_activo" type="checkbox" wire:model.live="activo">
                                <span class="g_switch-slider"></span>
                            </label>
                            <span class="g_switch-label">{{ $activo ? 'Activa' : 'Inactiva' }}</span>
                        </div>
                    </div>
                    <div class="g_columna_4">
                        <label for="nombre">Nombre de la Plantilla</label>
                        <input type="text" id="nombre" wire:model.blur="nombre"
                            class="@error('nombre') input-error @enderror">
                        @error('nombre') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>
                    <div class="g_columna_4">
                        <label for="descripcion">Descripción</label>
                        <input type="text" id="descripcion" wire:model.blur="descripcion"
                            placeholder="Alcance de la plantilla...">
                    </div>
                    <div class="g_columna_2" style="display: flex; align-items: flex-end; padding-bottom: 15px;">
                        <button type="submit" class="g_boton guardar w-full">
                            Actualizar <i class="fa-solid fa-save"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="g_fila">
        <!-- TABLA PREGUNTAS ASIGNADAS -->
        <div class="g_columna_6">
            <div class="g_panel">
                <div class="g_tabla_cabecera">
                    <h3>Preguntas Asignadas ({{ $preguntasAsignadas->total() }})</h3>
                </div>

                <div class="formulario g_margin_bottom_10">
                    <input type="text" wire:model.live.debounce.500ms="searchAsignadas"
                        placeholder="Filtrar asignadas...">
                </div>

                <div class="g_contenedor_tabla">
                    <table class="g_tabla">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pregunta</th>
                                <th class="g_celda_centro">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preguntasAsignadas as $item)
                                <tr>
                                    <td class="g_celda_centro"><code>#{{ $item->id }}</code></td>
                                    <td>
                                        <div style="font-size: 0.9rem; font-weight: 500;">{{ $item->texto }}</div>
                                        <div style="font-size: 0.75rem; color: {{ $item->categoria->color ?? '#666' }};">
                                            <i class="{{ $item->categoria->icono ?? 'fa-solid fa-tag' }}"></i>
                                            {{ $item->categoria->nombre ?? 'Sin Categoría' }}
                                        </div>
                                    </td>
                                    <td class="g_celda_centro">
                                        <button wire:click="quitarPregunta({{ $item->id }})" class="g_accion danger"
                                            title="Quitar">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($preguntasAsignadas->hasPages())
                    <div class="g_paginacion">
                        {{ $preguntasAsignadas->links() }}
                    </div>
                @endif

                @if($preguntasAsignadas->isEmpty())
                    <div class="g_vacio_mini">No hay preguntas vinculadas.</div>
                @endif
            </div>
        </div>

        <!-- TABLA PREGUNTAS DISPONIBLES -->
        <div class="g_columna_6">
            <div class="g_panel">
                <div class="g_tabla_cabecera">
                    <h3>Banco de Preguntas Disponibles</h3>
                </div>

                <div class="formulario g_margin_bottom_10">
                    <input type="text" wire:model.live.debounce.500ms="searchDisponibles"
                        placeholder="Buscar en el banco global...">
                </div>

                <div class="g_contenedor_tabla">
                    <table class="g_tabla">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Pregunta</th>
                                <th class="g_celda_centro">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($preguntasDisponibles as $item)
                                <tr>
                                    <td class="g_celda_centro"><code>#{{ $item->id }}</code></td>
                                    <td>
                                        <div style="font-size: 0.9rem;">{{ $item->texto }}</div>
                                        <div style="font-size: 0.75rem; color: {{ $item->categoria->color ?? '#666' }};">
                                            <i class="{{ $item->categoria->icono ?? 'fa-solid fa-tag' }}"></i>
                                            {{ $item->categoria->nombre ?? 'Sin Categoría' }}
                                        </div>
                                    </td>
                                    <td class="g_celda_centro">
                                        <button wire:click="agregarPregunta({{ $item->id }})" class="g_accion primary"
                                            title="Agregar">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($preguntasDisponibles->hasPages())
                    <div class="g_paginacion">
                        {{ $preguntasDisponibles->links() }}
                    </div>
                @endif

                @if($preguntasDisponibles->isEmpty())
                    <div class="g_vacio_mini">No hay más preguntas disponibles.</div>
                @endif
            </div>
        </div>
    </div>

    @script
    <script>
        window.confirmarEliminarPlantilla = function () {
            Swal.fire({
                title: '¿Quieres eliminar esta plantilla?',
                text: "Se perderán las configuraciones de preguntas asignadas.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarPlantillaOn();
                }
            });
        }
    </script>
    @endscript
</div>