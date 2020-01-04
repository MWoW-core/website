<?php

use App\User;
use App\Enums\UserRole;
use Illuminate\Support\Str;
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
        foreach (UserRole::getKeys() as $role) {
            factory(User::class)->states([UserRole::getValue($role), 'with random photo'])->create([
                'email' => Str::lower("{$role}@example.com")
            ]);
        }

        $dieselTest = factory(User::class)->create([
            "account_name" => "Dieseltest",
            "email" => "dieseltest@dieseltest.com",
            "password" => '$2y$10$tZ6IenKcDF8MXAQzJzGJWeV3p6I3e3oTkZWBww4VV5ek.1lDwrssu'
        ]);

        $dieselTest->accounts()->create(['server_id' => 1]);
    }
}
