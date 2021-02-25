<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email')->unique();
			$table->string('phone')->unique();
			$table->integer('region_id')->unsigned();
			$table->text('desc')->nullable();
			$table->boolean('is_active')->default(1);
			$table->string('password');
			$table->string('pin_code')->unique()->nullable();
			$table->string('api_token')->unique()->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}