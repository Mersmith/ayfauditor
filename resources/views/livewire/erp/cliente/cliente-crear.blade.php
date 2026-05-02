<div>
    <h1>Crear Cliente</h1>

    <form wire:submit="save">
        <h3>Datos de Acceso</h3>
        <div>
            <label>Usuario (Login):</label>
            <input type="text" wire:model="name">
            @error('name') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Email:</label>
            <input type="email" wire:model="email">
            @error('email') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Contraseña:</label>
            <input type="password" wire:model="password">
            @error('password') <span>{{ $message }}</span> @enderror
        </div>

        <hr>

        <h3>Datos Personales</h3>
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
            <label>Celular:</label>
            <input type="text" wire:model="celular">
            @error('celular') <span>{{ $message }}</span> @enderror
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Guardar Cliente</button>
            <a href="{{ route('erp.cliente.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
