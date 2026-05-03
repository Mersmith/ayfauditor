<div>
    <h1>Crear Estado de Auditoría</h1>

    <form wire:submit="save">
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
            <button type="submit">Guardar Estado</button>
            <a href="{{ route('erp.estado-auditoria.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
