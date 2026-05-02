<div>
    <h1>Crear Nuevo Cargo</h1>

    <form wire:submit="save">
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
            <button type="submit">Guardar Cargo</button>
            <a href="{{ route('erp.cargo.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
