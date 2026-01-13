<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentaPromocionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venta_promociones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('venta_id')->unsigned();
            $table->bigInteger('promocion_id')->unsigned();
            $table->timestamps();
            $table->foreign('venta_id')->references('id')->on('ventas')->ondelete('no action')->onupdate('cascade');
            $table->foreign('promocion_id')->references('id')->on('promociones')->ondelete('no action')->onupdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venta_promocions');
    }
}
