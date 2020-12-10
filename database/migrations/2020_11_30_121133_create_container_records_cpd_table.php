<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsCpdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_cpd', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('container_model',100);
            $table->string('bottle_number',100);
            $table->string('pipe_calibration',100);
            $table->string('calibration_fail',100);
            $table->string('bypass_1',100);
            $table->string('bypass_2',100);
            $table->string('bypass_fail',100);
            $table->string('body_1',100);
            $table->string('body_2',100);
            $table->string('body_fail',100);
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
        Schema::dropIfExists('container_records_cpd');
    }
}
