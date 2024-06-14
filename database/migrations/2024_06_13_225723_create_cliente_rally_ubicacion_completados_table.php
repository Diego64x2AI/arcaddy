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
		Schema::create('cliente_rally_ubicacion_completados', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('ubicacion_id');
			$table->unsignedBigInteger('user_id')->nullable();
			$table->unsignedSmallInteger('distancia')->default(0);
			$table->double('lat', 10, 8)->nullable()->default(0);
			$table->double('lng', 11, 8)->nullable()->default(0);
			$table->string('ip', 45)->nullable();
			$table->string('referer')->nullable();
			$table->string('user_agent')->nullable();
			$table->timestamps();

			$table->foreign('ubicacion_id')->references('id')->on('cliente_rally_ubicacions')->onDelete('cascade');
			$table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cliente_rally_ubicacion_completados');
	}
};
