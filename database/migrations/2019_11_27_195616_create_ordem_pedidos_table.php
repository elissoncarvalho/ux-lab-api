<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdemPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordem_pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_ordem_pedido')->unique();
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('empresa_id')->unsigned();
            $table->bigInteger('convenio_id')->unsigned();
            $table->bigInteger('status_id')->unsigned();
            $table->dateTime('data_coleta');
            $table->dateTime('data_exame');
            $table->boolean('preparo_exame')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('cliente_id')
                ->references('id')
                ->on('clientes');
            $table->foreign('empresa_id')
                ->references('id')
                ->on('empresas');
            $table->foreign('convenio_id')
                ->references('id')
                ->on('convenios');
            $table->foreign('status_id')
                ->references('id')
                ->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordem_pedidos');
    }
}
