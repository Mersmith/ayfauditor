<div>
    <h1>Banco de Preguntas</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.pregunta.vista.crear') }}">Crear Nueva Pregunta</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Orden Sug.</th>
                <th>Pregunta</th>
                <th>Categoría</th>
                <th>Ayuda</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($preguntas as $preg)
                <tr>
                    <td>{{ $preg->orden_sugerido }}</td>
                    <td>{{ $preg->texto }}</td>
                    <td>
                        @if($preg->categoria)
                            <span style="color: {{ $preg->categoria->color }};">
                                <i class="{{ $preg->categoria->icono }}"></i> {{ $preg->categoria->nombre }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td><small>{{ Str::limit($preg->descripcion_ayuda, 50) }}</small></td>
                    <td>{{ $preg->activo ? 'Activa' : 'Inactiva' }}</td>
                    <td>
                        <a href="{{ route('erp.pregunta.vista.editar', $preg->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $preguntas->links() }}
</div>
