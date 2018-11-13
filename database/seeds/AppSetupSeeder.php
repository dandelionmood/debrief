<?php

use App\User;
use Illuminate\Database\Seeder;

class AppSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo "App initialization running …", PHP_EOL;

        // We create a user that will allow creation of other users.
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@debrief.com',
            'password' => Hash::make('admin'),
            'is_admin' => true,
        ]);
        echo "Created admin user (admin/admin).", PHP_EOL;

    }
}
