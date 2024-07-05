<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_IN');

        // Create admin users
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        $admins = [
            ['first_name' => 'ani', 'last_name' => '', 'username' => 'adminani', 'email' => 'ani@yopmail.com', 'password' => Hash::make('12345678')],
            ['first_name' => 'Admin', 'last_name' => 'User 2', 'username' => 'adminuser2', 'email' => 'admin2@example.com', 'password' => Hash::make('12345678')],
        ];

        foreach ($admins as $admin) {
            $user = User::create($admin);
            $user->assignRole($adminRole);
        }

        // Create regular users
        for ($i = 1; $i <= 20; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $username = strtolower($firstName) . $i; // Adjust how you generate usernames as per your requirement

            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);
            $user->assignRole($userRole);
        }
    }
}

