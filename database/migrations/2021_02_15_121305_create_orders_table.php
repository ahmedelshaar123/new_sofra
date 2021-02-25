<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->enum('status', array('pending', 'rejected', 'accepted', 'declined', 'received'));
			$table->string('fees');
			$table->string('total_price');
			$table->string('commission');
			$table->text('notes')->nullable();
			$table->integer('client_id')->unsigned();
			$table->integer('restaurant_id')->unsigned();
			$table->integer('payment_method_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}