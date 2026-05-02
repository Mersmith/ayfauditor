<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ERP - Lógica</title>
    @livewireStyles
</head>
<body>
    <nav>
        <a href="{{ route('erp.cliente.vista.lista') }}">Lista Clientes</a> | 
        <a href="{{ route('erp.cliente.vista.crear') }}">Crear Cliente</a>
    </nav>

    <hr>

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
