<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        // Add other fillable fields as needed
    ];

    // Define relationships if any
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
