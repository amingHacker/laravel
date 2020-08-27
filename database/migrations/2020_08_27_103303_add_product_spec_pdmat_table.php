<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductSpecPdmatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_spec_pdmat', function (Blueprint $table) {
            $table->string("PDMATA_Spec_TA_TSMC_CL", 50)->after('PDMAT_TSMC_CL_EG_TSMC_tight');
            $table->string("PDMAT7_Spec_T7_TSMC_CL", 50)->after('PDMATA_Spec_TA_TSMC_CL');
            $table->string("PDMATW_Spec_TW_TSMC_CL", 50)->after('PDMAT7_Spec_T7_TSMC_CL');
            $table->string("PDMAEG_Spec_EG_UMC", 50)->after('PDMATW_Spec_TW_TSMC_CL');
            $table->string("PDMATW_Spec_TW_SMIC", 50)->after('PDMAEG_Spec_EG_UMC');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_spec_pdmat', function (Blueprint $table) {
            //
        });
    }
}
