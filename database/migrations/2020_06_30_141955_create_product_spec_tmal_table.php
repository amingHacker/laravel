<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecTmalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_spec_tmal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ELEMENT',100);
            $table->string('TMALEPU_EPU',100);
            $table->string('TMALLO_LO',100);
            $table->string('TMALOT_OT',100);
            $table->string('TMAL4LED_4LED',100);
            $table->string('TMALPG_PG',100);
            $table->string('TMALEG_EG',100);
            $table->string('EMMA_TSMCCL',100);
            $table->string('TMALforN5_TSMCCL',100);
            $table->string('TMALTW_TW',100);
            $table->string('TMALEP_EP',100);
            $table->string('TMALUM_ProposedSpec',100);
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
        Schema::dropIfExists('product_spec_tmal');
    }
}
