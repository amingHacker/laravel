<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsAssemblingtestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_assemblingtest', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('container_model',100);
            $table->string('bottle_number',100);
            $table->string('oven_temperature',100);
            $table->string('oven_time',100);
            $table->dateTime('start_time')->nullable()->default(null);
            $table->dateTime('end_time')->nullable()->default(null);
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
        Schema::dropIfExists('container_records_assemblingtest');
    }
}
