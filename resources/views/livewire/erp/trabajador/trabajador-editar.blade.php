<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, enviarRecuperarClave, eliminarTrabajadorOn" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar Trabajador: {{ $trabajador->nombre }}</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.trabajador.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarTrabajador()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="update" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel" x-data="{ activeTab: 'personal' }">

                    <div class="g_tab_navegacion">
                        <div class="g_tab_botones">
                            <button type="button" @click="activeTab = 'personal'"
                                :class="activeTab === 'personal' ? 'g_tab_active' : 'g_tab_inactive'"
                                class="g_tab_boton">
                                <i class="fa-solid fa-user"></i> Información Personal
                            </button>

                            <button type="button" @click="activeTab = 'profesional'"
                                :class="activeTab === 'profesional' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-briefcase"></i> Perfil Profesional
                            </button>

                            <button type="button" @click="activeTab = 'acceso'"
                                :class="activeTab === 'acceso' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-key"></i> Acceso al Sistema
                            </button>

                            <button type="button" @click="activeTab = 'seguridad'"
                                :class="activeTab === 'seguridad' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-shield-halved"></i> Seguridad
                            </button>
                        </div>
                    </div>

                    <!-- TAB PERSONAL -->
                    <div x-show="activeTab === 'personal'" x-transition class="g_tab_content">
                        <div class="g_margin_bottom_10">
                            <label for="estado_activo">
                                Estado <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>

                            <div class="g_switch-wrapper">
                                <label class="g_switch">
                                    <input id="estado_activo" type="checkbox" wire:model.live="activo">
                                    <span class="g_switch-slider"></span>
                                </label>

                                <span class="g_switch-label">
                                    {{ $activo ? 'Activo' : 'Inactivo' }}
                                </span>

                                @error('activo')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="nombre">
                                Nombre Completo <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" id="nombre" wire:model.blur="nombre"
                                class="@error('nombre') input-error @enderror" autocomplete="off">
                            @error('nombre')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="dni">
                                DNI / RUC
                            </label>
                            <input type="text" id="dni" wire:model.blur="dni"
                                class="@error('dni') input-error @enderror" autocomplete="off" maxlength="11">
                            @error('dni')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TAB PROFESIONAL -->
                    <div x-show="activeTab === 'profesional'" x-transition class="g_tab_content">
                        <div class="g_fila">
                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="especialidad_id">
                                    Especialidad Principal <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                                </label>
                                <select id="especialidad_id" wire:model.blur="especialidad_id"
                                    class="@error('especialidad_id') input-error @enderror">
                                    <option value="">Seleccione...</option>
                                    @foreach($especialidades as $esp)
                                        <option value="{{ $esp->id }}">{{ $esp->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('especialidad_id')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="cargo_id">
                                    Cargo / Rol Interno <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                                </label>
                                <select id="cargo_id" wire:model.blur="cargo_id"
                                    class="@error('cargo_id') input-error @enderror">
                                    <option value="">Seleccione...</option>
                                    @foreach($cargos as $cargo)
                                        <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('cargo_id')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="registro_profesional">
                                Registro Profesional (Colegiatura/Matrícula)
                            </label>
                            <input type="text" id="registro_profesional" wire:model.blur="registro_profesional"
                                class="@error('registro_profesional') input-error @enderror">
                            @error('registro_profesional')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TAB ACCESO -->
                    <div x-show="activeTab === 'acceso'" x-transition class="g_tab_content">
                        <div class="g_margin_bottom_10">
                            <label for="name">
                                Usuario de Acceso (Login) <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" id="name" wire:model.blur="name"
                                class="@error('name') input-error @enderror" autocomplete="off">
                            @error('name')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="email">
                                Correo Electrónico <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="email" id="email" wire:model.blur="email"
                                class="@error('email') input-error @enderror" autocomplete="off">
                            @error('email')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_alert info">
                            <i class="fa-solid fa-info-circle"></i> Los cambios en el acceso afectarán la entrada al sistema de este trabajador.
                        </div>
                    </div>

                    <!-- TAB SEGURIDAD -->
                    <div x-show="activeTab === 'seguridad'" x-transition class="g_tab_content">
                        <div class="g_panel_seccion_especial">
                            <h3>Restablecer Contraseña</h3>
                            <p>Si el trabajador olvidó su contraseña, puedes enviar un enlace de recuperación a su correo electrónico institucional.</p>
                            
                            <div class="g_margin_top_15">
                                <button type="button" class="g_boton info" wire:click="enviarRecuperarClave"
                                    wire:loading.attr="disabled" wire:target="enviarRecuperarClave">
                                    <span wire:loading.remove wire:target="enviarRecuperarClave">
                                        <i class="fa-solid fa-paper-plane"></i> Enviar Enlace de Recuperación
                                    </span>
                                    <span wire:loading wire:target="enviarRecuperarClave">
                                        <i class="fa-solid fa-spinner fa-spin"></i> Enviando...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="formulario_botones g_tab_form_buttons">
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
        </div>
    </form>

    @script
    <script>
        window.confirmarEliminarTrabajador = function () {
            Swal.fire({
                title: '¿Quieres eliminar este registro?',
                text: "Esta acción no se puede deshacer y el trabajador perderá el acceso.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarTrabajadorOn();
                }
            });
        }
    </script>
    @endscript
</div>
