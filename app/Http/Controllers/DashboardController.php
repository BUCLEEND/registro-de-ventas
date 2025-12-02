<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_categorias = Categoria::count();
        $total_productos = Producto::count();
        $total_ventas = Venta::count();
        return view("dashboard", compact("total_categorias","total_productos", "total_ventas" ));


    }

}

