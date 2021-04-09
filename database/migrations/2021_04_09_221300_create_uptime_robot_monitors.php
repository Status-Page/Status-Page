<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUptimeRobotMonitors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uptime_robot_monitors', function (Blueprint $table) {
            $table->id();
            $table->integer('monitor_id')->unique();
            $table->string('friendly_name');
            $table->integer('status_id');
            $table->integer('component_id')->nullable();
            $table->integer('metric_id')->nullable();
            $table->boolean('paused')->default(true);
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
        Schema::dropIfExists('uptime_robot_monitors');
    }
}
