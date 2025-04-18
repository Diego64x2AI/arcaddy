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
		Schema::table('cliente_productos', function (Blueprint $table) {
			$table->integer('cantidad')->default(0)->after('id')->comment('Cantidad de productos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cliente_productos', function (Blueprint $table) {
			$table->dropColumn('cantidad');
		});
	}
};
