<div>
    <h1>Lista de Cargos</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.cargo.vista.crear') }}">Crear Nuevo Cargo</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cargos as $cargo)
                <tr>
                    <td>{{ $cargo->nombre }}</td>
                    <td>{{ $cargo->descripcion }}</td>
                    <td>{{ $cargo->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('erp.cargo.vista.editar', $cargo->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $cargos->links() }}
</div>
