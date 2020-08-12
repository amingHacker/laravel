<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplingRecordsPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sampling_records_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Group_Name',100);
            $table->string('Add',50);
            $table->string('Edit',50);
            $table->string('Delete',50);
            $table->string('Import',50);
            $table->string('Export',50);
            $table->string('Admin',50);
            $table->string('View_Log',50);
            $table->string('ProductSPEC',50);
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
        //
    }
}
