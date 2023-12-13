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
		Schema::create('juego', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->unsignedBigInteger('juego_categoria_id');
			$table->string('nombre')->nullable();
			$table->string('slug')->nullable();
			$table->text('descripcion')->nullable();
			$table->text('clave')->nullable();
			$table->boolean('activo')->default(1);
			$table->boolean('borrado')->default(0);
			$table->timestamps();

			$table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
			$table->foreign('juego_categoria_id')->references('id')->on('juego_categorias')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('juego');
	}
};
