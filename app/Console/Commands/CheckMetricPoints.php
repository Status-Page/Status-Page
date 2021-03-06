<?php
/*
 * Copyright (c) 2021 by HerrTxbias.
 *
 * Using / Editing this without my consent is not allowed.
 */

namespace App\Console\Commands;

use App\Models\Action;
use App\Models\MetricPoint;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckMetricPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:metricpoints';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the Metric Points for old entries and deletes them.';

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
        MetricPoint::query()
            ->where('created_at', '<', Carbon::now()->subMonth()->subDay())
            ->delete();
        return 0;
    }
}
