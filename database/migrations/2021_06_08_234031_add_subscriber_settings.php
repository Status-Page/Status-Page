<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriberSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $settings = [
            [
                'key' => 'subscriber_signup',
                'boolval' => false,
                'type' => 'checkbox',
            ],
        ];

        foreach ($settings as $setting){
            $set = new Setting();
            $set->key = $setting['key'];
            $set->value = $setting['value'] ?? '';
            $set->boolval = $setting['boolval'] ?? false;
            $set->type = $setting['type'];
            $set->encrypted = $setting['encrypted'] ?? false;
            $set->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
