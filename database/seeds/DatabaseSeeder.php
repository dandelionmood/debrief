<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::updateOrCreate(['email' => 'test@user.com'], [
            'name'     => 'Test User',
            'email'    => 'test@user.com',
            'password' => \Illuminate\Support\Facades\Hash::make('testuser'),
        ]);

        $universe = \App\Universe::updateOrCreate(['label' => 'Testing universe'], [
           'label' => 'Testing universe',
           'description' => 'A universe for testing new things',
           'user_id' => $user->id,
        ]);

        \App\Story::updateOrCreate(['universe_id' => $universe->id, 'label' => 'A very good question'], [
            'description' => 'A first good question …'
        ]);
        \App\Story::updateOrCreate(['universe_id' => $universe->id, 'label' => 'A very good second question'], [
            'description' => 'A second good question …'
        ]);
        \App\Story::updateOrCreate(['universe_id' => $universe->id, 'label' => 'A very good third question'], [
            'description' => 'A third good question …'
        ]);
    }
}
