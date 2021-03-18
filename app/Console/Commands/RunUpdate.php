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
    protected $signature = 'status:update
                            {--tags : Update using git tags.}';

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
        if($this->option('tags') == null){
            if($this->confirm('Do you really want to Update now? The Application won\'t be available during this process.')){
                $this->call('down', [
                    '--retry' => '10'
                ]);

                $this->info('Pulling new / updated files...');
                $process = Process::fromShellCommandline('git pull');
                $process->run();
                $this->line($process->getOutput());

                $this->info('Installing / Updating Composer packages...');
                $process = Process::fromShellCommandline('composer install');
                $process->run();
                $this->line($process->getOutput());

                $this->info('Installing / Updating NPM packages...');
                $process = Process::fromShellCommandline('npm install');
                $process->run();
                $this->line($process->getOutput());

                $this->call('migrate');
                $this->call('config:cache');
                $this->call('route:cache');
                $this->call('event:cache');
                $this->call('view:cache');
                $this->call('permission:cache-reset');

                $this->call('up');
            }else{
                $this->info('Aborted.');
            }
        }else{
            $process = Process::fromShellCommandline('git fetch origin');
            $process->run();
            $this->line($process->getOutput());

            $version = json_decode(Http::get(route('api.version'))->body());

            if($version->meta->on_latest){
                $this->info('Nothing to update.');
                return 0;
            }

            if($this->confirm('Do you really want to Update now? The Application won\'t be available during this process.')){
                $this->call('down', [
                    '--retry' => '10'
                ]);

                $this->info('Stashing changes...');
                $process = Process::fromShellCommandline('git stash');
                $process->run();
                $this->line($process->getOutput());

                $this->info('Checking out new Version...');
                $process = Process::fromShellCommandline('git checkout '.$version->meta->git->last_tag);
                $process->run();
                $this->line($process->getOutput());

                $this->info('Installing / Updating Composer packages...');
                $process = Process::fromShellCommandline('composer install');
                $process->run();
                $this->line($process->getOutput());

                $this->info('Installing / Updating NPM packages...');
                $process = Process::fromShellCommandline('npm install');
                $process->run();
                $this->line($process->getOutput());

                $this->call('migrate');
                $this->call('config:cache');
                $this->call('route:cache');
                $this->call('event:cache');
                $this->call('view:cache');
                $this->call('permission:cache-reset');

                $this->call('up');
            }else{
                $this->info('Aborted.');
            }
        }

        return 0;
    }
}
