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
		Schema::table('cliente_secciones', function (Blueprint $table) {
			$table->string('titulo')->nullable()->after('seccion');
			$table->boolean('mostrar_titulo')->default(true)->after('titulo');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cliente_secciones', function (Blueprint $table) {
			$table->dropColumn(['titulo', 'mostrar_titulo']);
		});
	}
};
