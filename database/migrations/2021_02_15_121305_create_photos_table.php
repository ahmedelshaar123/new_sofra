<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhotosTable extends Migration {

	public function up()
	{
		Schema::create('photos', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('path')->nullable();
			$table->integer('photoable_id');
			$table->string('photoable_type');
		});
	}

	public function down()
	{
		Schema::drop('photos');
	}
}