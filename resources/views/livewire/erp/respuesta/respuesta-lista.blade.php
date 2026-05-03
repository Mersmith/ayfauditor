<div>
    <h1>Banco de Respuestas (Ejecución)</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <div style="display: flex; gap: 20px; align-items: center; margin-bottom: 20px;">
        <div>
            <label>Filtrar por Auditoría:</label>
            <select wire:model.live="auditoria_id">
                <option value="">-- Todas las Sesiones --</option>
                @foreach($auditorias as $aud)
                    <option value="{{ $aud->id }}">{{ $aud->titulo }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <a href="{{ route('erp.respuesta.vista.crear') }}">Agregar Respuesta Manual</a>
        </div>
    </div>

    <table border="1">
        <thead>
            <tr>
                <th>Auditoría / Empresa</th>
                <th>Pregunta</th>
                <th>Respuesta (Evidencia)</th>
                <th>Estado</th>
                <th>Último Editor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($respuestas as $resp)
                <tr>
                    <td>
                        {{ $resp->auditoria->titulo }} <br>
                        <small>{{ $resp->auditoria->empresa->razon_social }}</small>
                    </td>
                    <td>
                        <small>{{ $resp->pregunta->texto }}</small>
                    </td>
                    <td>
                        {{ Str::limit($resp->respuesta_cliente, 50) }}
                    </td>
                    <td>
                        @if($resp->estado)
                            <span style="color: {{ $resp->estado->color }};">
                                <i class="{{ $resp->estado->icono }}"></i> {{ $resp->estado->nombre }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <small>{{ $resp->updater->name ?? $resp->creator->name ?? 'Sistema' }}</small>
                    </td>
                    <td>
                        <a href="{{ route('erp.respuesta.vista.editar', $resp->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $respuestas->links() }}
</div>
