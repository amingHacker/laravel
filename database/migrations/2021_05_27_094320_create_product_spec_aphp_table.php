<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecAphpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_spec_aphp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ELEMENT',100);
            $table->string('APHP_Micron',100);
            $table->string('APHP_TSMC',100);
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
        Schema::dropIfExists('product_spec_aphp');
    }
}
