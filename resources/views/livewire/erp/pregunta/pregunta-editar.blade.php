<div>
    <h1>Editar Pregunta</h1>

    <form wire:submit="update">
        <div>
            <label>Texto de la Pregunta:</label>
            <input type="text" wire:model="texto" style="width: 100%;">
            @error('texto') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Categoría:</label>
            <select wire:model="categoria_pregunta_id">
                <option value="">-- Sin Categoría --</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                @endforeach
            </select>
            @error('categoria_pregunta_id') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Descripción de Ayuda (para el auditor):</label>
            <textarea wire:model="descripcion_ayuda" style="width: 100%;"></textarea>
            @error('descripcion_ayuda') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Orden Sugerido:</label>
            <input type="number" wire:model="orden_sugerido">
            @error('orden_sugerido') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Actualizar Pregunta</button>
            <a href="{{ route('erp.pregunta.vista.lista') }}">Cancelar</a>
        </div>
    </form>

    <hr style="margin-top: 20px;">
    <div style="background-color: #fee; padding: 10px;">
        <h3>Zona Peligrosa</h3>
        <button type="button" onclick="confirm('¿Eliminar esta pregunta?') || event.stopImmediatePropagation()" wire:click="delete" style="color: red;">
            Eliminar Registro
        </button>
    </div>
</div>
