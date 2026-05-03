<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="update, eliminarEmpresaOn" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Editar Empresa: {{ $empresa->razon_social }}</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.empresa.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton danger" onclick="confirmarEliminarEmpresa()">
                Eliminar <i class="fa-solid fa-trash-can"></i>
            </button>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="update" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel" x-data="{ activeTab: 'general' }">

                    <div class="g_tab_navegacion">
                        <div class="g_tab_botones">
                            <button type="button" @click="activeTab = 'general'"
                                :class="activeTab === 'general' ? 'g_tab_active' : 'g_tab_inactive'"
                                class="g_tab_boton">
                                <i class="fa-solid fa-building"></i> Información General
                            </button>

                            <button type="button" @click="activeTab = 'contacto'"
                                :class="activeTab === 'contacto' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-address-book"></i> Contacto y Ubicación
                            </button>

                            <button type="button" @click="activeTab = 'multimedia'"
                                :class="activeTab === 'multimedia' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-images"></i> Logos y Sello
                            </button>
                        </div>
                    </div>

                    <!-- TAB GENERAL -->
                    <div x-show="activeTab === 'general'" x-transition class="g_tab_content">
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
                                    {{ $activo ? 'Activa' : 'Inactiva' }}
                                </span>

                                @error('activo')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="cliente_id">
                                Cliente Principal <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="cliente_id" wire:model.blur="cliente_id" class="@error('cliente_id') input-error @enderror">
                                <option value="">Seleccione un cliente...</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="razon_social">
                                Razón Social <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" id="razon_social" wire:model.blur="razon_social"
                                class="@error('razon_social') input-error @enderror" autocomplete="off">
                            @error('razon_social')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="nombre_comercial">
                                Nombre Comercial
                            </label>
                            <input type="text" id="nombre_comercial" wire:model.blur="nombre_comercial"
                                class="@error('nombre_comercial') input-error @enderror" autocomplete="off">
                            @error('nombre_comercial')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_fila">
                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="tipo_documento_empresa_id">
                                    Tipo de Documento <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                                </label>
                                <select id="tipo_documento_empresa_id" wire:model.blur="tipo_documento_empresa_id"
                                    class="@error('tipo_documento_empresa_id') input-error @enderror">
                                    <option value="">Seleccione...</option>
                                    @foreach($tiposDocumento as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }} ({{ $tipo->abreviatura }})</option>
                                    @endforeach
                                </select>
                                @error('tipo_documento_empresa_id')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="numero_documento">
                                    Número de Documento <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                                </label>
                                <input type="text" id="numero_documento" wire:model.blur="numero_documento"
                                    class="@error('numero_documento') input-error @enderror" autocomplete="off">
                                @error('numero_documento')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- TAB CONTACTO -->
                    <div x-show="activeTab === 'contacto'" x-transition class="g_tab_content">
                        <div class="g_margin_bottom_10">
                            <label for="direccion_fiscal">
                                Dirección Fiscal
                            </label>
                            <input type="text" id="direccion_fiscal" wire:model.blur="direccion_fiscal"
                                class="@error('direccion_fiscal') input-error @enderror">
                            @error('direccion_fiscal')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_fila">
                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="correo">
                                    Correo Electrónico Corporativo
                                </label>
                                <input type="email" id="correo" wire:model.blur="correo"
                                    class="@error('correo') input-error @enderror">
                                @error('correo')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="telefono">
                                    Teléfono / Celular
                                </label>
                                <input type="text" id="telefono" wire:model.blur="telefono"
                                    class="@error('telefono') input-error @enderror">
                                @error('telefono')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="website">
                                Sitio Web (URL)
                            </label>
                            <input type="url" id="website" wire:model.blur="website"
                                class="@error('website') input-error @enderror">
                            @error('website')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TAB MULTIMEDIA -->
                    <div x-show="activeTab === 'multimedia'" x-transition class="g_tab_content">
                        <div class="g_fila">
                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="logo">Logotipo</label>
                                <input type="file" id="logo" wire:model="logo" accept="image/*">
                                <div class="g_margin_top_10">
                                    @if ($logo)
                                        <div class="g_label_previsualizacion">Nueva imagen:</div>
                                        <img src="{{ $logo->temporaryUrl() }}" class="g_previsualizacion_imagen">
                                    @elseif ($empresa->hasMedia('logo'))
                                        <div class="g_label_previsualizacion">Imagen actual:</div>
                                        <img src="{{ $empresa->getFirstMediaUrl('logo') }}" class="g_previsualizacion_imagen">
                                    @endif
                                </div>
                                @error('logo')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="escudo">Escudo / Sello</label>
                                <input type="file" id="escudo" wire:model="escudo" accept="image/*">
                                <div class="g_margin_top_10">
                                    @if ($escudo)
                                        <div class="g_label_previsualizacion">Nueva imagen:</div>
                                        <img src="{{ $escudo->temporaryUrl() }}" class="g_previsualizacion_imagen">
                                    @elseif ($empresa->hasMedia('escudo'))
                                        <div class="g_label_previsualizacion">Imagen actual:</div>
                                        <img src="{{ $empresa->getFirstMediaUrl('escudo') }}" class="g_previsualizacion_imagen">
                                    @endif
                                </div>
                                @error('escudo')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="formulario_botones g_tab_form_buttons">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="update, logo, escudo">
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
        window.confirmarEliminarEmpresa = function () {
            Swal.fire({
                title: '¿Quieres eliminar esta empresa?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.eliminarEmpresaOn();
                }
            });
        }
    </script>
    @endscript
</div>
