<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrindingovensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grindingovens', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('Filling_Date')->nullable()->default(null);
            $table->string('sap_batch',100);
            $table->string('sap_batch_actual_assay',100);
            $table->string('sap_batch_actual_meo',100);
            $table->string('Op',100);
            $table->string('serial_number',100);
            $table->string('Main_bubbler_tank',100);
            $table->string('1st_bulk_batch',100);
            $table->string('1st_bulk_wt',100);
            $table->string('1st_tank_batch',100);
            $table->string('2nd_bulk_batch',100);
            $table->string('2nd_bulk_wt',100);
            $table->string('2nd_tank_batch',100);
            $table->string('3rd_bulk_batch',100);
            $table->string('3rd_bulk_wt',100);
            $table->string('3rd_tank_batch',100);
            $table->string('1st_bulk_assay',100);
            $table->string('1st_bulk_meo',100);
            $table->string('2nd_bulk_assay',100);
            $table->string('2nd_bulk_meo',100);
            $table->string('3rd_bulk_assay',100);
            $table->string('3rd_bulk_meo',100);
            $table->string('expect_assay',100);
            $table->string('expect_meo',100);
            $table->string('PDMAT_g',100);
            $table->string('s_75um',100);
            $table->string('grinding_time_h',100);
            $table->string('glove_box',100);
            $table->string('input_system_oxygen',100);
            $table->string('output_system_oxygen',100);
            $table->string('input_system_moisture',100);
            $table->string('output_system_moisture',100);
            $table->string('Q_Time',100);
            $table->string('Oven',100);
            $table->string('anneal_seat',100);
            $table->string('0_0_ppm',100);        
            $table->string('Remark',100);
            $table->string('Material',100);
            $table->string('pressure_Drop_Via_bypass',100);
            $table->string('pressure_Drop_Via_body',100);
    
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
        Schema::dropIfExists('grindingovens');
    }
}
