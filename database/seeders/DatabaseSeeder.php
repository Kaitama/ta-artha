<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

         $user = \App\Models\User::factory()->create([
             'name' => 'Administrator',
             'username' => 'admin',
             'email' => 'admin@example.com',
             'is_active' => true,
         ]);

         $user->assignRole('kasir');

//         \App\Models\User::factory(50)->create();

    }
}
