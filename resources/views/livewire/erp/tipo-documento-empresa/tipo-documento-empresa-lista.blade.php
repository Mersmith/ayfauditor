<div>
    <h1>Tipos de Documento Empresa</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.tipo-documento-empresa.vista.crear') }}">Crear Nuevo Tipo</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Abreviatura</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->nombre }}</td>
                    <td>{{ $tipo->abreviatura }}</td>
                    <td>{{ $tipo->activo ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('erp.tipo-documento-empresa.vista.editar', $tipo->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tipos->links() }}
</div>
