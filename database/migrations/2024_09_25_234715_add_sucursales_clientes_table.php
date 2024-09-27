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
		Schema::table('clientes', function (Blueprint $table) {
			$table->boolean('registro_sucursal')->default(0);
			$table->boolean('sucursales_mapa')->default(0);
			$table->string('sucursales_pin')->nullable();
			$table->unsignedSmallInteger('sucursales_max')->default(5);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('clientes', function (Blueprint $table) {
			$table->dropColumn(['registro_sucursal', 'sucursales_mapa', 'sucursales_pin', 'sucursales_max']);
		});
	}
};
