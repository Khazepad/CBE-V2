<?php

// database/seeders/SemesterSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Semester;

class SemesterSeeder extends Seeder
{
    public function run()
    {
        $semesters = ['1st Semester', '2nd Semester', '3rd Semester'];

        foreach ($semesters as $semester) {
            Semester::create([
                'semester' => $semester,
                'is_default' => false,
            ]);
        }
    }
}
