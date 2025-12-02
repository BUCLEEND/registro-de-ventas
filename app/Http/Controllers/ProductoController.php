<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::all();
        $categorias = Categoria::all() ;
        return view("admin.producto", compact("categorias","productos"));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data["estado_producto"] = 1;
        $producto = Producto::create($data);

        if ($producto) {
            return redirect()->back()->with("success","producto creado correctamente");
        } else {
            return redirect()->back()->with("error","error al crear producto");

        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_producto)
    {
        $producto = Producto::findOrFail($id_producto);
        $producto ->update($request->all());
        return redirect()->back()->with("success","Se actualizo correctamente");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
