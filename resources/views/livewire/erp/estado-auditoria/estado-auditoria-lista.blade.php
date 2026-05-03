<div>
    <h1>Estados de Auditoría</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.estado-auditoria.vista.crear') }}">Crear Nuevo Estado</a>
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
            @foreach ($estados as $est)
                <tr>
                    <td><i class="{{ $est->icono }}" style="color: {{ $est->color }};"></i></td>
                    <td>{{ $est->nombre }}</td>
                    <td>{{ $est->descripcion }}</td>
                    <td>
                        <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $est->color }}; border: 1px solid #ccc; vertical-align: middle;"></span>
                        {{ $est->color }}
                    </td>
                    <td>{{ $est->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('erp.estado-auditoria.vista.editar', $est->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $estados->links() }}
</div>
