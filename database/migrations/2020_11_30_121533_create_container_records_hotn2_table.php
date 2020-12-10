<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsHotn2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_hotn2', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('container_model',100);
            $table->string('bottle_number',100);
            $table->string('dew_point',100);
            $table->string('dew_point_equipment_limit',100);
            $table->string('dew_point_equipment_spec',100);
            $table->string('water_content',100);
            $table->string('dew_point_equipment_limit_trans',100);
            $table->string('dew_point_equipment_spec_trans',100);
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
        Schema::dropIfExists('container_records_hotn2');
    }
}
