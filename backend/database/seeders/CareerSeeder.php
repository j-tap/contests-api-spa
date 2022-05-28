<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('careers')->insert([
            ['name' => 'Арбитражник'],
            ['name' => 'Паблишер'],
            ['name' => 'Рекламодатель'],
            ['name' => 'Компания'],
        ]);
    }
}
