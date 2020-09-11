<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplingRecordsAbnormaleventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampling_records_abnormalevent', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('Happened_time', 0);
            $table->string('Status',50);
            $table->string('SamplingRecords_ID',100);
            $table->string('Product_SPEC',50);
            $table->longText('Abnormal_Event');
            $table->string('QC_USER', 100);
            $table->longText('QC_Comment');
            $table->string('PD_USER', 100);
            $table->longText('PD_Comment');
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
        Schema::dropIfExists('sampling_records_abnormalevent');
    }
}
