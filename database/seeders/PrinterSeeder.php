<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrinterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('printers')->insert(
            [
                'id' => 0,
                'name' => 'None',
                'job_type' => 'large_format'
            ]
        );
    }
}
