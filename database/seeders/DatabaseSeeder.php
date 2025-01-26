<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the SchoolYearSeeder, SemesterSeeder, and ProgramTableSeeder
        $this->call([
            ProgramsTableSeeder::class, // Add this line
            RolesTableSeeder::class,
            SchoolYearSeeder::class,
            SemesterSeeder::class, // Add this line

        ]);

    }
}
