<div>
    <h1>Plantillas de Auditoría</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.plantilla.vista.crear') }}">Crear Nueva Plantilla</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>N° Preguntas</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($plantillas as $plan)
                <tr>
                    <td>{{ $plan->nombre }}</td>
                    <td><small>{{ $plan->descripcion }}</small></td>
                    <td>{{ $plan->preguntas_count }}</td>
                    <td>{{ $plan->activo ? 'Activa' : 'Inactiva' }}</td>
                    <td>
                        <a href="{{ route('erp.plantilla.vista.editar', $plan->id) }}">Editar / Ver Preguntas</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $plantillas->links() }}
</div>
