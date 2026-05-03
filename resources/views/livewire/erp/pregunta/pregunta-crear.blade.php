<div class="g_gap_pagina">
    <x-loading-overlay wire:loading wire:target="store" message="Procesando..." />

    <div class="g_panel cabecera_titulo_pagina">
        <h2>Registrar Nueva Pregunta</h2>

        <div class="cabecera_titulo_botones">
            <a href="{{ route('erp.pregunta.vista.lista') }}" class="g_boton light">
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
                                <i class="fa-solid fa-circle-info"></i> Información de Pregunta
                            </button>

                            <button type="button" @click="activeTab = 'ayuda'"
                                :class="activeTab === 'ayuda' ? 'g_tab_active' : 'g_tab_inactive'" class="g_tab_boton">
                                <i class="fa-solid fa-circle-question"></i> Guía de Ayuda
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
                                        {{ $activo ? 'Activa' : 'Inactiva' }}
                                    </span>

                                    @error('activo')
                                        <p class="mensaje_error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="g_margin_bottom_10 g_columna_6">
                                <label for="orden_sugerido">Orden Sugerido</label>
                                <input type="number" id="orden_sugerido" wire:model.blur="orden_sugerido"
                                    class="@error('orden_sugerido') input-error @enderror" min="0">
                                @error('orden_sugerido')
                                    <p class="mensaje_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="categoria_pregunta_id">
                                Categoría <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <select id="categoria_pregunta_id" wire:model.blur="categoria_pregunta_id"
                                class="@error('categoria_pregunta_id') input-error @enderror">
                                <option value="">Seleccione una categoría...</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                            @error('categoria_pregunta_id')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_margin_bottom_10">
                            <label for="texto">
                                Enunciado de la Pregunta <span class="obligatorio"><i class="fa-solid fa-asterisk"></i></span>
                            </label>
                            <textarea id="texto" wire:model.blur="texto" rows="4"
                                class="@error('texto') input-error @enderror" placeholder="Ej: ¿Cuenta la empresa con un sistema de gestión de seguridad informática?"></textarea>
                            @error('texto')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- TAB AYUDA -->
                    <div x-show="activeTab === 'ayuda'" x-transition class="g_tab_content">
                        <div class="g_margin_bottom_10">
                            <label for="descripcion_ayuda">Descripción de Ayuda / Guía para el Auditor</label>
                            <textarea id="descripcion_ayuda" wire:model.blur="descripcion_ayuda" rows="8"
                                class="@error('descripcion_ayuda') input-error @enderror" 
                                placeholder="Escriba aquí los criterios técnicos o ejemplos que ayudarán al auditor a responder esta pregunta..."></textarea>
                            @error('descripcion_ayuda')
                                <p class="mensaje_error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="g_alert info">
                            <i class="fa-solid fa-info-circle"></i> Esta información será visible para el auditor durante el proceso de respuesta en la sesión.
                        </div>
                    </div>

                    <div class="formulario_botones g_tab_form_buttons">
                        <button type="submit" class="g_boton guardar" wire:loading.attr="disabled" wire:target="store">
                            <span wire:loading.remove wire:target="store">
                                <i class="fa-solid fa-save"></i> Registrar Pregunta
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
                    <h3>Vista Previa del Auditor</h3>
                    <p class="g_inferior g_margin_bottom_15">Así se presentará en la sesión de auditoría.</p>
                    
                    <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px;">
                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">
                            {{ $orden_sugerido > 0 ? $orden_sugerido . '.' : '' }} {{ $texto ?: 'Enunciado de la pregunta...' }}
                        </div>
                        
                        <div style="display: flex; gap: 10px; margin-bottom: 12px;">
                            <div style="flex: 1; height: 35px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff; display: flex; align-items: center; padding-left: 10px; color: #94a3b8; font-size: 0.8rem;">SI</div>
                            <div style="flex: 1; height: 35px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff; display: flex; align-items: center; padding-left: 10px; color: #94a3b8; font-size: 0.8rem;">NO</div>
                            <div style="flex: 1; height: 35px; border: 1px solid #cbd5e1; border-radius: 4px; background: #fff; display: flex; align-items: center; padding-left: 10px; color: #94a3b8; font-size: 0.8rem;">N/A</div>
                        </div>

                        @if($descripcion_ayuda)
                            <div style="background-color: #f1f5f9; padding: 10px; border-radius: 4px; border-left: 3px solid #3b82f6;">
                                <div style="font-size: 0.75rem; font-weight: bold; color: #3b82f6; text-transform: uppercase; margin-bottom: 3px;">
                                    <i class="fa-solid fa-circle-info"></i> Guía de Ayuda:
                                </div>
                                <div style="font-size: 0.85rem; color: #475569; line-height: 1.4;">
                                    {{ $descripcion_ayuda }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
