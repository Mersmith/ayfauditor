<div>
    <h1>Registrar Nuevo Integrante de Equipo</h1>

    <form wire:submit="save">
        <h3>Credenciales de Acceso</h3>
        <div>
            <label>Email de Usuario (para iniciar sesión):</label>
            <input type="email" wire:model="email">
            @error('email') <span>{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Contraseña Temporal:</label>
            <input type="password" wire:model="password">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <hr>

        <h3>Información Profesional</h3>
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
            <label>Registro Profesional (Matrícula/Colegiatura):</label>
            <input type="text" wire:model="registro_profesional">
            @error('registro_profesional') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 20px;">
            <button type="submit">Registrar Integrante</button>
            <a href="{{ route('erp.trabajador.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
