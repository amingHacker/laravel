<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteProductSpecTmalTmalegTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_spec_tmal_tmaleg', function (Blueprint $table) {
            $table->dropColumn('Spec_EG_Micron_tight');
            $table->dropColumn('Micron_Singapore');
            $table->dropColumn('TW_Micron');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_spec_tmal_tmaleg', function (Blueprint $table) {
            //
        });
    }
}
