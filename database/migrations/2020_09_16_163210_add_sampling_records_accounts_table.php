<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSamplingRecordsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sampling_records_accounts', function (Blueprint $table) {
            $table->string("SPC_Group_Name", 50)->after('User_Email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sampling_records_accounts', function (Blueprint $table) {
            //
        });
    }
}
