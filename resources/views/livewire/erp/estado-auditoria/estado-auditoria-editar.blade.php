<div>
    <h1>Editar Estado: {{ $nombre }}</h1>

    <form wire:submit="update">
        <div>
            <label>Nombre:</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Descripción:</label>
            <textarea wire:model="descripcion"></textarea>
            @error('descripcion') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Color:</label>
            <input type="text" wire:model="color" placeholder="Ej: #3b82f6">
            @error('color') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Icono (FontAwesome):</label>
            <input type="text" wire:model="icono" placeholder="Ej: fa-solid fa-clock">
            @error('icono') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar Estado</button>
            <a href="{{ route('erp.estado-auditoria.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar este estado?') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Eliminar Registro
        </button>
    </div>
</div>
