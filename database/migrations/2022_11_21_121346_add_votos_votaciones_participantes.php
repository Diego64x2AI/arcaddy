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
		Schema::table('votaciones_participantes', function (Blueprint $table) {
			$table->unsignedBigInteger('votos')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('votaciones_participantes', function (Blueprint $table) {
			$table->dropColumn('votos');
		});
	}
};
