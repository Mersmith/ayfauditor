<div>
    <h1>Editar Respuesta</h1>

    <div style="background-color: #f0f0f0; padding: 10px; margin-bottom: 20px;">
        <p><strong>Auditoría:</strong> {{ $respuesta->auditoria->titulo }}</p>
        <p><strong>Pregunta:</strong> {{ $respuesta->pregunta->texto }}</p>
    </div>

    <form wire:submit="update">
        <div>
            <label>Respuesta / Hallazgo / Evidencia:</label>
            <textarea wire:model="respuesta_cliente" style="width: 100%; height: 100px;"></textarea>
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
            <button type="submit">Actualizar Respuesta</button>
            <a href="{{ route('erp.respuesta.vista.lista') }}">Volver</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar esta respuesta?') || event.stopImmediatePropagation()"
            wire:click="delete" style="color: red;">
            Eliminar Registro
        </button>
    </div>

    @livewire('erp.respuesta.respuesta-comentario', ['respuesta' => $respuesta])

</div>