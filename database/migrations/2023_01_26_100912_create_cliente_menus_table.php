<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cliente_menus', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->string('categoria');
			$table->string('archivo')->nullable();
			$table->string('nombre');
			$table->string('cantidad')->nullable();
			$table->string('precio')->nullable();
			$table->string('boton_titulo')->nullable();
			$table->string('boton_link')->nullable();
			$table->string('canje_texto')->nullable();
			$table->text('descripcion')->nullable();
			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cliente_menus');
	}
};
