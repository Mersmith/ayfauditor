<div>
    <h1>Registrar Respuesta</h1>

    <form wire:submit="save">
        <div>
            <label>Auditoría:</label>
            <select wire:model="auditoria_id">
                <option value="">-- Seleccionar Sesión --</option>
                @foreach($auditorias as $aud)
                    <option value="{{ $aud->id }}">{{ $aud->titulo }}</option>
                @endforeach
            </select>
            @error('auditoria_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Pregunta:</label>
            <select wire:model="pregunta_id">
                <option value="">-- Seleccionar Pregunta --</option>
                @foreach($preguntas as $preg)
                    <option value="{{ $preg->id }}">{{ $preg->texto }}</option>
                @endforeach
            </select>
            @error('pregunta_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Respuesta / Hallazgo / Evidencia:</label>
            <textarea wire:model="respuesta_cliente" style="width: 100%;"></textarea>
            @error('respuesta_cliente') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Estado de la Respuesta:</label>
            <select wire:model="estado_respuesta_id">
                @foreach($estados as $est)
                    <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                @endforeach
            </select>
            @error('estado_respuesta_id') <span>{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 20px;">
            <div>
                <label>Fecha Inicio Gestión:</label>
                <input type="date" wire:model="fecha_inicio">
            </div>
            <div>
                <label>Fecha Resolución:</label>
                <input type="date" wire:model="fecha_fin">
            </div>
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Guardar Respuesta</button>
            <a href="{{ route('erp.respuesta.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
