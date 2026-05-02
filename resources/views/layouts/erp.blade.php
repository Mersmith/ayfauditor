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
        <a href="{{ route('erp.empresa.vista.crear') }}">Nueva</a>

        &nbsp;&nbsp;||&nbsp;&nbsp;

        <strong>⚙️ Configuración:</strong>
        <a href="{{ route('erp.tipo-documento-empresa.vista.lista') }}">Tipos Documento</a>
    </nav>

    <hr>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>

</html>