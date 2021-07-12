<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('ci')->unique()->nullable();
            $table->String('telefono')->nullable();
            $table->String('correo')->nullable();
            $table->boolean('estado');
            $table->dateTime('fechaNacimiento');
            $table->boolean('bautizada');
            $table->String('comentarios')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->String('escuadra')->nullable();
            $table->foreignId("escuadron")->constrained('escuadron');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persona');
    }
}
