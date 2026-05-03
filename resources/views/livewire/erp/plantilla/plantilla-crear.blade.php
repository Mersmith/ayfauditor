<div>
    <h1>Crear Plantilla</h1>

    <form wire:submit="save">
        <div>
            <label>Nombre de la Plantilla:</label>
            <input type="text" wire:model="nombre" placeholder="Ej: Auditoría IT Nivel 1">
            @error('nombre') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Descripción:</label>
            <textarea wire:model="descripcion"></textarea>
            @error('descripcion') <span>{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Activo:</label>
            <input type="checkbox" wire:model="activo">
        </div>

        <hr>

        <h3>Seleccionar Preguntas para esta Plantilla</h3>
        @error('preguntas_seleccionadas') <p style="color: red;">{{ $message }}</p> @enderror

        <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
            @foreach($bancoPreguntas->groupBy('categoria.nombre') as $catNombre => $preguntas)
                <h4>{{ $catNombre ?: 'Sin Categoría' }}</h4>
                @foreach($preguntas as $preg)
                    <div style="margin-bottom: 5px;">
                        <input type="checkbox" wire:model="preguntas_seleccionadas" value="{{ $preg->id }}" id="preg_{{ $preg->id }}">
                        <label for="preg_{{ $preg->id }}" style="font-weight: normal; cursor: pointer;">
                            {{ $preg->texto }}
                        </label>
                    </div>
                @endforeach
            @endforeach
        </div>

        <div style="margin-top: 10px;">
            <button type="submit">Guardar Plantilla</button>
            <a href="{{ route('erp.plantilla.vista.lista') }}">Cancelar</a>
        </div>
    </form>
</div>
