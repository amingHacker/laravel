<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameProductSpecTmalTmaltwTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_spec_tmal_tmaltw', function (Blueprint $table) {
            $table->renameColumn('Spec_TW_TSMC_tight', 'Spec_TW_TSMC_tight_MS');
            $table->renameColumn('TSMC_L1481501', 'TSMC_L1481501_MS');
            $table->renameColumn('TSMC_L1481512', 'TSMC_L1481512_MS');
            $table->renameColumn('TSMC_L1481650', 'TSMC_L1481650_MS');
            $table->renameColumn('Micron_GlobalSpecProposal', 'Micron_GlobalSpecProposal_MS');
            $table->renameColumn('SAFCTW', 'SAFCTW_MS');
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
