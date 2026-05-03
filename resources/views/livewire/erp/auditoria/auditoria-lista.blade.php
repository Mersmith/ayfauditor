<div>
    <h1>Sesiones de Auditoría</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.auditoria.vista.crear') }}">Iniciar Nueva Auditoría</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Título</th>
                <th>Empresa</th>
                <th>Plantilla Base</th>
                <th>Fechas</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auditorias as $aud)
                <tr>
                    <td>
                        <strong>{{ $aud->titulo }}</strong>
                    </td>
                    <td>{{ $aud->empresa->razon_social }}</td>
                    <td>{{ $aud->plantilla->nombre ?? 'Sin Plantilla' }}</td>
                    <td>
                        <small>
                            Del: {{ $aud->fecha_inicio ?? '?' }} <br>
                            Al: {{ $aud->fecha_fin ?? '?' }}
                        </small>
                    </td>
                    <td>
                        @if($aud->estado)
                            <span style="color: {{ $aud->estado->color }};">
                                <i class="{{ $aud->estado->icono }}"></i> {{ $aud->estado->nombre }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('erp.auditoria.vista.editar', $aud->id) }}">Gestionar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $auditorias->links() }}
</div>
