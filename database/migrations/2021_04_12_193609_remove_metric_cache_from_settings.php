<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveMetricCacheFromSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Setting::query()->where('key', 'metrics_cache')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $settings = [
            [
                'key' => 'metrics_cache',
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
            $set->save();
        }
    }
}
