<div>
    <h1>Editar Personal: {{ $nombre }}</h1>

    <form wire:submit="update">
        <div>
            <label>Nombre Completo:</label>
            <input type="text" wire:model="nombre">
            @error('nombre') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>DNI / Documento:</label>
            <input type="text" wire:model="dni">
            @error('dni') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Celular:</label>
            <input type="text" wire:model="celular">
            @error('celular') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar Datos</button>
            <a href="{{ route('erp.personal.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    
    <h3>Empresas Asociadas</h3>
    <ul>
        @forelse($personal->empresas as $empresa)
            <li>
                🏢 {{ $empresa->razon_social }} - 
                <strong>🏷️ {{ \App\Models\Cargo::find($empresa->pivot->cargo_id)?->nombre ?? 'N/A' }}</strong>
            </li>
        @empty
            <li>Este personal no está vinculado a ninguna empresa aún.</li>
        @endforelse
    </ul>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar permanentemente a esta persona?') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Eliminar Registro
        </button>
    </div>
</div>
