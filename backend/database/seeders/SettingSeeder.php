<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phone = config('app.tg.phone');

        DB::table('settings')->insert([
            [
                'key' => 'telegram_login_phone',
                'value' => $phone,
                'setting_type_id' => 1,
                'name' => 'Телефон администратора',
                'description' => 'Телефон администратора для получения данных из Telergram',
            ],
        ]);
    }
}
