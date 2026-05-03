<div>
    <h1>Editar Participante en Auditoría</h1>

    <div style="background-color: #f0f0f0; padding: 10px; margin-bottom: 20px;">
        <p><strong>Auditoría:</strong> {{ $participante->auditoria->titulo }}</p>
        <p><strong>Participante:</strong> {{ $participante->user->name }}</p>
    </div>

    <form wire:submit="update">
        <div>
            <label>Nuevo Rol en la Auditoría (Cargo):</label>
            <select wire:model="cargo_id">
                @foreach($cargos as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
            @error('cargo_id') <span>{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar Rol</button>
            <a href="{{ route('erp.participante-auditoria.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Retirar a este usuario de la auditoría?') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Quitar Participante
        </button>
    </div>
</div>
