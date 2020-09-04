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
            $table->string("Hf", 50)->after('Cl');
            $table->string("H2O", 50)->after('Hf');
            $table->string("0_0ppm", 50)->after('Organic_impurity');
            $table->string("DMAH", 50)->after('IR_A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sampling_records', function (Blueprint $table) {
            //
        });
    }
}
