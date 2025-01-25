<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AppointmentStudent extends Pivot
{
    protected $table = 'appointment_student';
    
    protected $fillable = ['appointment_id', 'student_id', 'status'];
    
}
