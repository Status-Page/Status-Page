<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('statuses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('order')->default('0');
			$table->string('name');
			$table->string('long_description')->nullable();
			$table->string('color')->default('text-black');
			$table->string('bg_color')->nullable()->default('bg-black');
			$table->string('border_color')->nullable()->default('border-black');
			$table->text('heroicon_svg')->nullable();
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
		Schema::drop('statuses');
	}

}
