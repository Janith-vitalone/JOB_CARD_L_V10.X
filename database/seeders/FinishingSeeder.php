<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinishingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('finishings')->insert(
            [
                'name' => 'None',
                'format_id' => '1',
                'job_type' => 'large_format',
                'rate' => 0.00,
            ]
        );
    }
}
