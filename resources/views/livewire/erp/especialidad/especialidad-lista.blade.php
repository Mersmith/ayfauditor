<div>
    <h1>Lista de Especialidades</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.especialidad.vista.crear') }}">Crear Nueva Especialidad</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Icono</th>
                <th>Color</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->nombre }}</td>
                    <td>{{ $especialidad->descripcion }}</td>
                    <td><i class="{{ $especialidad->icono }}"></i> {{ $especialidad->icono }}</td>
                    <td>
                        <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $especialidad->color }}; border: 1px solid #ccc; vertical-align: middle;"></span>
                        {{ $especialidad->color }}
                    </td>
                    <td>{{ $especialidad->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('erp.especialidad.vista.editar', $especialidad->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $especialidades->links() }}
</div>
