<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service', function (Blueprint $table) {
            $table->tinyInteger('type', false)->nullable()->after('price')->comment('增值服务类型 1表示任务 2表示商店服务');
            $table->decimal('price', 10, 2)->change()->comment('增值服务价格');
            $table->string('identify', 100)->nullable()->after('type')->comment('唯一标识');
        });

        Schema::table('nav', function (Blueprint $table){
            $table->string('code_name')->default('')->after('is_show')->comment('');
        });

        Schema::table('user_detail', function (Blueprint $table){
            $table->integer('employee_num', false)->default(0)->after('alternate_tips')->comment('累计雇佣量');
            $table->integer('employee_praise_rate', false)->default(0)->change();
            $table->integer('employer_praise_rate', false)->default(0)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
