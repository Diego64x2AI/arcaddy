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
		Schema::create('visitas', function (Blueprint $table) {
			$table->id();
			$table->ipAddress('ip');
			$table->string('iso_code')->nullable();
			$table->string('country')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('state_name')->nullable();
			$table->string('timezone')->nullable();
			$table->string('continent')->nullable();
			$table->string('so')->nullable();
			$table->string('language')->nullable();
			$table->string('browser')->nullable();
			$table->decimal('lon', 11, 8);
			$table->decimal('lat', 10, 8);
			$table->string('url')->nullable();
			$table->string('model')->nullable();
			$table->unsignedBigInteger('model_id')->nullable();
			$table->unsignedBigInteger('user_id')->nullable();
			$table->timestamps();

			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('visitas');
	}
};
