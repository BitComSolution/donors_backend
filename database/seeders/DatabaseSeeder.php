<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $data['name'] = 'Admin';
        $data['email'] = 'admin1@admin.ru';
        $data['password'] = Hash::make('passwordDonor123!');

        $user = User::create($data);
    }
}
