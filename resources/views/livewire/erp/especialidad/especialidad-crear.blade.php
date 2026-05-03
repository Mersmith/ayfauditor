<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="store" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Registrar Nueva Especialidad</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.especialidad.vista.lista') }}" class="g_boton light">
                Lista <i class="fa-solid fa-list"></i>
            </a>

            <button type="button" class="g_boton dark" onclick="history.back()">
                <i class="fa-solid fa-arrow-left"></i> Regresar</button>
        </div>
    </div>

    <form wire:submit="store" class="formulario">
        <div class="g_fila">
            <div class="g_columna_8">
                <div class="g_panel" x-data="{ activeTab: 'general' }">
                    
                    <div class="g_tab_navegacion">
                        <div class="g_tab_botones">
                            <button type="button" @click="activeTab = 'general'"
                                :class="activeTab === 'general' ? 'g_tab_active' : 'g_tab_inactive'"
                                class="g_tab_boton">
                                <i class="fa-solid fa-circle-info"></i> Información General
                            </button>

                            <button type="button" @click="activeTab = 'visual'"
                                :class="activeTab === 'visual' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-palette"></i> Identidad Visual
                            </button>
                        </div>
                    </div>

                    <!-- TAB GENERAL -->
                    <div x-show="activeTab === 'general'" x-transition class="g_tab_content">
                        <div class="g_margin_bottom_15">
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
                            <label for="nombre">
                                Nombre de la Especialidad <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" id="nombre" wire:model.blur="nombre"
                                class="@error('nombre') input-error @enderror" autocomplete="off" placeholder="Ej: Auditoría de Sistemas">
                            @error('nombre')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" wire:model.blur="descripcion" rows="3"
                                class="@error('descripcion') input-error @enderror" placeholder="Breve descripción de la especialidad..."></textarea>
                            @error('descripcion')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TAB VISUAL -->
                    <div x-show="activeTab === 'visual'" x-transition class="g_tab_content">
                        <div class="g_fila">
                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="color">Color Representativo</label>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="color" id="color" wire:model.live="color" style="width: 50px; height: 38px; padding: 2px;">
                                    <input type="text" wire:model.blur="color" placeholder="#000000">
                                </div>
                                @error('color')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="icono">Icono (FontAwesome)</label>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="text" id="icono" wire:model.blur="icono" placeholder="fa-solid fa-graduation-cap">
                                    <div class="g_badge light" style="padding: 10px;">
                                        <i class="{{ $icono ?: 'fa-solid fa-question' }}"></i>
                                    </div>
                                </div>
                                @error('icono')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="formulario_botones g_tab_form_buttons">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">
                                <i class="fa-solid fa-save"></i> Registrar Especialidad
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
                    <h3>Previsualización</h3>
                    <p class="g_inferior g_margin_bottom_15">Así se verá en las listas del staff.</p>
                    
                    <div style="padding: 20px; border: 1px dashed #ddd; border-radius: 8px; text-align: center;">
                        <div style="background-color: {{ $color }}; color: #fff; padding: 15px; border-radius: 8px; display: inline-flex; flex-direction: column; align-items: center; gap: 10px; min-width: 120px;">
                            <i class="{{ $icono ?: 'fa-solid fa-question' }} fa-2x"></i>
                            <span style="font-weight: bold;">{{ $nombre ?: 'Especialidad' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
