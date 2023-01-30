<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 120);
            $table->string('correo', 150)->nullable();
            $table->string('telefono', 100);
            $table->string('direccion', 100)->nullable();
            $table->string('observacion', 100)->nullable();
            $table->integer('municipioResidencia')->nullable();
            $table->integer('departamentoResidencia')->nullable();
            $table->tinyInteger('estado')->default('1');
            $table->string('nomReferencia', 100)->nullable();
            $table->string('codReferencia', 1000)->nullable();
            //$table->decimal('stock');
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
        Schema::dropIfExists('contactos');
    }
}
