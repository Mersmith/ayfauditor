<div>
    <h1>Empresas</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.empresa.vista.crear') }}">Registrar Nueva Empresa</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Razón Social</th>
                <th>Cliente</th>
                <th>Documento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empresas as $empresa)
                <tr>
                    <td>
                        <strong>{{ $empresa->razon_social }}</strong><br>
                        <small>{{ $empresa->nombre_comercial }}</small>
                    </td>
                    <td>{{ $empresa->cliente->nombre }}</td>
                    <td>{{ $empresa->tipoDocumento->abreviatura }}: {{ $empresa->numero_documento }}</td>
                    <td>{{ $empresa->activo ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('erp.empresa.vista.editar', $empresa->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $empresas->links() }}
</div>
