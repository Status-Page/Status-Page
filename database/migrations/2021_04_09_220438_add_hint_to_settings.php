<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHintToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->mediumText('hint')->nullable()->after('encrypted');
        });

        $settings = [
            [
                'key' => 'uptimerobot_key',
                'value' => '',
                'type' => 'text',
                'encrypted' => true,
                'hint' => 'You enable the UptimeRobot functionality by Setting this Key.',
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
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
