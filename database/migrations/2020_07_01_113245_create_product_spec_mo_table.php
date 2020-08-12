<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecMoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_spec_mo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ELEMENT',100);
            $table->string('TMG_AG',100);
            $table->string('TMG_EP',100);
            $table->string('TMG_LEDC',100);
            $table->string('TMG_LEDP',100);
            $table->string('TMG_SP',100);
            $table->string('TMG_SE',100);
            $table->string('TMIN_EP',100);
            $table->string('TMIN_forOsram',100);
            $table->string('TEG_AG_EP',100);
            $table->string('TEG_SE',100);
            $table->string('TEG_Osram',100);
            $table->string('CPMG_AG_EP',100);
            $table->string('DXZN_AG_EP',100);
            $table->string('CBR4_AG_EP',100);
            $table->string('BTCM_EG',100);
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
        //
    }
}
