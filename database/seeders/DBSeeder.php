<?php

namespace Database\Seeders;

use App\Models\MSConfig;
use Illuminate\Database\Seeder;

class DBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MSConfig::firstOrCreate([
            'name' => 'Base config'], [
            'port' => '1433',
            'database' => 'dev',
            'username' => 'sa',
            'password' => 'root',
            'user_id' => '-20',
            'department_id' => 0,
            'host' => 'localhost',
            'url_aist' => '',
            'active' => true,

        ]);
    }
}
