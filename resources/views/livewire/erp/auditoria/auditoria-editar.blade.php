<div>
    <h1>Gestionar Auditoría: {{ $titulo }}</h1>

    <form wire:submit="update">
        <div>
            <label>Título:</label>
            <input type="text" wire:model="titulo">
            @error('titulo') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Empresa:</label>
            <select wire:model="empresa_id">
                @foreach($empresas as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->razon_social }}</option>
                @endforeach
            </select>
            @error('empresa_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Plantilla Utilizada:</label>
            <input type="text" value="{{ $auditoria->plantilla->nombre ?? 'N/A' }}" disabled>
            <p><small>La plantilla no se puede cambiar una vez iniciada la auditoría.</small></p>
        </div>

        <div>
            <label>Estado de la Auditoría:</label>
            <select wire:model="estado_auditoria_id">
                @foreach($estados as $est)
                    <option value="{{ $est->id }}">{{ $est->nombre }}</option>
                @endforeach
            </select>
            @error('estado_auditoria_id') <span>{{ $message }}</span> @enderror
        </div>

        <div style="display: flex; gap: 20px;">
            <div>
                <label>Fecha Inicio:</label>
                <input type="date" wire:model="fecha_inicio">
                @error('fecha_inicio') <span>{{ $message }}</span> @enderror
            </div>
            <div>
                <label>Fecha Fin:</label>
                <input type="date" wire:model="fecha_fin">
                @error('fecha_fin') <span>{{ $message }}</span> @enderror
            </div>
        </div>

        <div style="margin-top: 20px;">
            <button type="submit">Actualizar Datos</button>
            <a href="{{ route('erp.auditoria.vista.lista') }}">Volver al Listado</a>
        </div>
    </form>

    <hr style="margin-top: 30px;">
    
    <div>
        <h3>Accesos Rápidos</h3>
        <ul>
            <li><a href="#">Gestionar Participantes (Próximamente)</a></li>
            <li><a href="#">Ir a Responder Preguntas (Próximamente)</a></li>
            <li><a href="#">Generar Informe (Próximamente)</a></li>
        </ul>
    </div>

    <hr style="margin-top: 30px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar esta sesión de auditoría? Se perderán todas las respuestas.') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Eliminar Sesión Completa
        </button>
    </div>
</div>
