<div>
    <h1>Crear Pregunta</h1>

    <form wire:submit="save">
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
            <button type="submit">Guardar Pregunta</button>
            <a href="{{ route('erp.pregunta.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
