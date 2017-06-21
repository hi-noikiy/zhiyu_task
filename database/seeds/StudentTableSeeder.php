<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('students')->insert([
            ['name' => 'mc1', 'age' => 19],
            ['name' => 'mc2', 'age' => 20],
        ]);
    }
}
