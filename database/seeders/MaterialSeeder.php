<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materials')->insert(
            [
                'name' => 'None',
                'format_id' => 1,
                'job_type' => 'large_format',
            ]
        );
    }
}
