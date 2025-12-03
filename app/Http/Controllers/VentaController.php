<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Venta::with('producto', 'user')->get();
        $productos = Producto::all();

        // ================================
        // 📊 Participación de ventas por producto
        // ================================
        $participacion = Venta::select(
                'id_producto',
                DB::raw('SUM(total_a_pagar) as total')
            )
            ->groupBy('id_producto')
            ->with('producto') // Para obtener el nombre del producto
            ->get()
            ->map(function ($item) {
                return [
                    'producto' => $item->producto ? $item->producto->nombre_producto : 'Sin nombre',
                    'total'    => $item->total,
                ];
            });

        return view("admin.venta", compact(
            "ventas",
            "productos",
            "participacion"
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $auth = Auth::user();

        $data["estado_venta"] = 1;
        $data["cantidad_producto"] = 1;
        $data["id_user"] = $auth->id;

        Venta::create($data);

        return redirect()->back()->with("success", "Venta registrada correctamente");
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $venta = Venta::findOrFail($id);
        $productos = Producto::all();

        return view('admin.venta_edit', compact('venta', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $venta = Venta::findOrFail($id);

        $venta->update([
            'id_producto'       => $request->id_producto,
            'cantidad_producto' => $request->cantidad_producto,
            'precio_unitario'   => $request->precio_unitario,
            'total_a_pagar'     => $request->total_a_pagar,
        ]);

        return redirect()->route('ventas.index')
                         ->with('success', 'Venta actualizada correctamente');
    }

    public function destroy(string $id)
    {
        //
    }
}
