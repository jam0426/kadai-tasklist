<?php

use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++){
            DB::table('tasks')->insert([
               'content' => 't_c' . $i,
               'status' => 't_s' . $i
            ]);
        }
    }
}
