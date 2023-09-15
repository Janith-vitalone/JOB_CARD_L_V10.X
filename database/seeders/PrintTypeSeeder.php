<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('print_types')->insert(
            [
                'name' => 'None',
                'rate' => 0.00,
                'job_type' => 'large_format',
                'slug' => 'none',
            ]
        );
    }
}
