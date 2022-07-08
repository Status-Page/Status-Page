<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('custom_styles', function (Blueprint $table) {
            $table->id();

            $table->boolean('enable_header')->default(false);
            $table->longText('header')->default('');

            $table->boolean('enable_footer')->default(false);
            $table->longText('footer')->default('');

            $table->longText('custom_css')->default('');

            $table->boolean('active')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('custom_styles');
    }
};
