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
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editar_producto{{ $producto->id_producto }}">
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
    {{-- @foreach ($productos as $producto)
        <div class="modal fade" id="editar_producto{{ $producto->id_producto }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route("productos.update", $producto->id_producto)  }}">
                            @method('PUT')
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">nombre producto</label>
                                <input type="text" class="form-control" name="nombre_producto" value="{{ $producto->nombre_producto }}">
                            </div>

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">descripcion producto</label>
                                <input type="text" class="form-control" name="descripcion_producto" value="{{ $producto->descripcion_producto }}">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">precio producto</label>
                                <input type="text" class="form-control" name="precio_producto" value="{{ $producto->precio_producto }}">
                            </div>
                            <div class="mb-3">
                            <label for="id_categoria" class="form-label">Categoría</label>

                            @if ($ventas->isEmpty())
                                <div class="alert alert-warning mt-2">
                                    No hay registro de categoría
                                    <br>
                                    <a href="{{ route('categorias.index') }}" class="alert-link">Registra una categoría</a>
                                </div>
                            @else
                                <select name="id_categoria" id="id_categoria" class="form-select" aria-label="Default select example">
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}"
                                            @selected(isset($registro) && $registro->id_categoria == $categoria->id_categoria)>
                                            {{ $categoria->nombre_categoria }}
                                        </option>
                                    @endforeach
                                </select>

                            @endif
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    @endforeach --}}
<script>
document.getElementById('id_producto').addEventListener('change', function() {
    let productoID = this.value;

    if (productoID) {
        fetch(`/producto/precio/${productoID}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('precio_unitario').value = data.precio_producto;
            });
    }
});
</script>

</x-app-layout>
