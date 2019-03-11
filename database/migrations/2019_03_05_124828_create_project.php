<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');  // 主キー
            $table->string("name", 64);
            $table->string("currentPlace", 64)->nullable();
            $table->integer("workflow_id");
            $table->timestamps();      // created_at と updated_at カラムの作成.
        });
    }


    /**
     * Reverse the migrations.
     *

     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
