<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplingRecordsMyfavoritechartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampling_records_myfavoritecharts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('MUID',20);
            $table->string('ChartNum',5);
            $table->string('_search',10);
            $table->string('nd',20);
            $table->string('limit',20);
            $table->string('pageNum', 50);
            $table->string('sidx', 50);
            $table->string('order', 20);
            $table->string('filters', 255);
            $table->string('SearchField', 50);
            $table->string('SearchString', 255);
            $table->string('SearchOper', 100);
            $table->string('ChartCondition', 255);
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
        Schema::dropIfExists('sampling_records_myfavoritecharts');
    }
}
