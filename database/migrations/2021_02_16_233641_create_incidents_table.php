<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('incidents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->integer('type');
			$table->integer('status');
			$table->integer('impact')->default(0);
            $table->boolean('visibility')->default(0);
            $table->integer('user');
			$table->dateTime('scheduled_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('incidents');
	}

}
