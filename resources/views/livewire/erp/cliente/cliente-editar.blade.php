<div>
    <h1>Editar Cliente: {{ $nombre }}</h1>

    <form wire:submit="update">
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
            <label>Nueva Contraseña (dejar en blanco para no cambiar):</label>
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

        <div style="margin-top: 20px;">
            <button type="submit">Actualizar Cliente</button>
            <a href="{{ route('erp.cliente.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 40px;">
    
    <div style="background-color: #fee; padding: 10px; border: 1px solid red;">
        <h3>Zona de Peligro</h3>
        <p>Esta acción realizará un borrado lógico (Soft Delete) del cliente.</p>
        <button type="button" 
                onclick="confirm('¿Estás seguro de que deseas eliminar este cliente?') || event.stopImmediatePropagation()" 
                wire:click="delete" 
                style="color: red;">
            Eliminar Cliente
        </button>
    </div>
</div>
