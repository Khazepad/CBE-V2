<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::create(['role_name' => 'Students']);
        Role::create(['role_name' => 'Admin']);
        Role::create(['role_name' => 'Program_director']);
    }
}
