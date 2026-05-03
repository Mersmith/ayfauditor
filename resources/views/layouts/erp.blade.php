<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ERP - Lógica</title>
    @livewireStyles
</head>

<body>
    <nav>
        <strong>👥 Clientes:</strong>
        <a href="{{ route('erp.cliente.vista.lista') }}">Lista</a> |
        <a href="{{ route('erp.cliente.vista.crear') }}">Nuevo</a>

        &nbsp;&nbsp;||&nbsp;&nbsp;

        <strong>🏢 Empresas:</strong>
        <a href="{{ route('erp.empresa.vista.lista') }}">Lista</a> | 
        <a href="{{ route('erp.empresa.vista.crear') }}">Nueva</a> |
        <a href="{{ route('erp.personal.vista.lista') }}">Personal</a>
        
        &nbsp;&nbsp;||&nbsp;&nbsp;

        <strong>📋 Auditoría:</strong>
        <a href="{{ route('erp.auditoria.vista.lista') }}">Sesiones</a> |
        <a href="{{ route('erp.participante-auditoria.vista.lista') }}">Participantes</a> |
        <a href="{{ route('erp.auditoria.vista.crear') }}">Nueva</a>

        &nbsp;&nbsp;||&nbsp;&nbsp;

        <strong>⚙️ Configuración:</strong>
        <a href="{{ route('erp.trabajador.vista.lista') }}">Equipo (Auditores)</a> |
        <a href="{{ route('erp.tipo-documento-empresa.vista.lista') }}">Tipos Documento</a> |
        <a href="{{ route('erp.cargo.vista.lista') }}">Cargos</a> |
        <a href="{{ route('erp.especialidad.vista.lista') }}">Especialidades</a> |
        <a href="{{ route('erp.categoria-pregunta.vista.lista') }}">Categorías Preguntas</a> |
        <a href="{{ route('erp.pregunta.vista.lista') }}">Banco de Preguntas</a> |
        <a href="{{ route('erp.plantilla.vista.lista') }}">Plantillas</a> |
        <a href="{{ route('erp.estado-auditoria.vista.lista') }}">Estados Auditoría</a>
    </nav>

    <hr>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>