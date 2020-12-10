<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsSpecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_spec', function (Blueprint $table) {
            $table->increments('id');
            $table->string('container_model',100);
            $table->string('Conductivity',100);
            $table->string('Oven_Temperature',100);
            $table->string('Oven_Time',100);
            $table->string('Outbound_M1',100);
            $table->string('Outbound_M2',100);
            $table->string('Outbound_A1',100);
            $table->string('Outbound_A2',100);
            $table->string('Outbound_A3',100);
            $table->string('CPD_Bypass_1',100);
            $table->string('CPD_Bypass_2',100);
            $table->string('CPD_Body_1',100);
            $table->string('CPD_Body_2',100);
            $table->string('Inbound_VCR',100);
            $table->string('Inbound_FillPort',100);
            $table->string('Inbound_M1',100);
            $table->string('Inbound_M2',100);
            $table->string('Inbound_A1',100);
            $table->string('Inbound_A2',100);
            $table->string('Inbound_A3',100);
            $table->string('Inbound_M1_Valve',100);
            $table->string('Inbound_M2_Valve',100);
            $table->string('Inbound_A1_Valve',100);
            $table->string('Inbound_A2_Valve',100);
            $table->string('Inbound_A3_Valve',100);
            $table->string('Inbound_IN_1',100);
            $table->string('Inbound_IN_2',100);
            $table->string('Inbound_OUT',100);
            $table->string('PP_Pump',100);
            $table->string('PP_Time',100);
            $table->string('PP_Cycle',100);
            $table->string('RGA_Vacuum',100);
            $table->string('RGA_H2O',100);
            $table->string('RGA_N2',100);
            $table->string('RGA_O2',100);
            $table->string('RGA_CO2',100);
            $table->string('RGA_Acetone',100);
            $table->string('RGA_Pentane',100);
            $table->string('RGA_He',100);
            $table->string('HotN2_DewPoint',100);
            $table->string('HotN2_WaterContent',100);
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
        Schema::dropIfExists('container_records_spec');
    }
}
