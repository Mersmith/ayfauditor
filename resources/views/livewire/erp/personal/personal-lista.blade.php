<div>
    <h1>Personal de Empresas</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.personal.vista.crear') }}">Registrar Nuevo Personal</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Celular</th>
                <th>Empresas / Cargos</th>
                <th>Usuario Sistema</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($personals as $persona)
                <tr>
                    <td>{{ $persona->nombre }}</td>
                    <td>{{ $persona->dni }}</td>
                    <td>{{ $persona->celular }}</td>
                    <td>
                        @foreach ($persona->empresas as $empresa)
                            <div>
                                🏢 {{ $empresa->razon_social }} <br>
                                <small>🏷️ {{ \App\Models\Cargo::find($empresa->pivot->cargo_id)?->nombre ?? 'N/A' }}</small>
                            </div>
                        @endforeach
                    </td>
                    <td>
                        {{ $persona->user->email ?? 'Sin acceso' }}
                    </td>
                    <td>{{ $persona->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('erp.personal.vista.editar', $persona->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $personals->links() }}
</div>
