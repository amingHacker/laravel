<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSublimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sublimations', function (Blueprint $table) {
            $table->string("Impurity_A", 50)->after('judge');
            $table->string("Impurity_B", 50)->after('Impurity_A');
            $table->string("Impurity_C", 50)->after('Impurity_B');
            $table->string("Impurity_D", 50)->after('Impurity_C');
            $table->string("Impurity_E", 50)->after('Impurity_D');
            $table->string("Impurity_F", 50)->after('Impurity_E');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sublimations', function (Blueprint $table) {
            //
        });
    }
}
