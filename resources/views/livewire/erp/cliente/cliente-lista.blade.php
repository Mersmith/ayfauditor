<div>
    <h1>Lista de Clientes</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>DNI</th>
                <th>Celular</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }} ({{ $cliente->user->name }})</td>
                    <td>{{ $cliente->user->email }}</td>
                    <td>{{ $cliente->dni }}</td>
                    <td>{{ $cliente->celular }}</td>
                    <td>
                        <a href="{{ route('erp.cliente.vista.editar', $cliente->id) }}">Editar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $clientes->links() }}
</div>
