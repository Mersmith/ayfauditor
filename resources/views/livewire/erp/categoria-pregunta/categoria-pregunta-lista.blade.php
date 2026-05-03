<div>
    <h1>Categorías de Preguntas</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.categoria-pregunta.vista.crear') }}">Crear Nueva Categoría</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Icono</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Color</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $cat)
                <tr>
                    <td><i class="{{ $cat->icono }}"></i></td>
                    <td>{{ $cat->nombre }}</td>
                    <td>{{ $cat->descripcion }}</td>
                    <td>
                        <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $cat->color }}; border: 1px solid #ccc; vertical-align: middle;"></span>
                        {{ $cat->color }}
                    </td>
                    <td>{{ $cat->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('erp.categoria-pregunta.vista.editar', $cat->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categorias->links() }}
</div>
