<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'last_name',
        'middle_name',
        'email',
        'password',
        'birthdate',
        'profile_image',
        'role_id',
        'program_id' // Add program_id here
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birthdate' => 'date',
    ];

    // Define the relationship with the Role model
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Define the relationship with the Program model
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    // Define the relationship for appointments where the user is the regular user
    public function appointmentsAsUser()
    {
        return $this->hasMany(Appointment::class, 'user_id');
    }

    // Define the relationship for appointments where the user is the admin
    public function appointmentsAsAdmin()
    {
        return $this->hasMany(Appointment::class, 'admin_id');
    }

    public function available_dates()
    {
        return $this->hasMany(AvailableDate::class);
    }
}
