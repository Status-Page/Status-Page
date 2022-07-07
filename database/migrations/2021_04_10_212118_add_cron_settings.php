<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class AddCronSettings extends Migration
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
                'key' => 'external_cron',
                'boolval' => false,
                'type' => 'checkbox',
                'hint' => 'You can use this, to run the task scheduler externally via \'POST /api/v1/run/cron\'. Normally you would use \'php artisan schedule:run\' via a cronjob.',
            ],
        ];

        foreach ($settings as $setting){
            $set = new Setting();
            $set->key = $setting['key'];
            $set->value = $setting['value'] ?? '';
            $set->boolval = $setting['boolval'] ?? false;
            $set->type = $setting['type'];
            $set->encrypted = $setting['encrypted'] ?? false;
            $set->hint = $setting['hint'];
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
