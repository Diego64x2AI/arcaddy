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
		Schema::create('q_r_link_banners', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('qrlink_id');
			$table->string('archivo');
			$table->string('titulo')->nullable();
			$table->string('link')->nullable();

			$table->foreign('qrlink_id')->references('id')->on('q_r_links')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('q_r_link_banners');
	}
};
