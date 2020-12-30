<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsInboundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_inbound', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('container_model',100);
            $table->string('bottle_number',100);
            $table->string('vcr',100);
            $table->string('fill_port',100);
            $table->string('vcr_fail',100);
            $table->string('fill_port_fail',100);
            $table->string('M1',100);
            $table->string('M2',100);
            $table->string('A1',100);
            $table->string('A2',100);
            $table->string('A3',100);
            $table->string('M1_fail',100);
            $table->string('M2_fail',100);
            $table->string('A1_fail',100);
            $table->string('A2_fail',100);
            $table->string('A3_fail',100);
            $table->string('M1_valve',100);
            $table->string('M2_valve',100);
            $table->string('A1_valve',100);
            $table->string('A2_valve',100);
            $table->string('A3_valve',100);
            $table->string('M1_valve_fail',100);
            $table->string('M2_valve_fail',100);
            $table->string('A1_valve_fail',100);
            $table->string('A2_valve_fail',100);
            $table->string('A3_valve_fail',100);
            $table->string('IN_1',100);
            $table->string('IN_2',100);
            $table->string('OUT',100);
            $table->string('IN_1_fail',100);
            $table->string('IN_2_fail',100);
            $table->string('OUT_fail',100);
            $table->string('work_id',100);
            $table->string('table_id',100);
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
        Schema::dropIfExists('container_records_inbound');
    }
}
