<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, eliminarRespuestaOn" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Calificar Respuesta <code>#{{ $respuesta->id }}</code></h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.respuesta.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarRespuesta()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <div class="g_fila">
        <!-- COLUMNA IZQUIERDA: DETALLES Y FORMULARIO -->
        <div class="g_columna_8">
            <!-- PANEL PREGUNTA -->
            <div class="g_panel g_margin_bottom_20">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                    <span class="g_badge info" style="background-color: {{ $respuesta->pregunta->categoria->color ?? '#eee' }}; color: white;">
                        <i class="{{ $respuesta->pregunta->categoria->icono ?? 'fa-solid fa-tag' }}"></i> 
                        {{ $respuesta->pregunta->categoria->nombre ?? 'Sin Categoría' }}
                    </span>
                    <span class="g_inferior">ID Pregunta: #{{ $respuesta->pregunta->id }}</span>
                </div>
                <h3 style="font-size: 1.2rem; line-height: 1.4;">{{ $respuesta->pregunta->texto }}</h3>
                @if($respuesta->pregunta->ayuda)
                    <div class="g_alert info" style="margin-top: 10px;">
                        <i class="fa-solid fa-lightbulb"></i> <strong>Guía para Auditor:</strong> {{ $respuesta->pregunta->ayuda }}
                    </div>
                @endif
            </div>

            <!-- FORMULARIO DE CALIFICACIÓN -->
            <form wire:submit="update" class="formulario">
                <div class="g_panel">
                    <div class="g_margin_bottom_20">
                        <label for="respuesta_cliente">Contenido de la Respuesta (Cliente/Auditado)</label>
                        <textarea id="respuesta_cliente" wire:model.blur="respuesta_cliente" rows="6"
                            placeholder="Redacte o edite la respuesta proporcionada por el auditado..."
                            class="@error('respuesta_cliente') input-error @enderror"></textarea>
                        @error('respuesta_cliente') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_6 g_margin_bottom_20">
                            <label for="estado_respuesta_id">Calificación / Dictamen</label>
                            <select id="estado_respuesta_id" wire:model.live="estado_respuesta_id"
                                class="@error('estado_respuesta_id') input-error @enderror">
                                <option value="">Seleccione dictamen...</option>
                                @foreach($estados as $est)
                                    <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                                @endforeach
                            </select>
                            @error('estado_respuesta_id') <p class="mensaje_error">{{ $message }}</p> @enderror
                        </div>

                        <div class="g_columna_6" style="display: flex; align-items: center; justify-content: flex-end; padding-top: 10px;">
                            @if($respuesta->estado)
                                <div style="background-color: {{ $respuesta->estado->color }}; color: white; padding: 10px 20px; border-radius: 20px; display: flex; align-items: center; gap: 8px; font-weight: 700; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <i class="{{ $respuesta->estado->icono }}"></i>
                                    {{ $respuesta->estado->nombre }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="g_margin_bottom_20">
                        <label for="nuevo_comentario">Añadir Observación / Comentario de Auditoría</label>
                        <textarea id="nuevo_comentario" wire:model.blur="nuevo_comentario" rows="3"
                            placeholder="Escriba un comentario técnico o hallazgo relevante..."
                            class="@error('nuevo_comentario') input-error @enderror"></textarea>
                        @error('nuevo_comentario') <p class="mensaje_error">{{ $message }}</p> @enderror
                    </div>

                    <div class="formulario_botones">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="update">
                            <span wire:loading.remove wire:target="update">
                                <i class="fa-solid fa-save"></i> Guardar Calificación
                            </span>
                            <span wire:loading wire:target="update">
                                <i class="fa-solid fa-spinner fa-spin"></i> Procesando...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- COLUMNA DERECHA: HISTORIAL Y METADATOS -->
        <div class="g_columna_4">
            <!-- PANEL AUDITORÍA -->
            <div class="g_panel g_margin_bottom_20">
                <h3>Contexto de Auditoría</h3>
                <div class="g_alert info">
                    <div style="font-weight: 700;">{{ $respuesta->auditoria->titulo }}</div>
                    <div style="font-size: 0.85rem; margin-top: 5px;">
                        <i class="fa-solid fa-building"></i> {{ $respuesta->auditoria->empresa->razon_social ?? '-' }}
                    </div>
                </div>
                <div class="g_inferior" style="margin-top: 10px;">
                    <i class="fa-solid fa-calendar"></i> Registrada el: {{ $respuesta->created_at->format('d/m/Y H:i') }}<br>
                    <i class="fa-solid fa-user-pen"></i> Por: {{ $respuesta->creator->name ?? 'Sistema' }}
                </div>
            </div>

            <!-- HISTORIAL DE COMENTARIOS -->
            <div class="g_panel">
                <h3>Observaciones de Auditoría ({{ $respuesta->comentarios->count() }})</h3>
                <div class="g_margin_top_15" style="max-height: 500px; overflow-y: auto; padding-right: 5px;">
                    @forelse($respuesta->comentarios->sortByDesc('created_at') as $com)
                        <div style="padding: 12px; border-radius: 8px; background-color: #f9f9f9; border-left: 3px solid #3490dc; margin-bottom: 12px;">
                            <div style="font-size: 0.85rem; font-weight: 700; display: flex; justify-content: space-between;">
                                <span>{{ $com->user->name }}</span>
                                <span style="font-weight: 400; color: #888;">{{ $com->created_at->diffForHumans() }}</span>
                            </div>
                            <div style="font-size: 0.9rem; margin-top: 5px; color: #444; white-space: pre-line;">
                                {{ $com->comentario }}
                            </div>
                        </div>
                    @empty
                        <div class="g_vacio_mini">No hay observaciones registradas.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        window.confirmarEliminarRespuesta = function () {
            Swal.fire({
                title: '¿Quieres eliminar esta respuesta?',
                text: "Se perderá la respuesta del cliente y todo el historial de observaciones.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarRespuestaOn();
                }
            });
        }
    </script>
    @endscript
</div>