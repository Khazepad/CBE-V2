<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('programs')->insert([
            ['name' => 'BSA'],
            ['name' => 'BSMA'],
            ['name' => 'BSBA'],
            ['name' => 'BSOA'],
            ['name' => 'BSREM'],
            ['name' => 'BSTM'],
            ['name' => 'BSHM'],
            ['name' => 'BSCA'],

        ]);
    }
}
