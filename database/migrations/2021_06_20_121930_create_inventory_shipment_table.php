<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlinventory')->create('inventory_shipment', function (Blueprint $table) {
            $table->string('Delivery',100);
            $table->string('Sales_Organization',100);
            $table->string('Reference_document',100);
            $table->string('Sold_to_party',100);
            $table->string('Name_of_sold_to_party',100);
            $table->string('Ship_to_party',100);
            $table->string('Name_of_the_ship_to_party',100);
            $table->dateTime('Goods_Issue_Date')->nullable()->default(null);
            $table->dateTime('Deliv_date')->nullable()->default(null);
            $table->dateTime('Act_Gds_Mvmnt_Date')->nullable()->default(null);
            $table->string('Ship_Material',100);
            $table->string('Description',100);
            $table->string('Ship_Batch',100);
            $table->string('Delivery_quantity',100);
            $table->string('Sales_unit',100);
            $table->string('Net_weight',100);
            $table->string('Total_Weight',100);
            $table->string('Item_category',100);
            $table->string('Ship_Plant',100);
            $table->string('Delivery_Type',100);
            $table->string('Ship_Storage_Location',100);
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
        Schema::dropIfExists('inventory_shipment');
    }
}
