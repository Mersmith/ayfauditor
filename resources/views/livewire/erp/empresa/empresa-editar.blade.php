<div>
    <h1>Editar Empresa: {{ $razon_social }}</h1>

    <form wire:submit="update">
        <div>
            <label>Cliente Dueño:</label>
            <select wire:model="cliente_id">
                <option value="">Seleccione un cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
            @error('cliente_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Tipo de Documento:</label>
            <select wire:model="tipo_documento_empresa_id">
                <option value="">Seleccione tipo</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }} ({{ $tipo->abreviatura }})</option>
                @endforeach
            </select>
            @error('tipo_documento_empresa_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Número de Documento:</label>
            <input type="text" wire:model="numero_documento">
            @error('numero_documento') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Razón Social:</label>
            <input type="text" wire:model="razon_social">
            @error('razon_social') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Nombre Comercial:</label>
            <input type="text" wire:model="nombre_comercial">
            @error('nombre_comercial') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Dirección Fiscal:</label>
            <textarea wire:model="direccion_fiscal"></textarea>
            @error('direccion_fiscal') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Teléfono:</label>
            <input type="text" wire:model="telefono">
            @error('telefono') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Correo Electrónico:</label>
            <input type="email" wire:model="correo">
            @error('correo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Sitio Web:</label>
            <input type="text" wire:model="website">
            @error('website') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Logo Actual:</label>
            @if ($empresa->hasMedia('logo'))
                <img src="{{ $empresa->getFirstMediaUrl('logo') }}" alt="Logo" style="width: 100px; height: 100px; object-fit: contain;">
            @else
                <p>No tiene logo</p>
            @endif
            <input type="file" wire:model="logo" accept="image/*">
            @error('logo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Escudo Actual:</label>
            @if ($empresa->hasMedia('escudo'))
                <img src="{{ $empresa->getFirstMediaUrl('escudo') }}" alt="Escudo" style="width: 100px; height: 100px; object-fit: contain;">
            @else
                <p>No tiene escudo</p>
            @endif
            <input type="file" wire:model="escudo" accept="image/*">
            @error('escudo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar Empresa</button>
            <a href="{{ route('erp.empresa.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar esta empresa?') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Eliminar Registro
        </button>
    </div>
</div>
