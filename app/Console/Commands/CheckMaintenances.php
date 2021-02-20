<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Console\Commands;

use App\Models\Incident;
use Illuminate\Console\Command;

class CheckMaintenances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:maintenances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if any Maintenance is due and sets it active.';

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
        Incident::checkMaintenances();
        return 0;
    }
}
