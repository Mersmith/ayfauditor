<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="store" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Asignar Participante a Auditoría</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.participante-auditoria.vista.lista') }}" class="g_boton light">
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
                    <div class="g_margin_bottom_20">
                        <label for="auditoria_id">
                            Auditoría de Destino <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                        </label>
                        <select id="auditoria_id" wire:model.blur="auditoria_id"
                            class="@error('auditoria_id') input-error @enderror">
                            <option value="">Seleccione auditoría...</option>
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
                                Seleccionar Usuario <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="user_id" wire:model.blur="user_id"
                                class="@error('user_id') input-error @enderror">
                                <option value="">Seleccione usuario...</option>
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
                                Cargo en esta Auditoría <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="cargo_id" wire:model.blur="cargo_id"
                                class="@error('cargo_id') input-error @enderror">
                                <option value="">Seleccione cargo...</option>
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
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">
                                <i class="fa-solid fa-save"></i> Guardar Asignación
                            </span>
                            <span wire:loading wire:target="store">
                                <i class="fa-solid fa-spinner fa-spin"></i> Procesando...
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
                    <h3>Resumen de Asignación</h3>
                    <div class="g_alert warning">
                        <i class="fa-solid fa-shield-halved"></i> La asignación otorga acceso al usuario para participar en el proceso de auditoría con los permisos de su cargo.
                    </div>
                    
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

                    @if($cargo_id && $cargos->firstWhere('id', $cargo_id))
                        <div style="margin-top: 15px; padding: 10px; border-radius: 6px; background-color: #f0fdf4; border-left: 4px solid #16a34a;">
                            <div style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: #16a34a; font-weight: 700;">Cargo</div>
                            <div style="font-weight: 600;">{{ $cargos->firstWhere('id', $cargo_id)->nombre }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
