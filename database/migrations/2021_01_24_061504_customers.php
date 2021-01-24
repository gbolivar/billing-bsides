<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            //  2 dígitos que indican el tipo, 
            // 8 dígitos que son el número de DNI (Documento Nacional de Identidad) 
            // y un último número asignado aleatoriamente.
            //  20 para hombres, 
            // 27 para mujeres, 23, 24, 25 o 26 para ambos (en caso de que ya exista un CUIT idéntico) 
            //y 30 para empresas

            $table->bigInteger('cuit');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
