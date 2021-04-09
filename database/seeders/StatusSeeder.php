<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace Database\Seeders;

use App\Models\Status;
use App\Models\User;
use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::dropIfExists('statuses');

        Schema::create('statuses', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('order')->default('0');
            $table->string('name');
            $table->string('long_description')->nullable();
            $table->string('color')->default('text-black');
            $table->string('bg_color')->nullable()->default('bg-black');
            $table->string('border_color')->nullable()->default('border-black');
            $table->text('heroicon_svg')->nullable();
            $table->timestamps();
        });

        DB::table('statuses')->insert([
            'order' => '0',
            'name' => 'Unknown',
            'long_description' => '',
            'color' => 'text-gray-500',
            'bg_color' => 'bg-black',
            'border_color' => 'border-black',
            'heroicon_svg' => '',
        ]);
        DB::table('statuses')->insert([
            'order' => '1',
            'name' => 'Operational',
            'long_description' => 'All Systems Operational',
            'color' => 'text-green-400',
            'bg_color' => 'bg-green-100',
            'border_color' => 'border-green-500',
            'heroicon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>',
        ]);
        DB::table('statuses')->insert([
            'order' => '2',
            'name' => 'Degraded Performance',
            'long_description' => 'Some services have performance issues',
            'color' => 'text-yellow-500',
            'bg_color' => 'bg-yellow-200',
            'border_color' => 'border-yellow-400',
            'heroicon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>',
        ]);
        DB::table('statuses')->insert([
            'order' => '3',
            'name' => 'Partial Outage',
            'long_description' => 'There is a partial system outage',
            'color' => 'text-yellow-700',
            'bg_color' => 'bg-yellow-200',
            'border_color' => 'border-yellow-700',
            'heroicon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>',
        ]);
        DB::table('statuses')->insert([
            'order' => '4',
            'name' => 'Major Outage',
            'long_description' => 'There is a major system outage',
            'color' => 'text-red-500',
            'bg_color' => 'bg-red-100',
            'border_color' => 'border-red-500',
            'heroicon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>',
        ]);
        DB::table('statuses')->insert([
            'order' => '5',
            'name' => 'Maintenance',
            'long_description' => 'We are doing maintenance work...',
            'color' => 'text-blue-500',
            'bg_color' => 'bg-blue-100',
            'border_color' => 'border-blue-500',
            'heroicon_svg' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" /></svg>',
        ]);
    }
}
