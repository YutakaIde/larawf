<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkflowLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workflow_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('workflow_id');
            $table->integer('task_id');
            $table->string('type');
            $table->string("stdout",2000)->nullable();
            $table->string("stderr",2000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workflow_logs');
    }
}
