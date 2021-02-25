<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->integer('region_id')->unsigned();
			$table->string('email')->unique();
			$table->string('password');
			$table->string('min_price');
			$table->string('fees');
			$table->string('phone')->unique();
			$table->string('whatsapp')->unique();
			$table->enum('status', array('opened', 'closed'));
			$table->boolean('is_active')->default(1);
			$table->string('pin_code')->unique()->nullable();
			$table->string('api_token')->unique()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}