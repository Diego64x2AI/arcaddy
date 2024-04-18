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
		Schema::table('cliente_quizzes', function (Blueprint $table) {
			$table->string('boton_text')->default('Volver a jugar')->after('felicidades_text');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cliente_quizzes', function (Blueprint $table) {
			$table->dropColumn('boton_text');
		});
	}
};
