<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminEmail = config('app.admin.email');
        $adminPassword = bcrypt(config('app.admin.password'));

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => $adminPassword,
                'role_id' => 1,
            ]
        ]);
    }
}
