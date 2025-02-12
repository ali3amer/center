<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Safe;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LaratrustSeeder::class);

        $user = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make(123456),
        ]);

        $user->addRole('super_admin');
        Safe::create([
            'user_id' => $user->id,
            'initial_balance' => 0,
            'date' => date('Y-m-d'),
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
