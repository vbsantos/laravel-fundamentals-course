<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = (int) $this->command->ask("How many Users (besides Administrator, if he doesn't already exists) would you like to add?", 10);
        try {
            factory(App\User::class)->states('admin')->create();
            factory(App\User::class, $usersCount)->create();
        } catch (\Throwable $th) {
            factory(App\User::class, $usersCount)->create();
        }
    }
}
