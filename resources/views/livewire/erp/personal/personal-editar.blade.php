<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, enviarRecuperarClave, eliminarPersonalOn" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar Personal: {{ $personal->nombre }}</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.personal.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarPersonal()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="update" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel" x-data="{ activeTab: 'info' }">

                    <div class="g_tab_navegacion">
                        <div class="g_tab_botones">
                            <button type="button" @click="activeTab = 'info'"
                                :class="activeTab === 'info' ? 'g_tab_active' : 'g_tab_inactive'"
                                class="g_tab_boton">
                                <i class="fa-solid fa-user"></i> Información Personal
                            </button>

                            <button type="button" @click="activeTab = 'empresa'"
                                :class="activeTab === 'empresa' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-building-user"></i> Asignación de Empresa
                            </button>

                            @if($user)
                                <button type="button" @click="activeTab = 'acceso'"
                                    :class="activeTab === 'acceso' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                    <i class="fa-solid fa-key"></i> Acceso al Sistema
                                </button>
                            @endif

                            <button type="button" @click="activeTab = 'seguridad'"
                                :class="activeTab === 'seguridad' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-shield-halved"></i> Seguridad
                            </button>
                        </div>
                    </div>

                    <!-- TAB INFO -->
                    <div x-show="activeTab === 'info'" x-transition class="g_tab_content">
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

                        <div class="g_fila">
                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="dni">
                                    DNI / RUC
                                </label>
                                <input type="text" id="dni" wire:model.blur="dni"
                                    class="@error('dni') input-error @enderror" autocomplete="off" maxlength="11">
                                @error('dni')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="celular">
                                    Teléfono / Celular
                                </label>
                                <input type="text" id="celular" wire:model.blur="celular"
                                    class="@error('celular') input-error @enderror" autocomplete="off">
                                @error('celular')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- TAB EMPRESA -->
                    <div x-show="activeTab === 'empresa'" x-transition class="g_tab_content">
                        <div class="g_alert info">
                            <i class="fa-solid fa-circle-info"></i> Puedes actualizar la vinculación de este personal con una empresa y su cargo correspondiente.
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="empresa_id">Empresa</label>
                            <select id="empresa_id" wire:model.blur="empresa_id" class="@error('empresa_id') input-error @enderror">
                                <option value="">Sin asignar...</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->razon_social }}</option>
                                @endforeach
                            </select>
                            @error('empresa_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="cargo_id">Cargo</label>
                            <select id="cargo_id" wire:model.blur="cargo_id" class="@error('cargo_id') input-error @enderror">
                                <option value="">Seleccione un cargo...</option>
                                @foreach($cargos as $cargo)
                                    <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cargo_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TAB ACCESO -->
                    @if($user)
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
                    @endif

                    <!-- TAB SEGURIDAD -->
                    <div x-show="activeTab === 'seguridad'" x-transition class="g_tab_content">
                        @if($user)
                            <div class="g_panel_seccion_especial">
                                <h3>Restablecer Contraseña</h3>
                                <p>Si el personal olvidó su contraseña, puedes enviar un enlace de recuperación a su correo electrónico institucional.</p>
                                
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
                        @else
                            <div class="g_vacio">
                                <i class="fa-solid fa-user-slash"></i>
                                <p>Este perfil de personal no tiene una cuenta de usuario vinculada para gestionar seguridad.</p>
                            </div>
                        @endif
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
        window.confirmarEliminarPersonal = function () {
            Swal.fire({
                title: '¿Quieres eliminar este registro?',
                text: "Esta acción no se puede deshacer y el personal perderá el acceso.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarPersonalOn();
                }
            });
        }
    </script>
    @endscript
</div>
