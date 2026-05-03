<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, eliminarParticipanteOn" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar Participante <code>#{{ $participante->id }}</code></h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.participante-auditoria.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarParticipante()">
                Retirar <i class="fa-solid fa-user-minus"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="update" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel">
                    <div class="g_margin_bottom_20">
                        <label for="auditoria_id">
                            Auditoría <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                        </label>
                        <select id="auditoria_id" wire:model.blur="auditoria_id"
                            class="@error('auditoria_id') input-error @enderror">
                            @foreach($auditorias as $aud)
                                <option value="{{ $aud->id }}">{{ $aud->titulo }}</option>
                            @endforeach
                        </select>
                        @error('auditoria_id')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_fila">
                        <div class="g_margin_bottom_15 g_columna_6">
                            <label for="user_id">
                                Usuario <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="user_id" wire:model.blur="user_id"
                                class="@error('user_id') input-error @enderror">
                                @foreach($usuarios as $usu)
                                    <option value="{{ $usu->id }}">{{ $usu->name }} ({{ $usu->email }})</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_15 g_columna_6">
                            <label for="cargo_id">
                                Cargo en la Auditoría <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="cargo_id" wire:model.blur="cargo_id"
                                class="@error('cargo_id') input-error @enderror">
                                @foreach($cargos as $car)
                                    <option value="{{ $car->id }}">{{ $car->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cargo_id')
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
                    <h3>Estado de Asignación</h3>
                    <p class="g_inferior g_margin_bottom_15">Registrado el {{ $participante->created_at->format('d/m/Y H:i') }}</p>

                    @if($user_id && $usuarios->firstWhere('id', $user_id))
                        <div style="display: flex; align-items: center; gap: 15px; margin-top: 15px;">
                            <div style="width: 50px; height: 50px; border-radius: 50%; background-color: #eee; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700;">{{ $usuarios->firstWhere('id', $user_id)->name }}</div>
                                <div style="font-size: 0.8rem; color: #666;">{{ $usuarios->firstWhere('id', $user_id)->email }}</div>
                            </div>
                        </div>
                    @endif

                    <div class="g_alert info">
                        <i class="fa-solid fa-info-circle"></i> Invitado originalmente por: <strong>{{ $participante->invitadoPor->name ?? 'Sistema' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @script
    <script>
        window.confirmarEliminarParticipante = function () {
            Swal.fire({
                title: '¿Quieres retirar a este participante?',
                text: "El usuario perderá el acceso a los datos de esta auditoría.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, retirar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarParticipanteOn();
                }
            });
        }
    </script>
    @endscript
</div>
