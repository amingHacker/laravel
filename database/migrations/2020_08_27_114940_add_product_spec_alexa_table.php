<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductSpecAlexaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_spec_alexa', function (Blueprint $table) {
            $table->string("ALEXA-447FN-200g_TSMC_CL", 50)->after('ALEXA_TSMC_Spec_EG_TSMC_tight');
            $table->string("ALEXA-447FN-300g_TSMC_CL", 50)->after('ALEXA-447FN-200g_TSMC_CL');
            $table->string("ALEXA-447FN-400g_TSMC_CL", 50)->after('ALEXA-447FN-300g_TSMC_CL');
            $table->string("ALEXA-447FN-300g_UMC_Spec", 50)->after('ALEXA-447FN-400g_TSMC_CL');
            $table->string("ALEXA-447FN-600g_SMIC_Spec", 50)->after('ALEXA-447FN-300g_UMC_Spec');
            $table->string("ALEXATW_TSMC_CL_ICP_OES", 50)->after('ALEXA-447FN-600g_SMIC_Spec');
            $table->string("ALEXATW_TSMC_CL_ICP_MS", 50)->after('ALEXATW_TSMC_CL_ICP_OES');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_spec_alexa', function (Blueprint $table) {
            //
        });
    }
}
