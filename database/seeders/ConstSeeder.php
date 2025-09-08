<?php

namespace Database\Seeders;

use App\Models\Constant;
use Illuminate\Database\Seeder;

class ConstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Constant::firstOrCreate([
            'name' => 'CreateUserId'], [
            'value' => '-20'
        ]);
        Constant::firstOrCreate([
            'name' => 'UniqueIdMIN'], [
            'value' => '400000000'
        ]);
        Constant::firstOrCreate([
            'name' => 'DepartmentId'], [
            'value' => '0'
        ]);

    }
}
