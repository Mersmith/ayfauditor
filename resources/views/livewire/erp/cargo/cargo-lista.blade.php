<div>
    <h1>Cargos (Administrativos y Auditoría)</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.cargo.vista.crear') }}">Crear Nuevo Cargo</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Icono</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Slug (Audit)</th>
                <th>Descripción</th>
                <th>Color</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cargos as $car)
                <tr>
                    <td><i class="{{ $car->icono }}" style="color: {{ $car->color }};"></i></td>
                    <td>{{ $car->nombre }}</td>
                    <td>
                        <span style="padding: 2px 5px; background: {{ $car->tipo === 'auditoria' ? '#fef3c7' : '#e0f2fe' }}; border-radius: 4px;">
                            {{ ucfirst($car->tipo) }}
                        </span>
                    </td>
                    <td><code>{{ $car->slug ?? '-' }}</code></td>
                    <td>{{ $car->descripcion }}</td>
                    <td>
                        <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $car->color }}; border: 1px solid #ccc; vertical-align: middle;"></span>
                        {{ $car->color }}
                    </td>
                    <td>{{ $car->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('erp.cargo.vista.editar', $car->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $cargos->links() }}
</div>
