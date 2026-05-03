<div>
    <h1>Iniciar Nueva Auditoría</h1>

    <form wire:submit="save">
        <div>
            <label>Título / Nombre de la Sesión:</label>
            <input type="text" wire:model="titulo" placeholder="Ej: Auditoría Anual 2024">
            @error('titulo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Empresa a Auditar:</label>
            <select wire:model="empresa_id">
                <option value="">-- Seleccionar Empresa --</option>
                @foreach($empresas as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->razon_social }}</option>
                @endforeach
            </select>
            @error('empresa_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Plantilla de Preguntas (Base):</label>
            <select wire:model="plantilla_id">
                <option value="">-- Sin Plantilla (Vacia) --</option>
                @foreach($plantillas as $plan)
                    <option value="{{ $plan->id }}">{{ $plan->nombre }} ({{ $plan->preguntas_count }} preguntas)</option>
                @endforeach
            </select>
            @error('plantilla_id') <span>{{ $message }}</span> @enderror
            <p><small>Al seleccionar una plantilla, se cargarán automáticamente las preguntas en la sesión.</small></p>
        </div>

        <div>
            <label>Estado Inicial:</label>
            <select wire:model="estado_auditoria_id">
                @foreach($estados as $est)
                    <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                @endforeach
            </select>
            @error('estado_auditoria_id') <span>{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 20px;">
            <div>
                <label>Fecha Inicio:</label>
                <input type="date" wire:model="fecha_inicio">
                @error('fecha_inicio') <span>{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Fecha Fin (Estimada):</label>
                <input type="date" wire:model="fecha_fin">
                @error('fecha_fin') <span>{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit">Crear y Cargar Preguntas</button>
            <a href="{{ route('erp.auditoria.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
