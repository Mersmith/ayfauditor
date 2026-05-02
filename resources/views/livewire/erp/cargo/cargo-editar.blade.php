<div>
    <h1>Editar Cargo: {{ $nombre }}</h1>

    <form wire:submit="update">
        <div>
            <label>Nombre del Cargo:</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Descripción:</label>
            <textarea wire:model="descripcion"></textarea>
            @error('descripcion') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar</button>
            <a href="{{ route('erp.cargo.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar este cargo?') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Eliminar Registro
        </button>
    </div>
</div>
