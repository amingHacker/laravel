<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSublimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sublimations', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('bulk_started')->nullable()->default(null);
            $table->string('remark',100);
            $table->string('1st_crude_batch',100);
            $table->string('1st_crude_wt',100);
            $table->string('1st_tank_batch',100);
            $table->string('2nd_crude_batch',100);
            $table->string('2nd_crude_wt',100);
            $table->string('2nd_tank_batch',100);
            $table->string('3rd_crude_batch',100);
            $table->string('3rd_crude_wt',100);
            $table->string('3rd_tank_batch',100);
            $table->string('bulk_batch',100);
            $table->string('bulk_actual_assay',100);
            $table->string('bulk_actual_meo',100);
            $table->string('judge',100);
            $table->string('glove_box',100);
            $table->string('mantle',100);
            $table->string('PLC_status',100);
            $table->string('input_op',100);
            $table->string('solid_input',100);
            $table->string('output_op',100);
            $table->string('bulk_output',100);
            $table->string('bulk_yield',100);
            $table->string('input_system_oxygen',100);
            $table->string('pre_system_Pump',100);
            $table->string('pre_system_torr',100);
            $table->string('output_system_oxygen',100);        
            $table->string('top_Mantle_end',100);
            $table->string('top_Tapes_end',100);
            $table->string('top_Coolant_end',100);
            $table->string('top_Turbo_end',100);
            $table->string('top_Oxygen_end',100);            
            $table->string('main_Mantle_end',100);
            $table->string('main_Tapes_end',100);
            $table->string('main_Coolant_end',100);
            $table->string('main_Turbo_end',100);
            $table->string('main_Oxygen_end',100);  
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
        Schema::dropIfExists('sublimations');
    }
}
