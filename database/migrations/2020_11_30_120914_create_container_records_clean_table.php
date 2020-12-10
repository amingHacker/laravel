<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerRecordsCleanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_records_clean', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('container_model',100);
            $table->string('bottle_number',100);
            $table->string('conductivity_test',100);
            $table->string('equipment_limit',100);
            $table->string('spec',100);
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
        Schema::dropIfExists('container_records_clean');
    }
}
