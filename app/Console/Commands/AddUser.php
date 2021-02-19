<?php

namespace App\Console\Commands;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Hash;
use Illuminate\Console\Command;
use Validator;

class AddUser extends Command
{
    use PasswordValidationRules;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:adduser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds a new User.';

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
        $this->info('User creation.');
        $username = $this->ask('Username');
        $email = $this->ask('E-Mail');
        $password = $this->secret('Password');
        $role = $this->choice('Role', [
            '2' => 'Admin',
            '3' => 'Reporter'
        ], 3);

        $validator = Validator::make([
            'name' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->consolePasswordRules(),
            'role' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            $this->info('Installation aborted. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $user = new User();
        $user->name = $username;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();
        $user->assignRole(strtolower($role));

        return 0;
    }
}
