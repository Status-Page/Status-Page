<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->boolean('incident_updates')->default(true);
        });
    }

    public function down()
    {
        Schema::table('subscribers', function (Blueprint $table) {
            $table->removeColumn('incident_updates');
        });
    }
};
