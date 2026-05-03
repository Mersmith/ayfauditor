<div class="g_gap_pagina">
    <x-loading-overlay wire:loading
        wire:target="buscar, empresa_id, estado_id, desde, hasta, perPage, resetFiltros, exportExcelFiltro, exportExcelTodo"
        message="Cargando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Gestión de Auditorías</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.auditoria.vista.crear') }}" class="g_boton primary">
                Nueva Auditoría <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <div class="g_panel">
        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_3">
                    <label>Buscar Título / ID</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" placeholder="Ej: Auditoría Anual">
                </div>

                <div class="g_margin_bottom_10 g_columna_3">
                    <label>Empresa</label>
                    <select wire:model.live="empresa_id">
                        <option value="">Todas las Empresas</option>
                        @foreach($empresas as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->razon_social }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Estado</label>
                    <select wire:model.live="estado_id">
                        <option value="">Todos los Estados</option>
                        @foreach($estados as $est)
                            <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha inicio</label>
                    <input type="date" wire:model.live="desde">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha fin</label>
                    <input type="date" wire:model.live="hasta">
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
                        <th>Auditoría / Empresa</th>
                        <th>Plantilla</th>
                        <th class="g_celda_centro">Estado</th>
                        <th class="g_celda_centro">Cronograma</th>
                        <th class="g_celda_centro">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="g_celda_centro"><code>#{{ $item->id }}</code></td>
                            <td>
                                <span class="g_resaltar">{{ $item->titulo }}</span>
                                <div class="g_inferior">
                                    <i class="fa-solid fa-building"></i> {{ $item->empresa->razon_social ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <span class="g_badge light">{{ $item->plantilla->nombre ?? '-' }}</span>
                            </td>
                            <td class="g_celda_centro">
                                @if ($item->estado)
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                        <div style="background-color: {{ $item->estado->color ?? '#ddd' }}; color: white; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: flex; align-items: center; gap: 5px;">
                                            <i class="{{ $item->estado->icono ?? 'fa-solid fa-circle-dot' }}"></i>
                                            {{ $item->estado->nombre }}
                                        </div>
                                    </div>
                                @else
                                    <span class="g_badge secondary">Sin Estado</span>
                                @endif
                            </td>
                            <td class="g_celda_centro">
                                <div class="g_inferior" title="Inicio">
                                    <i class="fa-solid fa-calendar-check"></i> {{ $item->fecha_inicio ? \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y') : '-' }}
                                </div>
                                <div class="g_inferior" title="Fin">
                                    <i class="fa-solid fa-calendar-xmark"></i> {{ $item->fecha_fin ? \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') : '-' }}
                                </div>
                            </td>
                            <td class="g_celda_centro">
                                <a href="{{ route('erp.auditoria.vista.editar', $item->id) }}" class="g_accion editar"
                                    title="Editar">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                
                                <a href="#" class="g_accion ver" title="Ver Resultados">
                                    <i class="fa-solid fa-chart-line"></i>
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
                <p>{{ $buscar ? 'No se encontraron resultados para "' . $buscar . '"' : 'No hay auditorías registradas.' }}
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
