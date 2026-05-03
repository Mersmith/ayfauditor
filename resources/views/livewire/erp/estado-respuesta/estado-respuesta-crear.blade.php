<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="store" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Registrar Nuevo Estado de Respuesta</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.estado-respuesta.vista.lista') }}" class="g_boton light">
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
                        <div class="g_fila">
                            <div class="g_margin_bottom_15 g_columna_6">
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
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="nombre">
                                Nombre del Estado <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <input type="text" id="nombre" wire:model.blur="nombre"
                                class="@error('nombre') input-error @enderror" placeholder="Ej: Conforme, No Conforme, Observado">
                            @error('nombre')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" wire:model.blur="descripcion" rows="4"
                                class="@error('descripcion') input-error @enderror" placeholder="Describa el significado de este estado para el reporte final..."></textarea>
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
                                <div style="display: flex; gap: 10px;">
                                    <input type="color" id="color" wire:model.live="color" style="width: 50px; height: 38px; padding: 2px;">
                                    <input type="text" wire:model.live="color" placeholder="#000000">
                                </div>
                                @error('color')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="icono">Icono (FontAwesome)</label>
                                <input type="text" id="icono" wire:model.live="icono" placeholder="fa-solid fa-check-circle">
                                <p class="g_inferior">Ej: fa-solid fa-thumbs-up, fa-solid fa-triangle-exclamation</p>
                                @error('icono')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="formulario_botones g_tab_form_buttons">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">
                                <i class="fa-solid fa-save"></i> Registrar Estado
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
                    <h3>Vista Previa</h3>
                    <p class="g_inferior g_margin_bottom_15">Vista previa del indicador de respuesta.</p>
                    
                    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 30px; border: 1px dashed #ddd; border-radius: 8px; background-color: #f9f9f9;">
                        <div style="background-color: {{ $color }}; color: white; padding: 10px 20px; border-radius: 20px; display: flex; align-items: center; gap: 10px; font-weight: 600; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <i class="{{ $icono ?: 'fa-solid fa-question' }}"></i>
                            <span>{{ $nombre ?: 'Nombre del Estado' }}</span>
                        </div>
                        
                        <p style="margin-top: 15px; font-size: 0.85rem; color: #666; text-align: center;">
                            {{ $descripcion ?: 'Sin descripción adicional.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
