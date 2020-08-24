<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSamplingRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sampling_records', function (Blueprint $table) {
            $table->string("equipment_name", 100)->after('IR_A');
            $table->string("standard_solution", 100)->after('equipment_name');
            $table->string("sampling_kind", 100)->after('standard_solution');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
