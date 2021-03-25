<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary()->unique();
            $table->string('value')->nullable();
            $table->boolean('boolval')->nullable();
            $table->enum('type', [
                'text',
                'checkbox',
                'email',
                'number',
                'color',
                'datetime-local',
                'url',
                'tel',
                'file',
                'hidden',
            ]);
            $table->timestamps();
        });

        $settings = [
            [
                'key' => 'footer_show',
                'boolval' => true,
                'type' => 'checkbox',
            ],
            [
                'key' => 'footer_showDashboardLink',
                'boolval' => true,
                'type' => 'checkbox',
            ],
            [
                'key' => 'incidents_pastIncidentDays',
                'value' => '7',
                'type' => 'number',
            ],
            [
                'key' => 'actionlog_backlog',
                'value' => '7',
                'type' => 'number',
            ],
            [
                'key' => 'darkmode_default',
                'boolval' => true,
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
