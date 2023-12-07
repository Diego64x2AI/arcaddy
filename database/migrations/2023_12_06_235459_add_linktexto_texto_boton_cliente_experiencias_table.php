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
		Schema::table('cliente_experiencias', function (Blueprint $table) {
			$table->string('linktexto')->nullable();
			$table->string('texto_boton')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cliente_experiencias', function (Blueprint $table) {
			$table->dropColumn(['linktexto', 'texto_boton']);
		});
	}
};
