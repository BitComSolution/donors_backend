<?php

namespace Database\Seeders;

use App\Models\DB;
use Illuminate\Database\Seeder;

class DBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::firstOrCreate([
            'host' => 'localhost'], [
            'port' => '1433',
            'database' => 'dev',
            'username' => 'sa',
            'password' => 'root',
        ]);
    }
}
