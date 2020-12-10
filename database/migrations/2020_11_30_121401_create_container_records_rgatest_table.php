<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsRgatestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_rgatest', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('container_model',100);
            $table->string('bottle_number',100);
            $table->string('vacuum_value',100);
            $table->string('vacuum_equipment_limit',100);
            $table->string('spec',100);
            $table->string('H2O',100);
            $table->string('N2',100);
            $table->string('O2',100);
            $table->string('CO2',100);
            $table->string('Acetone',100);  //丙酮
            $table->string('Pentane',100);  //戊烷
            $table->string('He',100);
            $table->string('spectro_equipment_limit',100);
            $table->string('spectro_equipment_spec',100);
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
        Schema::dropIfExists('container_records_rgatest');
    }
}
