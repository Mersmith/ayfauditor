<div>
    <h1>Participantes en Auditorías</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="margin-bottom: 10px;">
        <a href="{{ route('erp.participante-auditoria.vista.crear') }}">Asignar Nuevo Participante</a>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Auditoría</th>
                <th>Usuario / Perfil</th>
                <th>Rol (Cargo)</th>
                <th>Invitado por</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($participantes as $part)
                <tr>
                    <td>{{ $part->auditoria->titulo }}</td>
                    <td>
                        <strong>{{ $part->user->name }}</strong> <br>
                        <small style="color: gray;">
                            @if($part->user->trabajador) 💼 Trabajador (Staff)
                            @elseif($part->user->cliente) 👤 Cliente
                            @elseif($part->user->personal) 🤝 Personal Externo
                            @else ❓ Sin Perfil
                            @endif
                        </small>
                    </td>
                    <td>
                        <span style="color: {{ $part->cargo->color }};">
                            <i class="{{ $part->cargo->icono }}"></i> {{ $part->cargo->nombre }}
                        </span>
                    </td>
                    <td>{{ $part->invitadoPor->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('erp.participante-auditoria.vista.editar', $part->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $participantes->links() }}
</div>
