<?php

namespace App\Console\Commands;

use App\Statuspage\Version;
use Illuminate\Console\Command;

class UpdateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:updatedatabase
                            {version? : The version tag to run the updates for.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Does all the necessary database updates.';

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
        $version = $this->argument('version');
        if($version == null){
            $version = Version::getVersion();
        }

        switch ($version){
            default:
                $this->info('No Database Migrations to run.');
                break;
        }
        return 0;
    }
}
