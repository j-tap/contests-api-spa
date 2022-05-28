<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('landing_templates')->insert([
            ['key' => 'company1_default', 'name' => 'Company 1 Default'],
            ['key' => 'company2_default', 'name' => 'Company 2 Default'],
            ['key' => 'company3_default', 'name' => 'Company 3 Default'],
        ]);
    }
}
