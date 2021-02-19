<?php

namespace App\Console\Commands;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Validator;

class StatusInstall extends Command
{
    use PasswordValidationRules;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs everything for you.';

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
        $this->info('Starting installation...');

        if(!$this->confirm('Are you sure? This will delete ALL your data!')){
            $this->info('Aborted.');
            return 1;
        }

        $this->call('migrate:fresh');
        $this->call('config:cache');
        $this->call('route:cache');

        $username = 'foobar';
        $email = 'foo@bar.com';
        $password = 'Ch4ng3it!';

        if($this->confirm('Do you want to create your own User? If not, a dummy user will be created. The credentials are shown at the end.')){
            $username = $this->ask('Enter a name for the new Admin Account');
            $email = $this->ask('Enter an email for the new Admin Account');
            $password = $this->secret('Enter a password for the new Admin Account');

            $validator = Validator::make([
                'name' => $username,
                'email' => $email,
                'password' => $password,
            ], [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->consolePasswordRules(),
            ]);

            if ($validator->fails()) {
                $this->info('Installation aborted. See error messages below:');

                foreach ($validator->errors()->all() as $error) {
                    $this->error($error);
                }
                return 1;
            }
        }

        $user = new User();
        $user->name = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        $this->info('Seeding default Data...');
        $this->call('db:seed');

        $this->newLine(2);
        $this->info('This app uses Schedulers! Please add the following line to your crontab, or Scheduled Maintenances wont work:');
        $this->line('* * * * * /usr/bin/php '.base_path().'/artisan schedule:run >> /dev/null 2>&1');
        $this->newLine(2);
        $this->table([
            'Username',
            'E-Mail',
            'Password',
            'Role',
        ], [
            [
                $username,
                $email,
                $password == 'Ch4ng3it!' ? $password : 'Remember it yourself!',
                'super_admin'
            ],
        ]);

        return 0;
    }
}
