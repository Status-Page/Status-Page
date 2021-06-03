<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinkedStatusMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linked_status_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('external_id');
            $table->string('title', 255);
            $table->string('published_updates');
            $table->string('last_status');
            $table->integer('linked_status_provider_id');
            $table->boolean('available')->default(true);
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
        Schema::dropIfExists('linked_status_maintenances');
    }
}
