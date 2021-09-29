@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">Sincronizacion de productos</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    {{-- <form class="form-horizontal">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Categorias: </label>
                                <select id="sel_categorias" class="form-control ">
                                    @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{( count($cat->subcategories) > 0  ) ? "  -" : ""}} {{ $cat->name->es }}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form> --}}
                    <p class="h4">Listado de productos donde se encuentran diferencias con Tango Nexo. </p>
                    <span class="text-secondary">Tipicamente esto sucede cuando se han cambiado los valores luego de la sincronización automática.</span>

                    <table id="productosDT" class="table table-sm table-hover table-inverse mt-4">
                        <thead>
                            <th>Nombre</th>
                            <th>SKU</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Stock Tango</th>
                            <th>Precio Tango</th>
                            <th>Acciones</th>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                            {{-- <pre>{{print_r($categorias);}}</pre> --}}
                            @foreach($producto->variants as $prod_variants)
                            <tr>
                                <td scope="row">{{ $producto->name->$language }} </td>
                                <td>{{ $prod_variants->sku }}</td>
                                <td>{{ $prod_variants->stock }}</td>
                                <td>{{ $prod_variants->price }}</td>
                                <td>{{ $prod_variants->stock  +2 }}</td>
                                <td>${{ number_format($prod_variants->price + 5000.00, 2) }} </td>

                                <td> <a name="btn_sincronizar" id="btn_sincronizar" class="btn btn-primary btn-sm" href="#" role="button">Sincronizar</a></td>
                            </tr>
                            @endforeach
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
