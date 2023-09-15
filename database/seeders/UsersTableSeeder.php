<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'name' => 'Helium',
                'last_name' => 'Solutions',
                'email' => 'info@helium.lk',
                'password' => Hash::make('HeliUm@789'),
                'dob' => Carbon::now(),
                'gender' => 'M',
                'contact_no' => '0775580646',
                'designation_id' => 1
            ]
        );
    }
}
