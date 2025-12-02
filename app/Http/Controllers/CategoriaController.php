<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::where('estado_categoria' ,1)->get();
        return view("admin.categoria", compact("categorias"));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data["estado_categoria"] = 1;
        $categoria = Categoria::create($data);

        if ($categoria) {
            return redirect()->back()->with("success","categoria creado correctamente");
        } else {
            return redirect()->back()->with("error","error al crear categoria");

        }

    }

    public function update(Request $request, string $id_categoria)
    {
        $categoria = Categoria::findOrFail($id_categoria);
        $categoria ->update($request->all());
        return redirect()->back()->with("success","Se actualizo correctamente");
    }

    public function archivar_categoria(string $id_categoria)
    {
        $categoria = Categoria::findOrFail($id_categoria);
        $categoria->estado_categoria = 0;
        $categoria->save();
        return redirect()->back()->with("success","Se archivo categoria correctamente");

    }
    public function destroy(string $id)
    {
        //
    }

}
