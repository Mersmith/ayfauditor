<div>
    <h1>Equipo de Trabajo (Sistema)</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.trabajador.vista.crear') }}">Registrar Nuevo Integrante</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Usuario / Email</th>
                <th>Especialidad</th>
                <th>Cargo</th>
                <th>Reg. Prof.</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trabajadores as $trabajador)
                <tr>
                    <td>{{ $trabajador->nombre }}</td>
                    <td>{{ $trabajador->user->email }}</td>
                    <td>{{ $trabajador->especialidad->nombre ?? 'N/A' }}</td>
                    <td>{{ $trabajador->cargo->nombre ?? 'N/A' }}</td>
                    <td>{{ $trabajador->registro_profesional }}</td>
                    <td>{{ $trabajador->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('erp.trabajador.vista.editar', $trabajador->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $trabajadores->links() }}
</div>
