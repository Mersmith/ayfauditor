<div>
    <h1>Asignar Participante a Auditoría</h1>

    <form wire:submit="save">
        <div>
            <label>Seleccionar Sesión de Auditoría:</label>
            <select wire:model="auditoria_id">
                <option value="">-- Seleccionar Auditoría --</option>
                @foreach($auditorias as $aud)
                    <option value="{{ $aud->id }}">{{ $aud->titulo }} ({{ $aud->empresa->razon_social }})</option>
                @endforeach
            </select>
            @error('auditoria_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Seleccionar Usuario:</label>
            <select wire:model="user_id">
                <option value="">-- Seleccionar Usuario --</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}">
                        {{ $u->name }} 
                        [ @if($u->trabajador) Trabajador @elseif($u->cliente) Cliente @elseif($u->personal) Personal @else N/A @endif ]
                    </option>
                @endforeach
            </select>
            @error('user_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Rol en la Auditoría (Cargo):</label>
            <select wire:model="cargo_id">
                <option value="">-- Seleccionar Rol --</option>
                @foreach($cargos as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
            @error('cargo_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Invitado por (Opcional):</label>
            <select wire:model="invitado_por">
                <option value="">-- Ninguno --</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
            @error('invitado_por') <span>{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Agregar Participante</button>
            <a href="{{ route('erp.participante-auditoria.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
