<div>
    <h1>Registrar Personal</h1>

    <form wire:submit="save">
        <h3>Datos Personales</h3>
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

        <hr>

        <h3>Vinculación Laboral (Opcional)</h3>
        <p><small>Puedes saltar este paso y vincularlo luego.</small></p>
        
        <div>
            <label>Empresa:</label>
            <select wire:model="empresa_id">
                <option value="">-- No vincular ahora --</option>
                @foreach ($empresas as $empresa)
                    <option value="{{ $empresa->id }}">{{ $empresa->razon_social }}</option>
                @endforeach
            </select>
            @error('empresa_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Cargo en esa Empresa:</label>
            <select wire:model="cargo_id">
                <option value="">-- Sin cargo específico --</option>
                @foreach ($cargos as $cargo)
                    <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                @endforeach
            </select>
            @error('cargo_id') <span>{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 20px;">
            <button type="submit">Registrar Personal</button>
            <a href="{{ route('erp.personal.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
