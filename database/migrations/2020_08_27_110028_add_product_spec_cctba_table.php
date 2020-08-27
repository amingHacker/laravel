<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductSpecCctbaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_spec_cctba', function (Blueprint $table) {
            $table->string("CCTBAN5-447FN-200g_TSMC_CL", 50)->after('CCTBA-447FN-200g_TSMC_CL');
            $table->string("CCTBA-447FN-200g_UMC_Spec", 50)->after('CCTBAN5-447FN-200g_TSMC_CL');
            $table->string("CCTBA-447FN-200g_SMIC_general_Spec", 50)->after('CCTBA-447FN-200g_UMC_Spec');
            $table->string("CCTBA-598FN-500g_TSMC_CL", 50)->after('CCTBA-447FN-200g_SMIC_general_Spec');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_spec_cctba', function (Blueprint $table) {
            //
        });
    }
}
