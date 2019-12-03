<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('endereco_id')->unsigned();
            $table->string('nome_razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('email')->nullable();
            $table->string('cnpj')->unique();
            $table->string('telefone');
            $table->boolean('filial')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('endereco_id')
                ->references('id')
                ->on('enderecos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresas');
    }
}
