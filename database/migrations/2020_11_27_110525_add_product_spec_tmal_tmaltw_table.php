<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductSpecTmalTmaltwTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_spec_tmal_tmaltw', function (Blueprint $table) {
            $table->string("Spec_TW_TSMC_tight_OES", 50)->after('Spec_TW_TSMC_tight_MS');
            $table->string("TSMC_L1481501_OES", 50)->after('TSMC_L1481501_MS');
            $table->string("TSMC_L1481512_OES", 50)->after('TSMC_L1481512_MS');
            $table->string("TSMC_L1481650_OES", 50)->after('TSMC_L1481650_MS');
            $table->string("Micron_GlobalSpecProposal_OES", 50)->after('Micron_GlobalSpecProposal_MS');
            $table->string("SAFCTW_OES", 50)->after('SAFCTW_MS');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_spec_tmal_tmaltw', function (Blueprint $table) {
            //
        });
    }
}
