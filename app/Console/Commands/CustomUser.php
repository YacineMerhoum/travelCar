<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CustomUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:custom-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new custom user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstname = $this->ask('What is your first name?');
        $lastname = $this->ask('What is your last name?');
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is your password?');
        $role = $this->choice('What is your role?', ['admin', 'user'], 0);

        $validator = Validator::make([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password,
        ], [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed. Please correct the errors and try again.');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $user = User::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => bcrypt($password),
            'role' => $role,
        ]);

        $this->info('User created successfully!');
        return 0;
    }
}
