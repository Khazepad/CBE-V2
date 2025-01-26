<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SchoolYear;

class SchoolYearSeeder extends Seeder
{
    public function run()
    {
        for ($year = 2022; $year <= 2030; $year++) {
            SchoolYear::create([
                'year' => $year . '-' . ($year + 1),
                'is_default' => false,
            ]);
        }
    }
}
