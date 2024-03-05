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
			$table->text('felicidades_text')->nullable()->default('¡Felicidades!')->after('nombre');
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
			$table->dropColumn('felicidades_text');
		});
	}
};
