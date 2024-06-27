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
			$table->string('font')->nullable();
			$table->string('font_titulo')->nullable();
			$table->decimal('size1', 10, 2)->nullable()->default(0);
			$table->decimal('size2', 10, 2)->nullable()->default(0);
			$table->decimal('size3', 10, 2)->nullable()->default(0);
			$table->decimal('negrita', 10, 2)->nullable()->default(0);
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
			$table->dropColumn('font');
			$table->dropColumn('font_titulo');
			$table->dropColumn('size1');
			$table->dropColumn('size2');
			$table->dropColumn('size3');
			$table->dropColumn('negrita');
		});
	}
};
