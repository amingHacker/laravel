<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecTmalTmaltwTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_spec_tmal_tmaltw', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ELEMENT',100);
            $table->string('TSMC_L1481501',100);
            $table->string('TSMC_L1481512',100);
            $table->string('TSMC_L1481650',100);
            $table->string('Micron_GlobalSpecProposal',100);
            $table->string('SAFCTW',100);
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
        Schema::dropIfExists('product_spec_tmal_tmaltw');
    }
}
