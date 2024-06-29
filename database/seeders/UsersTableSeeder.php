<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['name' => 'Admin Ani', 'email' => 'ani-admin@e.com', 'password' => Hash::make('12345678')],
            ['name' => 'Admin User 2', 'email' => 'admin2@example.com', 'password' => Hash::make('12345678')],
        ];

        foreach ($admins as $admin) {
            $user = User::create($admin);
            $user->assignRole($adminRole);
        }

        // Create regular users
        for ($i = 1; $i <= 20; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);
            $user->assignRole($userRole);
        }
    }

}
