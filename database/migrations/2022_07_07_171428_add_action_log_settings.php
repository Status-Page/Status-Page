<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

class AddActionLogSettings extends Migration
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
                'key' => 'actionlog_disable_read_actions',
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
        $set = Setting::query()->where('key', '=', 'actionlog_disable_read_actions')->first();
        $set->delete();
    }
}
