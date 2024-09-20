<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::insert([
            ['key' => 'closer_hours', 'value' => '22:00:00'],
            ['key' => 'open_hours', 'value' => '05:00:00'],
            ['key' => 'status_dev', 'value' => 'false'],
        ]);
    }
}
