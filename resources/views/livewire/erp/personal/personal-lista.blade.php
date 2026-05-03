<div class="g_gap_pagina">
    <x-loading-overlay wire:loading
        wire:target="buscar, activo, desde, hasta, perPage, empresa_id, cargo_id, resetFiltros, exportExcelFiltro, exportExcelTodo"
        message="Cargando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Personal de Empresas</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.personal.vista.crear') }}" class="g_boton primary">
                Crear <i class="fa-solid fa-square-plus"></i></a>
        </div>
    </div>

    <div class="g_panel">
        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_4">
                    <label>Buscar (Nombre, DNI, Email o ID)</label>
                    <input type="text" wire:model.live.debounce.1300ms="buscar" placeholder="Ej: Juan Pérez">
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Empresa</label>
                    <select wire:model.live="empresa_id">
                        <option value="">Todas</option>
                        @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id }}">{{ $empresa->razon_social }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_2">
                    <label>Cargo</label>
                    <select wire:model.live="cargo_id">
                        <option value="">Todos</option>
                        @foreach($cargos as $cargo)
                            <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
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
                        <th>Empresas / Cargos</th>
                        <th>DNI / RUC</th>
                        <th>Celular</th>
                        <th>Usuario (Email)</th>
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
                            <td>
                                @foreach($item->personalEmpresas as $pe)
                                    <div class="g_margin_bottom_5">
                                        <span class="g_badge light" title="Empresa">
                                            <i class="fa-solid fa-building"></i> {{ $pe->empresa?->razon_social ?? 'N/A' }}
                                        </span>
                                        <span class="g_badge info" title="Cargo">
                                            <i class="fa-solid fa-user-tag"></i> {{ $pe->cargo?->nombre ?? 'S/C' }}
                                        </span>
                                    </div>
                                @endforeach
                                @if($item->personalEmpresas->isEmpty())
                                    <span class="g_badge secondary">Sin asignación</span>
                                @endif
                            </td>
                            <td>{{ $item->dni ?? '-' }}</td>
                            <td>{{ $item->celular ?? '-' }}</td>
                            <td>
                                @if($item->user)
                                    <span class="g_badge secondary">{{ $item->user->email }}</span>
                                @else
                                    <span class="g_badge light">Sin usuario</span>
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
                                <a href="{{ route('erp.personal.vista.editar', $item->id) }}" class="g_accion editar"
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
                <p>{{ $buscar ? 'No se encontraron resultados para "' . $buscar . '"' : 'No hay personal registrado.' }}
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
