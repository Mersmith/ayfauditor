<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="store" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Registrar Nuevo Trabajador</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.trabajador.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="store" class="formulario">
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
                                class="@error('nombre') input-error @enderror" autocomplete="off" placeholder="Ej: Juan Alberto Pérez Rodríguez">
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
                                class="@error('registro_profesional') input-error @enderror" placeholder="Ej: CIP 123456">
                            @error('registro_profesional')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TAB ACCESO -->
                    <div x-show="activeTab === 'acceso'" x-transition class="g_tab_content">
                        <div class="g_margin_bottom_10">
                            <label for="name">
                                Usuario Login <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" id="name" wire:model.blur="name"
                                class="@error('name') input-error @enderror" placeholder="Ej: jperez">
                            @error('name')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="email">
                                Correo Electrónico <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="email" id="email" wire:model.blur="email"
                                class="@error('email') input-error @enderror" placeholder="jperez@empresa.com">
                            @error('email')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="password">
                                Contraseña <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="password" id="password" wire:model.blur="password"
                                class="@error('password') input-error @enderror">
                            @error('password')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="formulario_botones g_tab_form_buttons">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">
                                <i class="fa-solid fa-save"></i> Registrar Trabajador
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
        </div>
    </form>
</div>
