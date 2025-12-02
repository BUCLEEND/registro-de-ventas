<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categorias', CategoriaController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('productos', ProductoController::class);
    Route::get('/archivar/{id_categoria}', [CategoriaController::class, 'archivar_categoria'])->name('categoria.archivar');
    Route::get('/producto/precio/{id}', function ($id) {
    $producto = App\Models\Producto::find($id);
    return response()->json($producto);
    })->name('producto.precio');


});

require __DIR__.'/auth.php';
