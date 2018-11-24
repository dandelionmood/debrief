<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Watson\Validating\ValidationException;

class AppInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debrief application initialization.';

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
     * @return mixed
     */
    public function handle()
    {
        $admin_user = User::query()
            ->where('is_admin', '=', true)
            ->first();
        
        if ($admin_user) {
            $this->warn("At least one admin account is already defined, nothing was done.");
        } else {
            $this->alert("No admin user yet, we need to add one.");

            $this->info("Please give the credentials you want to use : ");

            $email = $this->ask("Give an email for the admin account", null);
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $this->error("Email seems to be invalid, aborting.");
                return false;
            }

            $password = $this->secret('The password you want to use');

            if (!empty($email) && !empty($password)) {
                // We create a user that will allow creation of other users.
                try {
                    User::create([
                        'name'     => 'Admin User',
                        'email'    => strtolower($email),
                        'password' => \Hash::make($password),
                        'is_admin' => true,
                    ]);
                } catch (ValidationException $exception) {
                    dump($exception->getMessageBag());
                }
                $this->info("Successfully created admin user with the credentials you entered.");
                $this->info("You should be able to log in and add other users.");
            } else {
                $this->error("Email and password are mandatory, please try again.");
            }
        }
    }
}
