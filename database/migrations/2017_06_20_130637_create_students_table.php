<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('age')->unsigned()->default(18)->commit('年龄');
            $table->integer('sex')->unsigned()->default(10)->commit('性别');
            $table->integer('create_at')->unsigned()->default(0)->commit('创建时间');
            $table->integer('update_at')->unsigned()->default(0)->commit('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('students');
    }
}
