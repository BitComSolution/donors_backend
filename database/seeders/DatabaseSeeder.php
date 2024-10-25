<?php

namespace Database\Seeders;

use App\Models\Scheduled;
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
        $data['email'] = 'admin@admin.ru';
        $data['password'] = Hash::make('passwordDonor!');
        User::create($data);

        Scheduled::create([
            'title' => 'dump',
            'period_hours' => 1
        ]);
    }
}
