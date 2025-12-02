<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
   protected $table = "ventas";
    protected $primaryKey = 'id_venta';
    protected $fillable = [
        'id_user',
        'id_producto',
        'cantidad_producto',
        'precio_unitario',
        'total_a_pagar',
        'estado_venta',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user','id');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto','id_producto');
    }
}
