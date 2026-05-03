<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="store" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Programar Nueva Auditoría</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.auditoria.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="store" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel">
                    <div class="g_margin_bottom_15">
                        <label for="titulo">
                            Título de la Auditoría <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                        </label>
                        <input type="text" id="titulo" wire:model.blur="titulo"
                            class="@error('titulo') input-error @enderror" placeholder="Ej: Auditoría Trimestral de Procesos 2026">
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
                                <option value="">Seleccione empresa...</option>
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
                                <option value="">Seleccione plantilla...</option>
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
                            <label for="estado_auditoria_id">Estado Inicial</label>
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
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">
                                <i class="fa-solid fa-save"></i> Programar Auditoría
                            </span>
                            <span wire:loading wire:target="store">
                                <i class="fa-solid fa-spinner fa-spin"></i> Guardando...
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
                    <h3>Resumen de Programación</h3>
                    <div class="g_alert info">
                        <i class="fa-solid fa-info-circle"></i> Al crear la auditoría, se generará el espacio de trabajo para los auditores y se habilitará el cuestionario seleccionado.
                    </div>
                    
                    <ul class="g_lista_resumen">
                        <li><strong>Empresa:</strong> {{ $empresa_id ? $empresas->firstWhere('id', $empresa_id)->razon_social : 'No seleccionada' }}</li>
                        <li><strong>Plantilla:</strong> {{ $plantilla_id ? $plantillas->firstWhere('id', $plantilla_id)->nombre : 'No seleccionada' }}</li>
                        <li><strong>Inicio:</strong> {{ $fecha_inicio ? \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') : '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>
