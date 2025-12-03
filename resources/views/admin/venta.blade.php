<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route("ventas.store")  }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Producto</label>

                            @if ($productos->isEmpty())
                                <div class="alert alert-warning mt-2">
                                    No hay registro de productos
                                    <br>
                                    <a href="{{ route('productos.index') }}" class="alert-link"> registra producto </a>
                                </div>
                            @else
                                <select name="id_producto" id="id_producto" class="form-select">
                                    <option value="" selected disabled>Debes seleccionar un producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id_producto }}">
                                            {{ $producto->nombre_producto }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Precio Unitario</label>
                            <input type="text" id="precio_unitario" name="precio_unitario" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Total pago</label>
                            <input type="text" class="form-control" name="total_a_pagar">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
                </form>

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-end mb-4">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Registrar venta
                        </button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Usuario</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio unitario</th>
                                <th scope="col">Total pago</th>
                                <th scope="col">Fecha de creacion</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ventas as $venta)
                                <tr>
                                    <td>{{ $venta->user->name }}</td>
                                    <td>{{ $venta->producto->nombre_producto }}</td>
                                    <td>{{ $venta->cantidad_producto }}</td>
                                    <td>{{ $venta->precio_unitario }}</td>
                                    <td>{{ $venta->total_a_pagar }}</td>
                                    <td>{{ $venta->created_at }}</td>
                                    <td>
                                        @if ($venta->estado_venta  == 1)
                                            <span class="badge bg-success text-uppercase">Activo</span>
                                        @else
                                            <span class="badge bg-danger text-uppercase">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editar_venta{{ $venta->id_venta }}">
                                            Editar
                                        </button>

                                        {{-- <a href="{{ route('producto.archivar', $producto->id_producto) }}"
                                            class="btn btn-warning"
                                            onclick="return confirm('¿Seguro que deseas archivar esta categoría?');">
                                                Archivar
                                        </a> --}}

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">
                                        No existe registro
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @foreach ($ventas as $venta)
    <div class="modal fade" id="editar_venta{{ $venta->id_venta }}" tabindex="-1" aria-labelledby="editarVentaLabel{{ $venta->id_venta }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editarVentaLabel{{ $venta->id_venta }}">
                        Editar Venta #{{ $venta->id_venta }}
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="POST" action="{{ route('ventas.update', $venta->id_venta) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">

                        {{-- Producto --}}
                        <div class="mb-3">
                            <label class="form-label">Producto</label>

                            <select name="id_producto" class="form-select producto-select"
                                    data-precio-id="precio{{ $venta->id_venta }}">
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id_producto }}"
                                        data-precio="{{ $producto->precio_producto }}"
                                        {{ $venta->id_producto == $producto->id_producto ? 'selected' : '' }}>
                                        {{ $producto->nombre_producto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Precio --}}
                        <div class="mb-3">
                            <label class="form-label">Precio Unitario</label>
                            <input type="text"
                                id="precio{{ $venta->id_venta }}"
                                class="form-control"
                                name="precio_unitario"
                                value="{{ $venta->precio_unitario }}"
                                readonly>
                        </div>

                        {{-- Cantidad --}}
                        <div class="mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number"
                                class="form-control cantidad-input"
                                data-precio-id="precio{{ $venta->id_venta }}"
                                data-total-id="total{{ $venta->id_venta }}"
                                name="cantidad_producto"
                                min="1"
                                value="{{ $venta->cantidad_producto }}">
                        </div>

                        {{-- Total --}}
                        <div class="mb-3">
                            <label class="form-label">Total a Pagar</label>
                            <input type="text"
                                id="total{{ $venta->id_venta }}"
                                class="form-control"
                                name="total_a_pagar"
                                value="{{ $venta->total_a_pagar }}"
                                readonly>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar Venta</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endforeach

<script>
document.getElementById('id_producto').addEventListener('change', function () {
    let productoID = this.value;

    if (productoID) {
        fetch(`/producto/precio/${productoID}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('precio_unitario').value = data.precio_producto;
                calcularTotal();
            });
    }
});

document.getElementById('cantidad_producto').addEventListener('input', calcularTotal);

function calcularTotal() {
    let precio = parseFloat(document.getElementById('precio_unitario').value);
    let cantidad = parseInt(document.getElementById('cantidad_producto').value);

    if (!isNaN(precio) && !isNaN(cantidad)) {
        document.getElementById('total_a_pagar').value = precio * cantidad;
    }
}
</script>


</x-app-layout>
