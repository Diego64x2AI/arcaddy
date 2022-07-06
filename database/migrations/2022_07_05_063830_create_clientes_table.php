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
		Schema::create('clientes', function (Blueprint $table) {
			$table->id();
			$table->string('cliente');
			$table->string('slug')->unique();
			$table->string('color');
			$table->string('logo');
			$table->string('titulo')->nullable();
			$table->string('subtitulo')->nullable();
			$table->text('descripcion')->nullable();
			$table->string('fecha')->nullable();
			$table->string('facebook_live')->nullable();
			$table->string('facebook')->nullable();
			$table->string('instagram')->nullable();
			$table->string('twitter')->nullable();
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
		Schema::dropIfExists('clientes');
	}
};
