<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
{
    // Totales de tarjetas
    $total_categorias = Categoria::count();
    $total_productos = Producto::count();
    $total_ventas = Venta::count();

    // ============================
    // 📊 1. Ventas agrupadas por mes
    // ============================
    $ventasPorMes = Venta::selectRaw('MONTH(created_at) as mes, SUM(total_a_pagar) as total')
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

    $meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
    $totales = array_fill(0, 12, 0);

    foreach ($ventasPorMes as $venta) {
        $totales[$venta->mes - 1] = $venta->total;
    }

    // ============================
    // 📊 2. Productos más vendidos
    // ============================
    $productosVendidos = Venta::join('productos', 'ventas.id_producto', '=', 'productos.id_producto')
        ->selectRaw('productos.nombre_producto, SUM(ventas.cantidad_producto) as total')
        ->groupBy('productos.nombre_producto')
        ->orderByDesc('total')
        ->get();


    // Extraemos para ApexCharts
    $nombresProductos = $productosVendidos->pluck('nombre_producto');
    $totalesProductos = $productosVendidos->pluck('total');

    $participacion = Venta::join('productos', 'ventas.id_producto', '=', 'productos.id_producto')
    ->selectRaw('productos.nombre_producto as producto, SUM(ventas.total_a_pagar) as total')
    ->groupBy('productos.nombre_producto')
    ->get();

    return view("dashboard", compact(
        "total_categorias",
        "total_productos",
        "total_ventas",
        "meses",
        "totales",
        "nombresProductos",
        "totalesProductos",
        "participacion"
    ));

}



}

