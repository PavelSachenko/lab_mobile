<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('faculties')->insert([
            ['title' => 'FIT', 'created_at' => date('Y-m-d H:i:s')],
            ['title' => 'FEMP', 'created_at' => date('Y-m-d H:i:s')],
            ['title' => 'FTM', 'created_at' => date('Y-m-d H:i:s')],
            ['title' => 'FRGTB', 'created_at' => date('Y-m-d H:i:s')],
            ['title' => 'FFO', 'created_at' => date('Y-m-d H:i:s')],
            ['title' => 'FMTP', 'created_at' => date('Y-m-d H:i:s')],
        ]);
    }
}
