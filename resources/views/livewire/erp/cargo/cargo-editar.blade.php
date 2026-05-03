<div>
    <h1>Editar Cargo: {{ $nombre }}</h1>

    <form wire:submit="update">
        <div>
            <label>Tipo:</label>
            <select wire:model.live="tipo">
                <option value="administrativo">Administrativo (Staff)</option>
                <option value="auditoria">Auditoría (Rol en Sesión)</option>
            </select>
            @error('tipo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Nombre:</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span>{{ $message }}</span> @enderror
        </div>

        @if($tipo === 'auditoria')
        <div>
            <label>Slug (Identificador único para lógica):</label>
            <input type="text" wire:model="slug">
            @error('slug') <span>{{ $message }}</span> @enderror
        </div>
        @endif

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
            <input type="text" wire:model="icono" placeholder="Ej: fa-solid fa-user">
            @error('icono') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar Cargo</button>
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
