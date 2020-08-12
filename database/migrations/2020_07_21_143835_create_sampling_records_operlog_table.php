<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplingRecordsOperlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampling_records_operlog', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('added_on', 0);
            $table->string('user',100);
            $table->string('action',50);
            $table->longText('description');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sampling_records_operlog');
    }
}
