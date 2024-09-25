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
		Schema::create('q_r_links', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cliente_id');
			$table->string('titulo');
			$table->string('slug');
			$table->longText('texto')->nullable();
			$table->string('boton_texto')->nullable();
			$table->string('boton_link')->nullable();
			$table->boolean('banners')->default(false);
			$table->unsignedBigInteger('lecturas')->default(0);

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
		Schema::dropIfExists('q_r_links');
	}
};
