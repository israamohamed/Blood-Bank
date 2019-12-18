<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) 
		{
			$table->increments('id');
			$table->timestamps();
			$table->string('phone');
			$table->string('password');
			$table->string('name');
			$table->date('dob');
			$table->integer('blood_type_id')->unsigned();
			$table->date('last_donation_date');
			$table->integer('city_id');
			$table->integer('pin_code')->nullable();
			$table->string('email');
			$table->string('api_token', 60);
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}