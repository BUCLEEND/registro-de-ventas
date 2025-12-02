<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = "productos";
    protected $primaryKey = 'id_producto';
    protected $fillable = [
        'nombre_producto',
        'descripcion_producto',
        'precio_producto',
        'estado_producto',
        'id_categoria',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria','id_categoria');
    }
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_producto','id_producto');
    }


}
