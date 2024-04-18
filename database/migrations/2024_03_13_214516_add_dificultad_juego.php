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
		Schema::table('juego', function (Blueprint $table) {
			$table->dropColumn('borrado');
			$table->dropColumn('slug');
			$table->string('dificultad')->nullable()->after('nombre');
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('juego', function (Blueprint $table) {
			$table->string('slug')->nullable()->after('nombre');
			$table->dropColumn('dificultad');
			$table->dropSoftDeletes();
			$table->boolean('borrado')->default(0);
		});
	}
};
