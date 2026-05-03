<div>
    <h1>Crear Tipo de Documento Empresa</h1>

    <form wire:submit="save">
        <div>
            <label>Nombre (Ej: RUC, NIT):</label>
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
            <button type="submit">Guardar</button>
            <a href="{{ route('erp.tipo-documento-empresa.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
