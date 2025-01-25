<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $teacher = User::where('role', 'teacher')->first();

        Appointment::create([
            'teacher_id' => $teacher->id,
            'date' => '2024-11-10',
            'time' => '10:00:00',
            'status' => 'available',
        ]);

        Appointment::create([
            'teacher_id' => $teacher->id,
            'date' => '2024-11-10',
            'time' => '11:00:00',
            'status' => 'available',
        ]);
    }
}
