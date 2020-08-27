<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductSpecTmalTmaltwTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_spec_tmal_tmaltw', function (Blueprint $table) {
            $table->string("Spec_EG_Micron_tight", 50)->after('ELEMENT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_spec_tmal_tmaltw', function (Blueprint $table) {
            //
        });
    }
}
