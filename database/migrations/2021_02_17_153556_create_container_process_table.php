<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_process', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bottle_number',100);
            $table->string('Company',100);
            $table->string('Product_Grade',100);
            $table->dateTime('Return_Date')->nullable()->default(null);
            $table->string('Residual_Wt',100);
            $table->string('Sign',100);
            $table->dateTime('Working_Date')->nullable()->default(null);
            $table->string('Station1_Checked',100);
            $table->string('member1',100);
            $table->dateTime('time1')->nullable()->default(null);
            $table->string('Station2_Checked',100);
            $table->string('member2',100);
            $table->dateTime('time2')->nullable()->default(null);
            $table->string('Station3_TypeInValue',100);
            $table->string('member3',100);
            $table->dateTime('time3')->nullable()->default(null);
            $table->string('Station4_Checked',100);
            $table->string('member4',100);
            $table->dateTime('time4')->nullable()->default(null);
            $table->string('Station5_Checked',100);
            $table->string('working_period',100);
            $table->string('member5',100);
            $table->dateTime('time5')->nullable()->default(null);
            $table->string('Station6_Value',100);
            $table->string('member6',100);
            $table->dateTime('time6')->nullable()->default(null);
            $table->string('Station7_Value',100);
            $table->string('member7',100);
            $table->dateTime('time7')->nullable()->default(null);
            $table->string('Station8_Value',100);
            $table->string('member8',100);
            $table->dateTime('time8')->nullable()->default(null);
            $table->string('Station9_Pump',100);
            $table->string('Station9_TakenTime',100);
            $table->string('member9',100);
            $table->dateTime('time9')->nullable()->default(null);
            $table->string('Station10_Value',100);
            $table->string('Station10_TypeInValue',100);
            $table->string('member10',100);
            $table->dateTime('time10')->nullable()->default(null);
            $table->string('Station11_Checked',100);
            $table->string('member11',100);
            $table->dateTime('time11')->nullable()->default(null);
            $table->string('Station12_TypeInValue',100);
            $table->string('member12',100);
            $table->dateTime('time12')->nullable()->default(null);
            $table->string('Station13_Checked',100);
            $table->string('member13',100);
            $table->dateTime('time13')->nullable()->default(null);
            $table->string('Station14_Checked',100);
            $table->string('member14',100);
            $table->dateTime('time14')->nullable()->default(null);
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
        Schema::dropIfExists('container_process');
    }
}
