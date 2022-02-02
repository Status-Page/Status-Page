<?php

use App\Models\CachedVersionData;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCachedVersionDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cached_version_data', function (Blueprint $table) {
            $table->id();
            $table->string('latest_version_from_github');
            $table->timestamps();
        });
        $cachedVersionData = new CachedVersionData();
        $cachedVersionData->latest_version_from_github = 'none';
        $cachedVersionData->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cached_version_data');
    }
}
