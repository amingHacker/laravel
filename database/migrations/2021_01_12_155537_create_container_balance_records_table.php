<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContainerBalanceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlbalance')-> create('container_balance_records', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('working_date')->nullable()->default(null);
            $table->string('founder',100);
            $table->string('material_number',100);
            $table->string('customer',100);
            $table->string('original_container',100);
            $table->string('additives_number',100);
            $table->string('TSMC_remark',100);
            $table->string('order_weight',100);
            $table->string('product_batch_number',100);
            $table->string('bottle_number',100);
            $table->string('container_base_weight_ideal',100);
            $table->string('container_base_weight_real',100);
            $table->string('container_base_weight_operator',100);
            $table->string('container_doing_weight_ideal',100);
            $table->string('container_doing_weight_real',100);
            $table->string('container_doing_weight_air',100);
            $table->string('container_doing_weight_operator',100);
            $table->string('container_packaging_weight_ideal',100);
            $table->string('container_packaging_weight_real',100);
            $table->string('container_packaging_weight_operator',100);
            $table->string('container_addpackaging_weight_ideal',100);
            $table->string('container_addpackaging_weight_real',100);
            $table->string('container_addpackaging_weight_operator',100);
            $table->string('remark',100);
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
        Schema::dropIfExists('container_balance_records');
    }
}
