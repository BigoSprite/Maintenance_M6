<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CommonDevice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create('common_device', function (Blueprint $table){
            $table->increments('id');// 主键 自增
            $table->string('deviceName', 20);
            $table->string('deviceTypeName', 20);
            $table->string('serialId', 20);
            $table->integer('protocolVersion');
            $table->string('protocolRemark', 20);
            $table->string('mobileNumber', 20);
            $table->char('installDirection', 1);
            $table->smallInteger('controllerAddress');
            $table->char('controllerAddress', 1);
            $table->char('isDiscard', 1);
            $table->timestamp('addData');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
