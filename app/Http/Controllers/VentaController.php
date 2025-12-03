<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::all();
        $productos = Producto::all() ;
        return view("admin.venta", compact("ventas","productos"));
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
        $auth = Auth::user();

        $data["estado_venta"] = 1;
        $data["cantidad_producto"] = 1;
        $data["id_user"] = $auth->id;

        // Calcular total

        Venta::create($data);

        return redirect()->back()->with("success", "Venta registrada correctamente");
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $venta = Venta::findOrFail($id);
    $productos = Producto::all();

    return view('admin.venta_edit', compact('venta', 'productos'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $venta = Venta::findOrFail($id);

    $venta->update([
        'id_producto'     => $request->id_producto,
        'cantidad_producto' => $request->cantidad_producto,
        'precio_unitario' => $request->precio_unitario,
        'total_a_pagar'   => $request->total_a_pagar,
    ]);

    return redirect()->route('ventas.index')
                     ->with('success', 'Venta actualizada correctamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
