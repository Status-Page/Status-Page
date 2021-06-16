<?php

namespace App\Console\Commands;

use App\Models\Subscriber;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckSubscribers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:checksubscribers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if there are any expired Subscribers and deletes them.';

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
        $query = Subscriber::query()->where('email_verified', '=', false)->where('updated_at', '<', Carbon::now()->addHours(24));
        $this->info('Deleting '.$query->count().' subscribers...');
        $query->delete();
        return 0;
    }
}
