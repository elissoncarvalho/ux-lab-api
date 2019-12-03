<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemPedidoExamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_pedido_exames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ordem_pedido_id')->unsigned();
            $table->bigInteger('exame_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ordem_pedido_id')
                ->references('id')
                ->on('ordem_pedidos');
            $table->foreign('exame_id')
                ->references('id')
                ->on('exames');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordem_pedido_exames');
    }
}
