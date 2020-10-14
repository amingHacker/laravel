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
            $table->string('OriginalPipe', 50);
            $table->string('OriginalA3', 50);
            $table->string('OriginalBody', 50);
            $table->string('ProductName', 50);
            $table->string('LeftMonitor_PipeCorrection', 50);
            $table->string('RightMonitor_PipeCorrection', 50);
            $table->string('PipeCorrection', 50);
            $table->string('LeftMonitor_A3', 50);
            $table->string('RightMonitor_A3', 50);
            $table->string('A3', 50);
            $table->string('LeftMonitor_Body', 50);
            $table->string('RightMonitor_Body', 50);
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
