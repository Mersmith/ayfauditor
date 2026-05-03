<div>
    <h1>Registrar Empresa</h1>

    <form wire:submit="save">
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
            <label>Logo:</label>
            <input type="file" wire:model="logo" accept="image/*">
            @error('logo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Escudo:</label>
            <input type="file" wire:model="escudo" accept="image/*">
            @error('escudo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Registrar Empresa</button>
            <a href="{{ route('erp.empresa.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
