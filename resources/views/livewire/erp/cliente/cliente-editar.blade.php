<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, enviarRecuperarClave, eliminarClienteOn"
        message="Procesando..." />

    <!-- CABECERA -->
    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar Cliente: {{ $cliente->nombre }}</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.cliente.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i></a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarCliente()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <div class="g_fila">
        <!-- COLUMNA IZQUIERDA: DATOS -->
        <div class="g_columna_8 g_gap_pagina formulario">
            <form wire:submit="update">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Configuración</h4>

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

                    <h4 class="g_panel_titulo g_margin_top_20">Información General</h4>

                    <div class="g_margin_bottom_10">
                        <label for="nombre">
                            Nombre Completo <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                        </label>
                        <input type="text" id="nombre" wire:model.blur="nombre" class="@error('nombre') input-error @enderror"
                            autocomplete="off">
                        @error('nombre')
                            <p class="mensaje_error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="g_fila">
                        <div class="g_columna_6 g_margin_bottom_10">
                            <label for="dni">
                                DNI / RUC <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" id="dni" wire:model.blur="dni"
                                class="@error('dni') input-error @enderror" autocomplete="off">
                            @error('dni')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_columna_6 g_margin_bottom_10">
                            <label for="celular">Celular</label>
                            <input type="text" id="celular" wire:model.blur="celular"
                                class="@error('celular') input-error @enderror" autocomplete="off">
                            @error('celular')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <h4 class="g_panel_titulo g_margin_top_20">Datos de Acceso</h4>

                    <div class="g_margin_bottom_10">
                        <label for="name">
                            Usuario Login <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                        </label>
                        <input type="text" id="name" wire:model.blur="name" class="@error('name') input-error @enderror"
                            autocomplete="off">
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
            </form>
        </div>

        <!-- COLUMNA DERECHA: SEGURIDAD -->
        <div class="g_columna_4">
            <form wire:submit="enviarRecuperarClave" class="formulario">
                <div class="g_panel">
                    <h4 class="g_panel_titulo">Seguridad</h4>

                    <div class="g_margin_bottom_10">
                        <label>Restablecer Contraseña</label>
                        <input type="text" disabled value="{{ $email }}" class="g_input">
                        <p class="leyenda">Se enviará un enlace de restablecimiento al correo del usuario.</p>
                    </div>

                    <div class="formulario_botones">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled"
                            wire:target="enviarRecuperarClave">
                            <span wire:loading.remove wire:target="enviarRecuperarClave">
                                <i class="fa-solid fa-envelope"></i> Enviar Recuperación
                            </span>
                            <span wire:loading wire:target="enviarRecuperarClave">
                                <i class="fa-solid fa-spinner fa-spin"></i> Enviando...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @script
    <script>
        window.confirmarEliminarCliente = function () {
            Swal.fire({
                title: '¿Quieres eliminar este cliente?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarClienteOn();
                }
            });
        }
    </script>
    @endscript
</div>
