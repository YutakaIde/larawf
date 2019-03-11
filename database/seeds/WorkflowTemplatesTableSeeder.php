<?php

use Illuminate\Database\Seeder;

class WorkflowTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workflow_templates')->insert([
            'name' => 'workflow1',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
}
