<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            DesignationsTableSeeder::class,
            UserRolesTableSeeder::class,
            UsersTableSeeder::class,
            UserHasRolesTableSeeder::class,
            FormsTableSeeder::class,
            FormatSeeder::class,
            PrinterSeeder::class,
            FinishingSeeder::class,
            LamintationSeeder::class,
            MaterialSeeder::class,
            PrintTypeSeeder::class
        ]);
    }
}
