<div>
    <h1>Editar Tipo de Documento: {{ $nombre }}</h1>

    <form wire:submit="update">
        <div>
            <label>Nombre:</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Abreviatura:</label>
            <input type="text" wire:model="abreviatura">
            @error('abreviatura') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Color:</label>
            <input type="text" wire:model="color" placeholder="Ej: blue, #FF0000">
            @error('color') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Icono (FontAwesome):</label>
            <input type="text" wire:model="icono" placeholder="Ej: fa-solid fa-gear">
            @error('icono') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar</button>
            <a href="{{ route('erp.tipo-documento-empresa.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar este tipo de documento?') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Eliminar Registro
        </button>
    </div>
</div>
