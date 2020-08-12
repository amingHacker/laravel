<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolventRemovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solvent_removals', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('solid_Started')->nullable()->default(null);
            $table->string('tank_batch',100);
            $table->string('Crude_assay',100);
            $table->string('Crude_2_2ppm',100);
            $table->string('crude_batch',100);
            $table->string('Line',100);
            $table->string('sol_expect_wt',100);
            $table->string('end_Temp',100);
            $table->string('solvent_Input',100);
            $table->string('solid_output',100);
            $table->string('cycle_Time',100);
            $table->string('solid_yield',100);
            $table->string('output_system_oxygen',100);
            $table->string('glove_box',100);
            $table->string('output_time_spent',100);
            $table->string('solid_consumed_1',100);
            $table->string('solid_consumed_2',100);
            $table->string('solid_consumed_3',100);
            $table->string('solid_consumed_4',100);
            $table->string('solid_consumed_5',100);
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
        Schema::dropIfExists('_solvent_removals');
    }
}
