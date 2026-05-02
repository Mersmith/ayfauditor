<div>
    <h1>Editar Integrante: {{ $nombre }}</h1>

    <form wire:submit="update">
        <div>
            <label>Email de Usuario (No editable):</label>
            <input type="email" value="{{ $trabajador->user->email }}" disabled>
        </div>

        <hr>

        <div>
            <label>Nombre Completo:</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>DNI:</label>
            <input type="text" wire:model="dni">
            @error('dni') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Especialidad Principal:</label>
            <select wire:model="especialidad_id">
                <option value="">-- Seleccione --</option>
                @foreach ($especialidades as $esp)
                    <option value="{{ $esp->id }}">{{ $esp->nombre }}</option>
                @endforeach
            </select>
            @error('especialidad_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Cargo / Rol:</label>
            <select wire:model="cargo_id">
                <option value="">-- Seleccione --</option>
                @foreach ($cargos as $cargo)
                    <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                @endforeach
            </select>
            @error('cargo_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Registro Profesional:</label>
            <input type="text" wire:model="registro_profesional">
            @error('registro_profesional') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 20px;">
            <button type="submit">Actualizar Información</button>
            <a href="{{ route('erp.trabajador.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
