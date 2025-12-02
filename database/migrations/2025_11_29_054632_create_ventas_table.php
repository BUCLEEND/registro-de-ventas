<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id("id_venta");
            $table->bigInteger("id_user");
            $table->bigInteger("id_producto");
            $table->integer("cantidad_producto");
            $table->decimal("precio_unitario",10,2);
            $table->decimal("total_a_pagar",10,2);
            $table->integer("estado_venta");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
