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
		Schema::create('pedidos', function (Blueprint $table) {
			$table->id();
			$table->string('payment_id')->nullable();
			$table->string('status')->nullable();
			$table->unsignedBigInteger('user_id');
			$table->decimal('total', 12, 2)->default(0);
			$table->decimal('recibido', 12, 2)->default(0);
			$table->decimal('envio', 12, 2)->default(0);
			$table->timestamp('payed_at')->nullable();
			$table->text('direccion')->nullable();
			$table->longText('response')->nullable();
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
		Schema::dropIfExists('pedidos');
	}
};
