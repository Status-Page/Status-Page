<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StatusReseed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:reseed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Redos all the important seeding. (For dev purposes!)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->error('Use with Caution! This MAY lead to login issues!');

        if($this->confirm('Are you sure?')){
            $this->call('migrate:refresh', [
                '--path' => 'database/migrations/2021_02_16_233641_create_statuses_table.php',
                '--path' => 'database/migrations/2021_02_17_001204_create_permission_tables.php',
                '--seed' => 'default',
            ]);
        }

        return 0;
    }
}
