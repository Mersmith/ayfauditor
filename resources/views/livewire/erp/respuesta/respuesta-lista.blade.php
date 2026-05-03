<div class="g_gap_pagina">
    <x-loading-overlay wire:loading
        wire:target="auditoria_id, estado_id, desde, hasta, perPage, resetFiltros, exportExcelFiltro, exportExcelTodo"
        message="Cargando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Seguimiento de Respuestas</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.respuesta.vista.crear') }}" class="g_boton primary">
                Registrar Respuesta <i class="fa-solid fa-plus-circle"></i></a>
        </div>
    </div>

    <div class="g_panel">
        <div class="formulario">
            <div class="g_fila">
                <div class="g_margin_bottom_10 g_columna_4">
                    <label>Filtrar por Auditoría</label>
                    <select wire:model.live="auditoria_id">
                        <option value="">Todas las Auditorías</option>
                        @foreach($auditorias as $aud)
                            <option value="{{ $aud->id }}">{{ $aud->titulo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="g_margin_bottom_10 g_columna_3">
                    <label>Estado de Respuesta</label>
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
                        <th>Pregunta / Categoría</th>
                        <th>Respuesta del Cliente</th>
                        <th class="g_celda_centro">Estado</th>
                        <th class="g_celda_centro">Registro</th>
                        <th class="g_celda_centro">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="g_celda_centro"><code>#{{ $item->id }}</code></td>
                            <td>
                                <div style="font-weight: 600; font-size: 0.9rem;">{{ Str::limit($item->pregunta->texto, 100) }}</div>
                                <div class="g_inferior" style="color: {{ $item->pregunta->categoria->color ?? '#666' }};">
                                    <i class="{{ $item->pregunta->categoria->icono ?? 'fa-solid fa-tag' }}"></i> 
                                    {{ $item->pregunta->categoria->nombre ?? 'Sin Categoría' }}
                                </div>
                                <div class="g_inferior">
                                    <i class="fa-solid fa-clipboard-list"></i> {{ $item->auditoria->titulo ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <div class="g_inferior" style="font-style: italic; white-space: pre-line;">
                                    "{{ Str::limit($item->respuesta_cliente, 150) ?: 'Sin respuesta redactada' }}"
                                </div>
                            </td>
                            <td class="g_celda_centro">
                                @if($item->estado)
                                    <div style="background-color: {{ $item->estado->color ?? '#ddd' }}; color: white; padding: 4px 10px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 5px;">
                                        <i class="{{ $item->estado->icono ?? 'fa-solid fa-circle-dot' }}"></i>
                                        {{ $item->estado->nombre }}
                                    </div>
                                @else
                                    <span class="g_badge secondary">Pendiente</span>
                                @endif
                            </td>
                            <td class="g_celda_centro">
                                <div class="g_inferior">{{ $item->creator->name ?? 'Sistema' }}</div>
                                <div class="g_inferior">{{ $item->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="g_celda_centro">
                                <a href="{{ route('erp.respuesta.vista.editar', $item->id) }}" class="g_accion editar"
                                    title="Calificar / Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                @if($item->comentarios_count > 0)
                                    <span class="g_badge info" title="Comentarios">
                                        <i class="fa-solid fa-comments"></i> {{ $item->comentarios_count }}
                                    </span>
                                @endif
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
                <p>No se encontraron respuestas registradas.</p>
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
