<div class="g_gap_pagina">
    <x-loading-overlay wire:loading
        wire:target="buscar, activo, desde, hasta, perPage, resetFiltros, exportExcelFiltro, exportExcelTodo"
        message="Cargando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Plantillas de Auditoría</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.plantilla.vista.crear') }}" class="g_boton primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <div class="g_panel">
        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_6">
                    <label>Buscar por Nombre</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" placeholder="Ej: ISO 9001">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha inicio</label>
                    <input type="date" wire:model.live="desde">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha fin</label>
                    <input type="date" wire:model.live="hasta">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Estado</label>
                    <select wire:model.live="activo">
                        <option value="">Todas</option>
                        <option value="1">Activas</option>
                        <option value="0">Inactivas</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="g_panel">
        <div class="g_tabla_cabecera">
            <div class="g_tabla_cabecera_botones">
                <button wire:click="exportExcelFiltro" class="g_boton excel" wire:loading.attr="disabled"
                    wire:target="exportExcelFiltro">
                    <span wire:loading.remove wire:target="exportExcelFiltro">Exportar Filtradas <i
                            class="fa-regular fa-file-excel"></i></span>
                    <span wire:loading wire:target="exportExcelFiltro">Generando... <i
                            class="fa-solid fa-spinner fa-spin"></i></span>
                </button>

                <button wire:click="exportExcelTodo" class="g_boton dark" wire:loading.attr="disabled"
                    wire:target="exportExcelTodo">
                    <span wire:loading.remove wire:target="exportExcelTodo">Exportar Todo <i
                            class="fa-solid fa-file-export"></i></span>
                    <span wire:loading wire:target="exportExcelTodo">Generando... <i
                            class="fa-solid fa-spinner fa-spin"></i></span>
                </button>

                <button wire:click="resetFiltros" class="g_boton danger">
                    Limpiar <i class="fa-solid fa-rotate-left"></i>
                </button>
            </div>

            <div class="g_tabla_cabecera_filtro formulario">
                <div>
                    <label>Mostrar</label>
                    <select wire:model.live="perPage">
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="g_contenedor_tabla">
            <table class="g_tabla">
                <thead>
                    <tr>
                        <th class="g_celda_centro">ID</th>
                        <th>Nombre de la Plantilla</th>
                        <th class="g_celda_centro">N° Preguntas</th>
                        <th class="g_celda_centro">Activo</th>
                        <th class="g_celda_centro">Fecha Registro</th>
                        <th class="g_celda_centro">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="g_celda_centro"><code>#{{ $item->id }}</code></td>
                            <td>
                                <span class="g_resaltar">{{ $item->nombre }}</span>
                                <div class="g_inferior">{{ Str::limit($item->descripcion, 80) ?: '-' }}</div>
                            </td>
                            <td class="g_celda_centro">
                                <span class="g_badge light" style="font-weight: 700; font-size: 0.9rem;">
                                    {{ $item->preguntas_count }}
                                </span>
                            </td>
                            <td class="g_celda_centro">
                                @if ($item->activo)
                                    <span class="g_badge success">Activa</span>
                                @else
                                    <span class="g_badge danger">Inactiva</span>
                                @endif
                            </td>
                            <td class="g_celda_centro">{{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-' }}</td>
                            <td class="g_celda_centro">
                                <a href="{{ route('erp.plantilla.vista.editar', $item->id) }}" class="g_accion editar"
                                    title="Editar y Asignar Preguntas">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($items->hasPages())
            <div class="g_paginacion">
                {{ $items->links() }}
            </div>
        @endif

        @if ($items->isEmpty())
            <div class="g_vacio">
                <p>{{ $buscar ? 'No se encontraron resultados para "' . $buscar . '"' : 'No hay plantillas registradas.' }}
                </p>
                <i class="fa-regular fa-face-meh"></i>
            </div>
        @else
            <div class="g_paginacion">
                Mostrando {{ $items->firstItem() ?? 0 }} – {{ $items->lastItem() ?? 0 }}
                de {{ $items->total() }} registros
            </div>
        @endif
    </div>
</div>
