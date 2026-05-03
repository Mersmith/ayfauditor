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
                <th>Icono</th>
                <th>Color</th>
                <th>Activo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->nombre }}</td>
                    <td>{{ $tipo->abreviatura }}</td>
                    <td><i class="{{ $tipo->icono }}"></i> {{ $tipo->icono }}</td>
                    <td>
                        <span style="display: inline-block; width: 20px; height: 20px; background-color: {{ $tipo->color }}; border: 1px solid #ccc; vertical-align: middle;"></span>
                        {{ $tipo->color }}
                    </td>
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
