<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Process;

class RunUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manages the complete Update process for you.';

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
        $version = json_decode(Http::get(route('api.version'))->body());

        if($version->meta->on_latest){
            $this->info('Nothing to update.');
            return 0;
        }

        if($this->confirm('Do you really want to Update now? The Application won\'t be available during this process.')){

            $this->call('down', [
                '--retry' => '10'
            ]);

            $process = Process::fromShellCommandline('git checkout '.$version->meta->git->last_tag);
            $process->run();
            $this->line($process->getOutput());

            $this->call('status:updatedatabase', [
                'version' => $version->meta->git->last_tag
            ]);

            $this->call('up');
        }else{
            $this->info('Aborted.');
        }
        return 0;
    }
}
