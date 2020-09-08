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
            //
            $table->string("solid_consumed_6", 50)->after('solid_consumed_5');
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
