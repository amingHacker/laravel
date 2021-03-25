<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryInstockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlinventory')->create('inventory_instock', function (Blueprint $table) {
            $table->string('Material',50);
            $table->string('Material_Description',50);
            $table->string('Material_Type',50);
            $table->string("Plant", 50);
            $table->string("Storage_Location", 50);
            $table->string('Descr_of_Storage_Loc',50);
            $table->string('DF_stor_loc_level',50);
            $table->string('Batch',50);
            $table->string('Base_Unit_of_Measure',50);
            $table->string('Unrestricted',50);
            $table->string('Stock_Segment',50);
            $table->string('Currency',50);
            $table->string('Value_Unrestricted',50);
            $table->string('Transit_and_Transfer',50);
            $table->string('Val_in_Trans_Tfr',50);
            $table->string('In_Quality_Insp',50);
            $table->string('Value_in_QualInsp',50);
            $table->string('Restricted_Use_Stock',50);
            $table->string('Value_Restricted',50);
            $table->string('Blocked',50);
            $table->string('Value_BlockedStock',50);
            $table->string('Returns',50);
            $table->string('Value_Rets_Blocked',50);
            $table->string('Valuated_Goods_Receipt_Blocked_Stock',50);
            $table->string('Val_GR_Blocked_St',50);
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
        Schema::dropIfExists('inventory_instock');
    }
}
