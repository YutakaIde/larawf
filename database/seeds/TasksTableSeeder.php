<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('tasks')->insert([
            'workflow_id' => 1,
            'name' => 'task1',
            'type' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tasks')->insert([
            'workflow_id' => 1,
            'name' => 'task2',
            'type' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tasks')->insert([
            'workflow_id' => 1,
            'name' => 'task3',
            'type' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tasks')->insert([
            'workflow_id' => 1,
            'name' => 'end',
            'type' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
