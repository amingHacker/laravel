<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsOutboundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_outbound', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('container_model',100);
            $table->string('bottle_number',100);
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
        Schema::dropIfExists('container_records_outbound');
    }
}
