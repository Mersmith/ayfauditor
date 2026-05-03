<div class="g_gap_pagina">
    <x-loading-overlay wire:loading
        wire:target="buscar, activo, desde, hasta, perPage, especialidad_id, cargo_id, resetFiltros, exportExcelFiltro, exportExcelTodo"
        message="Cargando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Equipo de Trabajo</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.trabajador.vista.crear') }}" class="g_boton primary">
                Crear <i class="fa-solid fa-user-plus"></i></a>
        </div>
    </div>

    <div class="g_panel">
        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_4">
                    <label>Buscar (Nombre, DNI, Email o ID)</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" placeholder="Ej: Carlos Sánchez">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Especialidad</label>
                    <select wire:model.live="especialidad_id">
                        <option value="">Todas</option>
                        @foreach($especialidades as $esp)
                            <option value="{{ $esp->id }}">{{ $esp->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Cargo</label>
                    <select wire:model.live="cargo_id">
                        <option value="">Todos</option>
                        @foreach($cargos as $car)
                            <option value="{{ $car->id }}">{{ $car->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Fecha inicio</label>
                    <input type="date" wire:model.live="desde">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Estado</label>
                    <select wire:model.live="activo">
                        <option value="">Todos</option>
                        <option value="1">Activos</option>
                        <option value="0">Inactivos</option>
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
                    <span wire:loading.remove wire:target="exportExcelFiltro">Exportar Filtrados <i
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
                        <th class="g_celda_centro">Nº</th>
                        <th>Nombre Completo</th>
                        <th>DNI</th>
                        <th>Especialidad / Cargo</th>
                        <th>Registro Prof.</th>
                        <th>Email Acceso</th>
                        <th class="g_celda_centro">Activo</th>
                        <th class="g_celda_centro">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <td class="g_celda_centro">{{ $items->firstItem() + $index }}</td>
                            <td>
                                <span class="g_resaltar">{{ $item->nombre }}</span>
                            </td>
                            <td>{{ $item->dni ?? '-' }}</td>
                            <td>
                                <span class="g_badge info" title="Especialidad">
                                    <i class="fa-solid fa-stethoscope"></i> {{ $item->especialidad?->nombre ?? 'N/A' }}
                                </span>
                                <div class="g_margin_top_5">
                                    <span class="g_badge light" title="Cargo">
                                        <i class="fa-solid fa-id-badge"></i> {{ $item->cargo?->nombre ?? 'N/A' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                @if($item->registro_profesional)
                                    <code>{{ $item->registro_profesional }}</code>
                                @else
                                    <span class="g_inferior">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->user)
                                    <span class="g_badge secondary">{{ $item->user->email }}</span>
                                @else
                                    <span class="g_badge danger">Sin acceso</span>
                                @endif
                            </td>
                            <td class="g_celda_centro">
                                @if ($item->activo)
                                    <span class="g_badge success">Activo</span>
                                @else
                                    <span class="g_badge danger">Inactivo</span>
                                @endif
                            </td>
                            <td class="g_celda_centro">
                                <a href="{{ route('erp.trabajador.vista.editar', $item->id) }}" class="g_accion editar"
                                    title="Editar">
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
                <p>{{ $buscar ? 'No se encontraron resultados para "' . $buscar . '"' : 'No hay trabajadores registrados.' }}
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
