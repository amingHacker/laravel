<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerGdspTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_gdsp', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('Sampling_date')->nullable()->default(null);
            $table->string('Equipment',50);
            $table->string('StandardBottle', 50);
            $table->string('ProductName', 50);
            $table->string('LeftMonitor_A3', 50);
            $table->string('RightMonitor_A3', 50);
            $table->string('A3', 50);
            $table->string('LeftBody_A3', 50);
            $table->string('RightBody_A3', 50);
            $table->string('Body', 50);
            $table->string('Operator', 50);
            $table->string('Remark', 255);
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
        Schema::dropIfExists('container_gdsp');
    }
}
