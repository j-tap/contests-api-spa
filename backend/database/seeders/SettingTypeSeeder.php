<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_types')->insert([
            [
                'name' => 'text',
                'description' => 'Простое текстовое поле',
            ],
        ]);
    }
}
