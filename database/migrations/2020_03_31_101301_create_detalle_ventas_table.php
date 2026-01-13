<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('venta_id')->unsigned();
            $table->bigInteger('producto_id')->unsigned();
            $table->integer('cantidad');
            $table->decimal('costo',24,2);
            $table->bigInteger('descuento_id')->unsigned();
            $table->decimal('total',24,2);
            $table->timestamps();

            $table->foreign('venta_id')->references('id')->on('ventas')->ondelete('no action')->onupdate('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->ondelete('no action')->onupdate('cascade');
            $table->foreign('descuento_id')->references('id')->on('descuentos')->ondelete('no action')->onupdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
}
