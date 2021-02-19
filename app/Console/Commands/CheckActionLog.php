<?php

namespace App\Console\Commands;

use App\Models\Action;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckActionLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:actionlog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks the Action Log for old entrys and deletes them.';

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
        Action::query()
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->delete();
        return 0;
    }
}
