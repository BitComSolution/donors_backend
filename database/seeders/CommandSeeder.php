<?php

namespace Database\Seeders;

use App\Models\Scheduled;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Scheduled::firstOrCreate([
            'title' => 'dump'], [
            'period_hours' => 1
        ]);
        Scheduled::firstOrCreate([
            'title' => 'aist'], [
            'period_hours' => 1
        ]);
        Scheduled::firstOrCreate([
            'title' => 'ms'], [
            'period_hours' => 1
        ]);
        Scheduled::firstOrCreate([
            'title' => 'logs_clear'], [
            'period_hours' => 1
        ]);
    }
}
