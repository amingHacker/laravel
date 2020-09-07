<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSolventRemovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('solvent_removals', function (Blueprint $table) {
            $table->string("Crude_3_8ppm", 50)->after('Crude_2_2ppm');
            $table->string("Crude_4_0ppm", 50)->after('Crude_3_8ppm');
            $table->string("Crude_223840", 50)->after('Crude_4_0ppm'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('solvent_removals', function (Blueprint $table) {
            //
        });
    }
}
